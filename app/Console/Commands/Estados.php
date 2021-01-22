<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;


class Estados extends Command
{
    protected $url_estados = "http://10.153.144.228/wsent/qa";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:Estados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza la tabla de estados mendiante una api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getEstados();
        
    }

    public function getEstados(){
        try
        {
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->get(
	    		$this->url_estados	
	    	);

            Log::info("actualización de la base de datos de estados");

        }catch (\Exception $e){
            Log::info('Error console/Estados-> Method getEstados: '.$e->getMessage());
        	
        }
    }
}
