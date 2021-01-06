<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;

// repositorios para afectar la base de datos

use App\Repositories\PortalTramitesRepositoryEloquent;

class ApiController extends Controller
{
    protected $key ;

    protected $defined_key = 'X8x7+QUsij2zTquc5ZsrDnBcZU7A4guF8uK8iPmj2w=';

    protected $catastro_url = 'http://10.150.130.96/WSCatastro/json/index.php';

	protected $insumos_url 	= 'http://insumos.test.nl.gob.mx/api/url';
	protected $insumos_auth = 'http://insumos.test.nl.gob.mx/api/auth';
	protected $insumos_user = "fun1";
	protected $insumos_pass = "prueba123";

	// registro publico
	protected $ws_rp = array(
		"qa" 	=> "http://10.1.0.130:240/wsfolrpp/NR173",
		"prod" 	=> "http://10.1.0.130:240/wsfolrpp/MARISOLGZZ",
	);



	// repos
	protected $solicitudes_tramite;


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(
    	PortalTramitesRepositoryEloquent $solicitudes_tramite
    )
    {
        
        // inicializamos el api de insumos
        try
        {
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->post(
	    		$this->insumos_auth,
	    		[
	    			"form_params" => 
		    			[
			    			"username" => $this->insumos_user,
			    			"password" => $this->insumos_pass,
		    			]
	    		]	
	    	);

	    	$results = $response->getBody();

			$results = json_decode($results);	

			$this->key = $results->token;

			// inicializamos los repos necesarios
			$this->solicitudes_tramite = $solicitudes_tramite;

        }catch (\Exception $e){
        	dd($e->getMessage());
        }

    }

    /**
     * Cambiar el estatus de las transacciones
     * 
     * @param transaccion, estatus y key
     *
     *
     * @return void
     */

    public function cambiaEstatusTransaccion(Request $request)
    {
    	$transaccion 	= $request->transaccion;
    	$estatus 		= $request->estatus;
    	$key_status 	= $request->key;

    	if(strcmp($key_status,$this->defined_key) == 0)
    	{
    		// revisar si existe la transaccion
    		$busqueda = $this->solicitudes_tramite->findWhere( ["id_transaccion_motor" => $transaccion] );

    		if($busqueda->count() == 1)
    		{
    			foreach($busqueda as $b)
    			{
    				$id = $b->id;
    			}
    			// actualizar el estatus
    			try{
    				
    				$this->solicitudes_tramite->update(
    					[
    						"estatus" => $estatus
    					],
    					$id
    				);

    				return json_encode(
		    			[
		    				"response" 	=> "Status updated",
		    				"code"		=> 200
		    			]);

    			}catch( \Exception $e ){
    				return json_encode(
	    			[
	    				"response" 	=> "Error al actualizar - " . $e->getMessage(),
	    				"code"		=> 402
	    			]	
    			);
    			}

    		}else{
    			return json_encode(
	    			[
	    				"response" 	=> "Existen el mismo numero de transaccion en mas de un registro",
	    				"code"		=> 401
	    			]	
    			);
    		}

    	}else{
    		return json_encode(
    			[
    				"response" 	=> "La llave es incorrecta",
    				"code"		=> 400
    			]	
    		);
    	}



    }

    /**
     * Consultar boleta de registro publico de la propiedad
     * 
     * @param clave de acceso
     *
     *
     * @return void
     */

    public function registro_publico(Request $request)
    {
        try
        {
        	$origen = $request->origen;

        	$url = $this->ws_rp[$origen];
       
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->post(
	    		$url	
	    	);

	    	$results = $response->getBody();

		$r = json_decode($results);

		return response()->json($r);

        }catch (\Exception $e){
        	dd($e->getMessage());
        	
        }
    }

    /**
     * Consultar expediente de catastro
     * 
     * @param expediente
     *
     *
     * @return void
     */

    public function catastro_consulta(Request $request)
    {
    	$expediente = $request->expediente;

    	$url = $this->catastro_url . "?expediente_catastral=" . $expediente;

    	// inicializamos el api de insumos
        try
        {
	        $this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->get(
	    		$this->insumos_url,
	    		[
	    			"query" => 
		    			[
		    				"method"		=> "GET",
			    			"url" 			=> $url,
			    			"access_token"	=> $this->key 
		    			]
	    		]	
	    	);

	    	$results = $response->getBody();

			$results = json_decode($results);	

			return json_encode($results->data[0]);

        }catch (\Exception $e){
        	dd("url",$url,"access_token",$this->key,$results,$e->getMessage());
        	
        }
    }





}
