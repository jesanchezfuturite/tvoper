<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;

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

    protected $pr;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ProcessedregistersRepositoryEloquent $ps
    )
    {
        parent::__construct();

        // cargar el archivo de configuracion con los datos por banco
        $this->files = config('conciliacion.conciliacion_conf');

        // instancia del repositorio para guardar los valores de los archivos
        $this->ps = $ps;
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


        Log::info('[Conciliacion:ProcessFiles] - Actualización de Egobierno.Transacciones');        
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
                // process the file per defined method
                $method = $config["config"]["method"];
                
                switch($method)
                {
                    case 1: // plain text file
                        $response = $this->processFilePositions($av,$config);
                        
                        break;
                    default:
                        // throws an error method undefined
                        Log::info('[Conciliacion:ProcessFiles] - ERROR No existe un metodo para procesar el archivo ingresado, por favor verificar la configuracion de la conciliación');
                        break; 
                }

            }else{
                // write an Error log with the FileData
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
        Log::info('[Conciliacion:ProcessFiles] - Inicia proceso de lectura y guardado en la tabla oper_processedregisters');
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
                    $data =
                        [
                            "day"            => substr($line, $dayStart, $dayLength),
                            "month"          => substr($line, $monthStart, $monthLength),
                            "year"           => substr($line, $yearStart, $yearLength),
                            "monto"          => (int)substr($line, $amountStart, $amountLength) / 100,
                            "transaccion_id" => substr($line, $idStart, $idLength),
                            "status"         => "np",
                            "filename"       => $filename,
                            "origen"         => substr($line, $origenStart, $origenLength),
                            "referencia"     => substr($line, $referenciaStart, $referenciaLength),
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
                                "monto"          => (int)substr($line, $amountStart, $amountLength) / 100,
                                "transaccion_id" => substr($line, $idStart, $idLength),
                                "status"         => "np",
                                "filename"       => $filename,
                                "origen"         => substr($line, $origenStart, $origenLength),
                                "referencia"     => substr($line, $referenciaStart, $referenciaLength),
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
     *
     *
     * @return filename and configuration if exists in the files array / else false
     */ 
    private function checkValidFilename($filename)
    {
        
        $data = explode(".",$filename);

        $bank_data = $data[0];

        // check the length of the name
        $length = strlen($bank_data);

        $length -= 8;

        $name = substr($bank_data,0,$length);

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


}
