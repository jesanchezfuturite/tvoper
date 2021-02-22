<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Routing\UrlGenerator;


class Estados extends Command
{
    protected $url;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obtener:Estados';

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
    public function __construct(
        UrlGenerator $url
    )
    {
        parent::__construct();
        $this->url = $url;
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
            $path = $this->url->to('/') . '/wsent/qa';
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->get(
                $path
	    	);

            Log::info("actualización de la base de datos de estados");

        }catch (\Exception $e){
            Log::info('Error console/Estados-> Method getEstados: '.$e->getMessage());
        	
        }
    }
}
