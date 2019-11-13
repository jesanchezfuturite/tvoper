<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;


class Conciliacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conciliacion:processFiles';

    /**
     *  Este arreglo contiene la configuracion para leer cada archivo que esta 
     *
     *
    */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesa los archivos que se guardan y corresponden a los estados de cuenta bancarios, guarda los resultados en la tabla para procesar y eliminar el archivo de la carpeta storage/app/toProcess';

    /**
     *
     * Declaro la variable de configuración para cargar los datos de los archivo
     *
     */ 
    protected $files;

    protected $ps;

    protected $banco;

    protected $cuentasbanco;

    protected $bank_details;

    protected $info_cuenta;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ProcessedregistersRepositoryEloquent $ps,
        BancoRepositoryEloquent $banco,
        CuentasbancoRepositoryEloquent $cuentasbanco
    )
    {
        parent::__construct();

        // cargar el archivo de configuracion con los datos por banco
        $this->files = config('conciliacion.conciliacion_conf');

        // instancia del repositorio para guardar los valores de los archivos
        $this->ps = $ps;

        $this->banco = $banco;

        $this->cuentasbanco = $cuentasbanco;

        $this->loadBankDetails();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 
        Log::info('[Conciliacion:ProcessFiles] - Inicia el proceso de carga de archivos');

        Log::info('[Conciliacion:ProcessFiles] - Leer los archivos que estan guardados');
        $this->readSavedFiles();

        Log::info('[Conciliacion:ProcessFiles] - Proceso Finalizado');
    
    }


    /**
     * This method allows to bulk the files and loads the table proceso_conciliacion.
     *
     * @return null
     */
    private function readSavedFiles()
    {
        // in this path the file is stored
        $directory = 'toProcess';

        $available_files = Storage::files($directory);

        foreach($available_files as $av)
        {

            $filename = explode("/",$av)[1];
        
            $config = $this->checkValidFilename($filename);

            if($config)
            {

                /*
                modificar para obtener el alias de la cuenta en el nombre de archivo
                */
                $alias_array = explode('_',$filename);
            
                $this->info_cuenta = $this->obtenerDetallesCuenta($alias_array[1]);

                if($this->info_cuenta == false)
                {
                  Log::info('[Conciliacion:ProcessFiles] - FATAL ERROR - El archivo tiene un alias de cuenta no registrado');
                  
                  Log::info('[Conciliacion:ProcessFiles] - Alias ERROR ' . $filename );

                  
                }else{
                    unset($alias_array);

                    // process the file per defined method
                    $method = $config["config"]["method"];
                    
                    switch($method)
                    {
                        case 1: // plain text file
                            $response = $this->processFilePositions($av,$config);
                            break;
                        case 2: // american express
                            $response = $this->processAMEX($av,$config);
                            break;
                        case 3: // american express
                            $response = $this->processBanamex($av,$config);
                            break;
                        case 4: // banorte Cheque
                            $response = $this->processBanorteCheque($av,$config);
                            break;
                        default:
                            // throws an error method undefined
                            Log::info('[Conciliacion:ProcessFiles] - ERROR No existe un metodo para procesar el archivo ingresado, por favor verificar la configuracion de la conciliación');
                            break; 
                    }    
                }

            }else{
                // write an Error log with the FileData
                Log::info('[Conciliacion:ProcessFiles] - FATAL ERROR - Procesando un archivo no configurado, Por favor verificar la carpeta storage/app/toProcess');
            }

        }
        

    }

    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param $filename it is the filename upload in the form 
     *         $config is the file characteristics  
     *
     * @return true if all goes fine / else throws an exception code
     */ 

    private function processFilePositions($filename,$config)
    {
        Log::info('[Conciliacion:ProcessFiles '.$filename.'] - Inicia proceso de lectura y guardado en la tabla oper_processedregisters');
        // open the file
        
        $positions = $config["config"]["positions"];

        $startFrom = $config["config"]["startFrom"];

        $current_line = 0;

        $condition = 0;

        // Lengths
        $dayStart           = $positions["day"][0]; 
        $dayLength          = $positions["day"][1];
        $monthStart         = $positions["month"][0];
        $monthLength        = $positions["month"][1];
        $yearStart          = $positions["year"][0];
        $yearLength         = $positions["year"][1];
        $amountStart        = $positions["amount"][0];
        $amountLength       = $positions["amount"][1];
        $idStart            = $positions["id"][0];
        $idLength           = $positions["id"][1];
        $origenStart        = $positions["origen"][0];
        $origenLength       = $positions["origen"][1];
        $referenciaStart    = $positions["referencia"][0];
        $referenciaLength   = $positions["referencia"][1];

        if($fo = fopen(storage_path("app/".$filename),"r"))
        {

            while( !feof($fo))
            {
                if(is_integer($startFrom) && $current_line == $startFrom)
                {
                    $condition = 1;
 
                }else{
                    // here the specials conditions are checked
                    if(strcmp($startFrom,"D") == 0)
                    {
                        $condition = 2;
                    }
                    if(strcmp($startFrom,"1") == 0)
                    {
                        $condition = 3;
                    }
                }

                if($condition == 1)
                {
                    $line   = fgets($fo);

                    if($origenStart == 0 && $origenLength == 0 && $referenciaStart == 0 && $referenciaLength == 0)
                    {
                        $origen     = 1;
                        $referencia = "";
                        $monto = substr($line, $amountStart, $amountLength);
                    }else{
                        
                        $origen     = substr($line, $origenStart, $origenLength);
                        $referencia = substr($line, $referenciaStart, $referenciaLength);
                        
                        // revisar si es de bancomer 
                        $bankName = explode("_",$filename);

                        if(strcmp($bankName[0],"toProcess/bancomerV") == 0){
                            $monto = substr($line, $amountStart, $amountLength);    
                        }else{
                            $monto = substr($line, $amountStart, $amountLength) / 100;    
                        }

                        
                    }

                    $data =
                        [
                            "day"            => substr($line, $dayStart, $dayLength),
                            "month"          => substr($line, $monthStart, $monthLength),
                            "year"           => substr($line, $yearStart, $yearLength),
                            "monto"          => $monto,
                            "transaccion_id" => substr($line, $idStart, $idLength),
                            "status"         => "np",
                            "filename"       => $filename,
                            "origen"         => $origen,
                            "referencia"     => $referencia,
                            "cuenta_banco"   => $this->info_cuenta["cuenta"],
                            "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                            "banco_id"   => $this->info_cuenta["banco_id"],
                        ];

                    try{

                        if((int)$data["transaccion_id"] > 0)
                        {
                            $this->ps->create( $data );
                        }

                    }catch( \Exception $e ){
                        Log::info('[Conciliacion:ProcessFiles] - Error(1) al guardar registros en oper_processedregisters');    
                    } 
    
                }

                if($condition == 2 || $condition == 3)
                {
                    $line   = fgets($fo);
                    if(
                        strcmp(substr($line, 0,1), "D") == 0 || // condicion afirmeVentanilla
                        strcmp(substr($line, 0,1), "1") == 0 // condicion banamexVentanilla
                    )
                    {
                        $data =
                            [
                                "day"            => substr($line, $dayStart, $dayLength),
                                "month"          => substr($line, $monthStart, $monthLength),
                                "year"           => substr($line, $yearStart, $yearLength),
                                "monto"          => str_replace(".","",substr($line, $amountStart, $amountLength)) / 100,
                                "transaccion_id" => substr($line, $idStart, $idLength),
                                "status"         => "np",
                                "filename"       => $filename,
                                "origen"         => substr($line, $origenStart, $origenLength),
                                "referencia"     => substr($line, $referenciaStart, $referenciaLength),
                                "cuenta_banco"   => $this->info_cuenta["cuenta"],
                                "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                                "banco_id"   => $this->info_cuenta["banco_id"],
                            ];

                        try{

                            if((int)$data["transaccion_id"] > 0)
                            {
                                $this->ps->create( $data );
                            }

                        }catch( \Exception $e ){
                            Log::info('[Conciliacion:ProcessFiles] - Error(2) al guardar registros en oper_processedregisters');    
                        } 

                    }
                     
                }


                
                $current_line++;
            }
        }

        unlink(storage_path("app/".$filename));

        return true;

    }


    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param $filename it is the filename upload in the form 
     *         $config is the file characteristics  
     *
     * @return true if all goes fine / else throws an exception code
     */ 

    private function processAMEX($filename,$config)
    {
        Log::info('[Conciliacion:ProcessFiles '.$filename.'] - Inicia proceso de lectura y guardado en la tabla oper_processedregisters');
        // open the file
        
        $positions = $config["config"]["positions"];

        $startFrom = $config["config"]["startFrom"];

        $current_line = 0;

        $condition = 0;

        // Lengths
        $month    = $positions['month'];
        $day      = $positions['day'];
        $year     = $positions['year'];
        $amount   = $positions['amount'];
        $id       = $positions['id'];

        if($fo = fopen(storage_path("app/".$filename),"r"))
        {

            while( !feof($fo))
            {
                $line   = fgets($fo);
                // checar si la linea comienza con AMEXGWS
                if(strcmp(substr($line, 0,7), "AMEXGWS") == 0 )
                {
                    $info = explode(",",$line);

                    $date = explode("/", $info[$year]);

                    $data =
                        [
                            "day"            => $date[0],
                            "month"          => $date[1],
                            "year"           => $date[2],
                            "monto"          => $info[$amount],
                            "transaccion_id" => $info[$id],
                            "status"         => "np",
                            "filename"       => $filename,
                            "origen"         => 1,
                            "cuenta_banco"   => $this->info_cuenta["cuenta"],
                            "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                            "banco_id"   => $this->info_cuenta["banco_id"],
                        ];

                    try{

                        if((int)$data["transaccion_id"] > 0)
                        {
                            $this->ps->create( $data );
                        }

                    }catch( \Exception $e ){
                        Log::info('[Conciliacion:ProcessFiles] - Error(3) al guardar registros en oper_processedregisters');    
                    } 

                }
 
                $current_line++;
            }
        }

        unlink(storage_path("app/".$filename));

        return true;

    }

    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param $filename it is the filename upload in the form 
     *         $config is the file characteristics  
     *
     * @return true if all goes fine / else throws an exception code
     */ 

    private function processBanamex($filename,$config)
    {
        Log::info('[Conciliacion:ProcessFiles '.$filename.'] - Inicia proceso de lectura y guardado en la tabla oper_processedregisters');
        // open the file
        
        $positions = $config["config"]["positions"];

        $startFrom = $config["config"]["startFrom"];

        $current_line = 0;

        $condition = 0;

        // Lengths
        $month    = $positions['month'];
        $day      = $positions['day'];
        $year     = $positions['year'];
        $amount   = $positions['amount'];
        $id       = $positions['id'];

        if($fo = fopen(storage_path("app/".$filename),"r"))
        {

            while( !feof($fo))
            {
                $line   = fgets($fo);
                // checar si la linea comienza con AMEXGWS
                $info = explode ("|",$line);

                if( count($info) == 10 )
                {
                    if(strcmp($info[7],'A') == 0)
                    {
                        $date = explode("/", $info[$year]);
                        
                        $monto = str_replace(",", "", $info[$amount]);

                        $monto = str_replace(".", "", $monto);


                        $data =
                            [
                                "day"            => $date[0],
                                "month"          => $date[1],
                                "year"           => $date[2],
                                "monto"          => $monto / 100,
                                "transaccion_id" => substr($info[$id],0,8),
                                "status"         => "np",
                                "filename"       => $filename,
                                "origen"         => 1,
                                "cuenta_banco"   => $this->info_cuenta["cuenta"],
                                "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                                "banco_id"   => $this->info_cuenta["banco_id"],
                            ];

                        try{

                            if((int)$data["transaccion_id"] > 0)
                            {
                                $this->ps->create( $data );
                            }

                        }catch( \Exception $e ){
                            Log::info('[Conciliacion:ProcessFiles] - Error(4) al guardar registros en oper_processedregisters');    
                        }     
                    }
                    

                }
 
                $current_line++;
            }
        }

        unlink(storage_path("app/".$filename));

        return true;

    }

    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param $filename it is the filename upload in the form 
     *         $config is the file characteristics  
     *
     * @return true if all goes fine / else throws an exception code
     */ 

    private function processBanorteCheque($filename,$config)
    {
        Log::info('[Conciliacion:ProcessFiles '.$filename.'] - Inicia proceso de lectura y guardado en la tabla oper_processedregisters');
        // open the file
        
        $positions = $config["config"]["positions"];

        $startFrom = $config["config"]["startFrom"];

        $current_line = 0;

        $condition = 0;

        // Lengths
        $month    = $positions['month'];
        $day      = $positions['day'];
        $year     = $positions['year'];
        $amount   = $positions['amount'];
        $id       = $positions['id'];

        if($fo = fopen(storage_path("app/".$filename),"r"))
        {

            while( !feof($fo))
            {
                $line   = fgets($fo);
                // checar si la linea comienza con AMEXGWS
                $info = explode ("|",$line);

                if(count($info) > 1)
                {
                    if((int)$info[2] > 0)
                    {
                        $date = explode("/", $info[$year]);
                        
                        $monto = str_replace("$", "", $info[$amount]);

                        $monto = str_replace(",", "", $monto);

                        $monto = str_replace(".", "", $monto);


                        $data =
                            [
                                "day"            => $date[0],
                                "month"          => $date[1],
                                "year"           => $date[2],
                                "monto"          => $monto / 100,
                                "transaccion_id" => $info[$id],
                                "status"         => "np",
                                "filename"       => $filename,
                                "origen"         => 1,
                                "cuenta_banco"   => $this->info_cuenta["cuenta"],
                                "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                                "banco_id"   => $this->info_cuenta["banco_id"],
                            ];

                        try{

                            if((int)$data["transaccion_id"] > 0)
                            {
                                $this->ps->create( $data );
                            }

                        }catch( \Exception $e ){
                            Log::info('[Conciliacion:ProcessFiles] - Error(4) al guardar registros en oper_processedregisters');    
                        }     
                    }        
                }
                
                $current_line++;
            }
        }

        unlink(storage_path("app/".$filename));

        return true;

    }



    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param $filename it is the filename upload in the form 
     *
     *
     * @return filename and configuration if exists in the files array / else false
     */ 
    private function checkValidFilename($filename)
    {
        /*
        $data = explode(".",$filename);

        $bank_data = $data[0];

        // check the length of the name
        $length = strlen($bank_data);

        $length -= 8;

        $name = substr($bank_data,0,$length);*/

        $name = explode("_", $filename);

        $name = $name[0];

        $validNames = $this->files;

        $valid = false;

        foreach($validNames as $v => $d)
        {
            if(strcmp($v,$name) == 0)
            {
                return array("file" => $v, "config" => $d);
            }
        }

        return $valid;

    }


    /**
     * Get the alias account a returns an array with bank account and alias
     *
     * @param $alias . string provided in the file
     *
     * @return false if error, array with info [account => , alias =>] 
     */ 

    private function obtenerDetallesCuenta($alias)
    {
        $cuenta = false;
        // obtener los datos de las cuentas
        foreach( $this->bank_details as $bd )
        {
            if($alias == $bd["cuenta_alias"])
            {
                $cuenta = $bd;
            }
        }

        return $cuenta;
    }

    /**
     * Loads bancos info loaded in operacion 
     *
     * @param null
     *
     * @return array with x => [account => , alias =>] 
     */ 

    private function loadBankDetails()
    {
        $bancos = $this->banco->all();

        $cuentasbanco = $this->cuentasbanco->all();

        foreach ($bancos as $b)
        {  
            $cuentas = $this->processBankAccounts($b->id,$cuentasbanco);
            foreach($cuentas as $c)
            {
                $details []= array(
                    "banco_id"      => $b->id,
                    "banco"         => $b->nombre,
                    "cuenta"        => $c["cuenta"],
                    "cuenta_alias"  => $c["alias"],
                );
            }
        }

        $this->bank_details = $details;

    }


    /**
     * Returns an array with the accounts from an specific bank
     *
     * @param null
     *
     * @return array with x => [account => , alias =>] 
     */ 

    private function processBankAccounts($bank, $accounts)
    {
        $info = array();
        $final = array();
        foreach ($accounts as $a)
        {
            if($bank == $a->banco_id)
            {
                $info [$a->id]= json_decode($a->beneficiario); 
            }

        }

        foreach($info as $i => $data)
        {   

            foreach($data as $f){
                $final []= array(
                    "cuenta" => $f->cuenta,
                    "alias"  => $f->alias
                );
            }
            
        }

        return $final;

    }

}
