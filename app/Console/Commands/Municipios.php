<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\UrlGenerator;
use App\Repositories\EstadosRepositoryEloquent;
use Illuminate\Support\Facades\Log;


class Municipios extends Command
{
    protected $url;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obtener:Municipios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        UrlGenerator $url,
        EstadosRepositoryEloquent $estados

    )
    {
        parent::__construct();
        $this->url = $url;
        $this->estados = $estados;
       
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getMunicipios();
    }

    public function getMunicipios(){
        try
        {
         $estados = $this->estados->get();
         
         if($estados){
             foreach ($estados as $key => $value) {
                 $this->updateMunicipios($value["clave"]);
             }
         }else{
            Log::info("No hay estados");
         }

        }catch (\Exception $e){
            Log::info('Error console/Estados-> Method getEstados: '.$e->getMessage());
        	
        }
    }

    public function updateMunicipios($id){
        try
        {
            $path = $this->url->to('/') . '/wsmun/qa/' . $id;
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->get(
                $path
	    	);

            Log::info("actualización de la base de datos de municipios");

        }catch (\Exception $e){
            Log::info('Error console/Estados-> Method getMunicipios: '.$e->getMessage());
        	
        }
    }
}
