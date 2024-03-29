<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;
use App\Repositories\OperanomaliasestatusRepositoryEloquent;
use App\Repositories\OperanomaliasRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;


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

    protected $bankName;

    protected $bankAlias;

    protected $executedDate;

    protected $cuentasbanco;

    protected $bank_details;

    protected $info_cuenta;

    protected $anomaliasbd;

    protected $transaccionesdb;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ProcessedregistersRepositoryEloquent $ps,
        BancoRepositoryEloquent $banco,
        CuentasbancoRepositoryEloquent $cuentasbanco,
        OperanomaliasRepositoryEloquent $anomaliasbd,
        TransaccionesRepositoryEloquent $transaccionesdb
    )
    {
        parent::__construct();

        // cargar el archivo de configuracion con los datos por banco
        $this->files = config('conciliacion.conciliacion_conf');

        // instancia del repositorio para guardar los valores de los archivos
        $this->ps = $ps;

        $this->banco = $banco;

        $this->cuentasbanco = $cuentasbanco;

        $this->anomaliasbd = $anomaliasbd;

        $this->transaccionesdb = $transaccionesdb;

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

            if(is_array($config))
            {

                $temporal = explode('_', $filename);

                $this->bankName = $temporal[0];

                $this->bankAlias = $temporal[1];

                $this->executedDate = substr($temporal[2],0,4) . "-" . substr($temporal[2],4,2) . "-" . substr($temporal[2],6,2);
            
                $this->info_cuenta = $this->obtenerDetallesCuenta($this->bankAlias,$this->bankName);


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
                    if(strcmp($startFrom,"S")==0)
                    {
                        $condition = 2;
                    }
                    if(strcmp($startFrom,"1") == 0)
                    {
                        $condition = 3;
                    }
                }
                
                if($condition == 0 && $current_line == 1 && $startFrom == 2)
                {
                    $condition = 1;   
                }
                
                if($condition == 0)
                {
                    $line   = fgets($fo);   
                }

                if($condition == 1)
                {
                    $line   = fgets($fo);
                    $haltV  = 1;

                    if(strlen($line) > 50)
                    {
                        if($origenStart == 0 && $origenLength == 0 && $referenciaStart == 0 && $referenciaLength == 0)
                        {
                            $origen     = 1;
                            $referencia = (strcmp($this->bankName,"bancomer") == 0) ? (int)substr($line, $idStart, $idLength) : "";
                            $monto = substr($line, $amountStart, $amountLength);
                        }else{
                            
                            $origen     = substr($line, $origenStart, $origenLength);
                            $referencia = substr($line, $referenciaStart, $referenciaLength);

                            if(strcmp($this->bankName,"bancomerV") == 0){
                                $monto = substr($line, $amountStart, $amountLength);    
                            }else{
                                $monto = substr($line, $amountStart, $amountLength) / 100;    
                            }

                            // quitar las comisiones de santander
                            if(strcmp($this->bankName,"santanderV") == 0){
                                $validacion_cargo = substr($line, 76,1);
                                if(strcmp($validacion_cargo,'-') == 0){
                                    $haltV = 9;
                                }              
                            }

                            
                        }
                         if($this->bankName=='netPay')
                        {
                             if(strlen(substr($line, $idStart, $idLength)) == 8)
                             {
                                $origen='01';
                             }else{
                                $origen     = substr($line, $origenStart, $origenLength);
                             }                          
                        }
                        if($haltV == 1) // esto se agrego para validar los cargos de comision en los archivos
                        {
                            $data =
                                [
                                    "day"               => substr($line, $dayStart, $dayLength),
                                    "month"             => substr($line, $monthStart, $monthLength),
                                    "year"              => substr($line, $yearStart, $yearLength),
                                    "monto"             => $monto,
                                    "transaccion_id"    => substr($line, $idStart, $idLength),
                                    "status"            => "np",
                                    "filename"          => $filename,
                                    "origen"            => $origen,
                                    "referencia"        => $referencia,
                                    "cuenta_banco"      => $this->info_cuenta["cuenta"],
                                    "cuenta_alias"      => $this->info_cuenta["cuenta_alias"],
                                    "banco_id"          => $this->info_cuenta["banco_id"],
                                    "fecha_ejecucion"   => $this->executedDate,
                                    "facturado"         => 0,
                                ];

                
                            try{ 
                                $this->ps->create( $data );
                                $this->anomaliasProceseed($data); 
                                $this->anomaliasMontoDif($data);
                            }catch( \Exception $e ){
                                Log::info('[Conciliacion:ProcessFiles] - Error(1) al guardar registros en oper_processedregisters'.$e);    
                            }
                        } 
                    }
                }

                if($condition == 2 || $condition == 3)
                {
                    $line   = fgets($fo);
                    $bScotia=false;
                    if($this->bankName=='scotiabank')
                    {
                        if(strcmp(substr($line, 1,1), "2") == 0)
                        {
                            $bScotia=true;
                        }                           
                    }
                    if($this->bankName=="banamexV")
                    {   
                         $transaccion_id=substr($line, 57, 10);
                         $referencia=substr($line, $referenciaStart, $referenciaLength);
                        log::info($transaccion_id);
                        if(strcmp(substr($transaccion_id, 0,1), "2") == 0 && strcmp(substr($referencia, 0,2), "11") == 0)
                        {
                            $transaccion_id= substr($line, 57, 10);
                        }else{
                            $transaccion_id=substr($line, $idStart, $idLength);
                        }
                    }else{
                            $transaccion_id=substr($line, $idStart, $idLength);
                    }
                    if(
                        strcmp(substr($line, 0,1), "D") == 0 || // condicion afirmeVentanilla
                        $bScotia == true                     || // condicion scotiabank  
                        strcmp(substr($line, 0,1), "2") == 0 || // condicion banorteV 
                        strcmp(substr($line, 0,1), "1") == 0 // condicion banamexVentanilla
                    )
                    {
                        if(strcmp($this->bankName,"bazteca") == 0){
                            $monto = substr($line, $amountStart, $amountLength);    
                        }else{
                            $monto = substr($line, $amountStart, $amountLength) / 100;    
                        }
                
                        $data =
                            [
                                "day"            => substr($line, $dayStart, $dayLength),
                                "month"          => substr($line, $monthStart, $monthLength),
                                "year"           => substr($line, $yearStart, $yearLength),
                                "monto"          => $monto,
                                "transaccion_id" => $transaccion_id,
                                "status"         => "np",
                                "filename"       => $filename,
                                "origen"         => substr($line, $origenStart, $origenLength),
                                "referencia"     => substr($line, $referenciaStart, $referenciaLength),
                                "cuenta_banco"   => $this->info_cuenta["cuenta"],
                                "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                                "banco_id"   => $this->info_cuenta["banco_id"],
                                "fecha_ejecucion"   => $this->executedDate,
                                "facturado"         => 0,
                            ];

                        try{

                            if((int)$data["transaccion_id"] > 0)
                            {
                                $this->ps->create( $data );
                                $this->anomaliasProceseed($data); 
                                $this->anomaliasMontoDif($data);
                                
                            }

                        }catch( \Exception $e ){
                            Log::info('[Conciliacion:ProcessFiles] - Error(2) al guardar registros en oper_processedregisters');    
                        } 

                    }
                     
                }


                
                $current_line++;
            }
        }

        $this->backupfilesprocessed("app/".$filename);

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
                            "banco_id"          => $this->info_cuenta["banco_id"],
                            "fecha_ejecucion"   => $this->executedDate,
                            "facturado"         => 0,
                        ];

                    try{

                        if((int)$data["transaccion_id"] > 0)
                        {
                            $this->ps->create( $data );
                            $this->anomaliasProceseed($data); 
                            $this->anomaliasMontoDif($data);
                        }

                    }catch( \Exception $e ){
                        Log::info('[Conciliacion:ProcessFiles] - Error(3) al guardar registros en oper_processedregisters');    
                    } 

                }
 
                $current_line++;
            }
        }

        /**/

        $this->backupfilesprocessed("app/".$filename);

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
                                "referencia"     => substr($info[$id],0,8),
                                "cuenta_banco"   => $this->info_cuenta["cuenta"],
                                "cuenta_alias"   => $this->info_cuenta["cuenta_alias"],
                                "banco_id"   => $this->info_cuenta["banco_id"],
                                "fecha_ejecucion"   => $this->executedDate,
                                "facturado"         => 0,
                            ];

                        try{

                            if((int)$data["transaccion_id"] > 0)
                            {
                                $this->ps->create( $data );
                                $this->anomaliasProceseed($data); 
                                $this->anomaliasMontoDif($data);
                            }

                        }catch( \Exception $e ){
                            Log::info('[Conciliacion:ProcessFiles] - Error(4) al guardar registros en oper_processedregisters');    
                        }     
                    }
                    

                }
 
                $current_line++;
            }
        }

        $this->backupfilesprocessed("app/".$filename);

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
                                "fecha_ejecucion"   => $this->executedDate,
                                "facturado"         => 0,
                            ];

                        try{

                            if((int)$data["transaccion_id"] > 0)
                            {
                                $this->ps->create( $data );
                                $this->anomaliasProceseed($data); 
                                $this->anomaliasMontoDif($data);
                            }

                        }catch( \Exception $e ){
                            Log::info('[Conciliacion:ProcessFiles] - Error(4) al guardar registros en oper_processedregisters');    
                        }     
                    }        
                }
                
                $current_line++;
            }
        }

        $this->backupfilesprocessed("app/".$filename);

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

        $name = explode("_", $filename);

        $name = $name[0];

        $validNames = $this->files;

        $valid = false;

        foreach($validNames as $v => $d)
        {
            $valor = (int)strcmp($v,$name);
            if($valor == 0)
            {
                $valid = array("file" => $v, "config" => $d);
                return $valid;
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

    private function obtenerDetallesCuenta($alias,$bankname)
    {
        $cuenta = false;
        // obtener los datos de las cuentas
        //log::info($bankname);
        if($bankname=='bazteca')
        {
            $bankname='Banco Azteca';
        }
        //log::info($this->bank_details);
        foreach( $this->bank_details as $bd )
        {
            if($alias == $bd["cuenta_alias"] and strtolower(substr($bankname,0,4)) ==strtolower(substr($bd["banco"],0,4)))
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
        $bancos = $this->banco->findWhere( [ "conciliacion" => 1 ]);

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
        //log::info($info);
        foreach($info as $i => $data)
        {   
            //log::info($data);
            if($data<>null || $data<>"")
            {
                 foreach($data as $f){
                    $final []= array(
                    "cuenta" => $f->cuenta,
                    "alias"  => $f->alias
                    );
                }
            }
            
        }

        return $final;

    }

    /**
     * Backupfiles uploaded 
     *
     * @param null $path = "app/".$filename
     *
     * @return array with x => [account => , alias =>] 
     */ 

    private function backupfilesprocessed($path)
    {
        try
        {
            $destination = 'app/Processed/';

            $ex = explode("/",$path);

            $destination .= $ex[2];

            $path = storage_path($path);

            $destination = storage_path($destination);

            File::move($path, $destination);
        
        }catch( \Exception $e ){
            Log::info("[Conciliacion:ProcessFiles] Error Method backupfilesprocessed => " . $e->getMessage());
            Log::info("[Conciliacion:ProcessFiles] path => " . $path);
            Log::info("[Conciliacion:ProcessFiles] backup => " . $destination);
        }
    }

    private function anomaliasProceseed($data)
    {
        if($data["origen"]>1){
            $findExist=$this->ps->findWhere(["referencia"=>$data["referencia"]]);
            if($findExist->count()>1)
            {
                //log::info("1");
                $result= $this->anomaliasbd->create([
                    "origen"=>$data["origen"],
                    "id_processed"=>$findExist[$findExist->count()-1]->id,
                    "referencia"=>$data["referencia"],
                    "transaccion_id"=>$data["transaccion_id"],
                    "monto"=>$data["monto"],
                    "banco_id"=>$data["banco_id"],
                    "cuenta_banco"=>$data["cuenta_banco"],
                    "cuenta_alias"=>$data["cuenta_alias"],
                    "fecha_ejecucion"=>$data["fecha_ejecucion"],
                    "fecha_pago"=>$data["year"] . "-" . $data["month"] . "-" . $data["day"],
                    "estatus_anomalia"=>"1"
                ]);
            }
        }else{
            /*$findExist=$this->ps->findWhere([ "transaccion_id"=>$data["transaccion_id"] ]);
            if($findExist->count()>0)
            {
                $this->anomaliasbd->create([
                "origen"=>$data["origen"],
                "referencia"=>$data["referencia"],
                "transaccion_id"=>$data["transaccion_id"],
                "monto"=>$data["monto"],
                "banco_id"=>$data["banco_id"],
                "cuenta_banco"=>$data["cuenta_banco"],
                "cuenta_alias"=>$data["cuenta_alias"],
                "fecha_ejecucion"=>$data["fecha_ejecucion"],
                "fecha_pago"=>$data["year"] . "-" . $data["month"] . "-" . $data["day"],
                "estatus_anomalia"=>"1"
                ]);              
            }*/  
        }
    }
    private function anomaliasMontoDif($data)
    {
        if($data["origen"]=="11"){
            $ex=false;
            $findMonto=$this->transaccionesdb->findTransMonto($data["referencia"]);
            if($findMonto->count()>0)
            {
                foreach ($findMonto as $k) {
                    if((float)$data["monto"]<>(float)$k->monto_transaccion)
                    {
                       $ex=true;  
                    }                  
                }
                if($ex)
                {
                    $this->anomaliasbd->create([
                    "origen"=>$data["origen"],
                    "referencia"=>$data["referencia"],
                    "transaccion_id"=>$data["transaccion_id"],
                    "monto"=>$data["monto"],
                    "banco_id"=>$data["banco_id"],
                    "cuenta_banco"=>$data["cuenta_banco"],
                    "cuenta_alias"=>$data["cuenta_alias"],
                    "fecha_ejecucion"=>$data["fecha_ejecucion"],
                    "fecha_pago"=>$data["year"] . "-" . $data["month"] . "-" . $data["day"],
                    "estatus_anomalia"=>"2"
                    ]);
                }
                
            }else{
                
            }
        }
    }

}
