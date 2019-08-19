<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // cargar el archivo de configuracion con los datos por banco
        $this->files = config('conciliacion.conciliacion_conf');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 
        Log::info('Enter in Scheduled task conciliacion:ProcessFiles ');
    }


}
