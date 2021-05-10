<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;



class ApircController extends Controller
{
    //
	/**
     * Create a new controller instance.
     *
     * @return void
     */

	protected $prod_url = "10.144.0.186:8080";

	protected $test_url = "10.153.144.39:8080";

	protected $user = "INTERTRAMITE";

	protected $pass = "D3C35332A6232C316E06F8D4C314649F3E8BF39E3682C7DA6AF7C188FF3F5A29578B5E09EC3B0971BB86C9B397E3D20DE658E0C2D5BB6FEDDF38EDF5B22341D3";	

	protected $url;

	protected $token;

    public function __construct()
    {

    	$this->url = $this->test_url;

        // inicializamos el api de insumos
        try
        {
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->post(
	    		$this->url . "/GobiernoNuevoLeon-war/webresources/Autenticacion/validar_credencial",
	    		[
	    			'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
        			'body'    => '{"nombre_usuario":"INTERTRAMITE","pass":"D3C35332A6232C316E06F8D4C314649F3E8BF39E3682C7DA6AF7C188FF3F5A29578B5E09EC3B0971BB86C9B397E3D20DE658E0C2D5BB6FEDDF38EDF5B22341D3"}'
	    		]
	    	);

	    	$results = $response->getBody();

			$results = json_decode($results);

			$this->token = $results->token;

        }catch (\Exception $e){
        	dd($e->getMessage());
        }

    }







    /**
     * Regresa los datos de un acta de nacimiento
     *
     * @param expediente
     *
     *
     * @return void
     */

    public function buscarIndividuo(Request $request)
    {

    	$params = array (
    		"NOMBRE" => "JAIME",
    		"APELLIDO_PATERNO" => "RODRIGUEZ", 
    		"APELLIDO_MATERNO" => "CALDERON",
    		"FECHA_NACI" => "28-12-1957",
    		"CURP" => ""
    	);

    	$url = $this->url . "/GobiernoNuevoLeon-war/webresources/RegistroCivil/buscar_individuo";

    	// inicializamos el api de insumos
        try
        {
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->post(
	    		$url,
	    		[
	    			'headers' => [
	    				'Content-Type' => 'application/json', 
	    				'Accept' => 'application/json',  
	    				'Authorization' => 'Bearer ' . $this->token,
	    			],
	    			'body' 	  => json_encode($params)
	    		]
	    	);

	    	$results = $response->getBody();

			$results = json_decode($results);

			return response()->json($results->data[0]);
			

        }catch (\Exception $e){
        	dd($e->getMessage());

        }
    }
}
