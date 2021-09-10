<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Routing\UrlGenerator;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;
use SoapClient;
use SimpleXMLElement;
use App\Entities\PortalSolicitudesTicket;

// repositorios para afectar la base de datos

use App\Repositories\PortalTramitesRepositoryEloquent;
use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\EstadosRepositoryEloquent;
use App\Repositories\MunicipiosRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;

class ApiController extends Controller
{
    protected $key ;

    protected $url;

    protected $defined_key = 'X8x7+QUsij2zTquc5ZsrDnBcZU7A4guF8uK8iPmj2w=';

    protected $catastro_url = "";
    protected $catastro_url_reg = "";

	protected $insumos_url 	= 'https://insumos.nl.gob.mx/api/url';
	protected $insumos_auth = 'https://insumos.nl.gob.mx/api/auth';
	protected $insumos_user = "mayela_irc";
	protected $insumos_pass = "prueba1234";

	protected $insumos_curp = "https://insumos.nl.gob.mx/api/consultacurp";
	protected $insumos_auth_produccion = 'https://insumos.nl.gob.mx/api/auth';

  protected $insumos_montop = 'https://insumos.nl.gob.mx/api/catastro_expediente';

	// registro publico
	protected $ws_rp = array(
		"qa" 	=> "http://10.1.0.130:240/wsfolrpp/NR173",
		"prod" 	=> "http://10.1.0.130:240/wsfolrpp/MARISOLGZZ",
	);

	//entidades

	protected $ws_ent = array(
		"qa" => "http://10.1.0.130:10087/web/services/WSCATEFService/WSCATEF",
		"prod"=> "",

	);

	//municipios

	protected $ws_mun = array(
		"qa" => "http://10.1.0.130:10087/web/services/WSCATMUNSService/WSCATMUNS",
		"prod"=> "",

	);


	//distritos esta pendiente

	protected $ws_dis = array(
		"qa" => "",
		"prod"=> "",

	);


	// repos
    protected $solicitudes_tramite;
	protected $tickets;
    protected $estados;
	protected $campos;
	protected $municipios;
	protected $usernotary;

	protected $expediente_catastral_id = 32;
	protected $solicitudes_aviso_id = 71;

	protected $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(
    	PortalTramitesRepositoryEloquent $solicitudes_tramite,
        PortalSolicitudesTicketRepositoryEloquent $tickets,
		UrlGenerator $url,
        EstadosRepositoryEloquent $estados,
		PortalcampoRepositoryEloquent $campos,
		MunicipiosRepositoryEloquent $municipios,
		PortalConfigUserNotaryOfficeRepositoryEloquent $usernotary
    )
    {

        $this->catastro_url_reg = env("URL_CATASTRO_REGISTRO");
        $this->catastro_url = env("URL_CATASTRO");

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
			$this->solicitudes_tramite 	= $solicitudes_tramite;
			$this->tickets 				= $tickets;
            $this->estados 				= $estados;
			$this->campos  				= $campos;
			$this->municipios 			= $municipios;
			$this->usernotary 			= $usernotary;

            // obtengo la url para
            $this->url = $url;           

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


    /**
     * Registrar tramites de catastro (Aviso de Enajenacion y IVC)
     *
     * @param 
     *
     *
     * @return 
     */

    public function catastro_registro(Request $request)
    {
        // $response = ['code'=>400,'response'=>'','message'=>''];
        // return csrf_token();
        $body = $request->getContent();
        $data = json_decode($body);
        $json = isset($data->json) ? $data->json : "";

        if(empty($json))
            return response()->json(['response'=>'','message'=>'Sin informacion para continuar.'],400,$this->header,JSON_UNESCAPED_UNICODE);

        $expediente = isset($json->expedientecatastral) ? $json->expedientecatastral : "";
        $pktramite = isset($json->pktramite) ? $json->pktramite : "0";
        $pknotaria = isset($json->pknotaria) ? $json->pknotaria : 0;
        $estadonotaria = isset($json->estadonotaria) ? $json->estadonotaria : "";
        $foliopago = isset($json->foliopago) ? $json->foliopago : 0;
        $fechapago = isset($json->fechapago) ? $json->fechapago : "";
        $montopago = isset($json->montopago) ? $json->montopago : 0;
        $tipoventa = isset($json->tipoventa) ? $json->tipoventa : "";
        $isai = isset($json->isai) ? $json->isai : 0;
        $fechaprot = isset($json->fechaprot) ? $json->fechaprot : '0000-00-00';
        $fechafirma = isset($json->fechafirma) ? $json->fechafirma : '0000-00-00';
        $escriturapub = isset($json->escriturapub) ? $json->escriturapub : "";
        $actafprot = isset($json->actafprot) ? $json->actafprot : "";
        $operacion = isset($json->operacion) ? $json->operacion : 0;
        $motivooperacion = isset($json->motivooperacion) ? $json->motivooperacion : "";
        $adquirientes = isset($json->adquirientes) ? $json->adquirientes : [];
        $folioforma = isset($json->folioforma) ? $json->folioforma : "";
        $descripcion_predio = isset($json->descripcion_predio) ? $json->descripcion_predio : "";
        $vendedores = isset($json->vendedores) ? $json->vendedores : [];
        
        if(empty($expediente) || empty($pktramite) || empty($pknotaria)) 
            return response()->json(['response'=>'','message'=>'Faltan parametros de registro.'],400,$this->header,JSON_UNESCAPED_UNICODE);

        if(!in_array($pktramite, ["15","9"]))
            return response()->json(['response'=>'','message'=>'Id tramite incorrecto'],400,$this->header,JSON_UNESCAPED_UNICODE);

        if(strcmp($pktramite,"15") == 0) // INFORMATIVO
        {   
            if(empty($foliopago) || empty($fechapago) || empty($montopago) || empty($estadonotaria))
                return response()->json(['response'=>'','message'=>'Faltan parametros para informativo'],400,$this->header,JSON_UNESCAPED_UNICODE);
            else
            {
                try {
                    $this->client = new \GuzzleHttp\Client();

                    $elements = 'expedientecatastral='.$expediente;
                    $elements.= '&pktramite='.$pktramite;
                    $elements.= '&pknotaria='.$pknotaria;
                    $elements.= '&foliopago='.$foliopago;
                    $elements.= '&fechapago='.$fechapago;
                    $elements.= '&montopago='.$montopago;
                    $elements.= '&estadonotaria='.$estadonotaria;

                    $url = $this->catastro_url_reg . '?' . $elements;
                    
                    $response = $this->client->request('GET',$url);

                    if($response->getStatusCode() == 200)
                    {
                        $body = $response->getBody()->getContents();
                        try {
                            if(substr(utf8_decode($body), 0, 1) == '?') $body = substr(utf8_decode($body), 1);
                            $body = json_decode($body);
                        } catch (Error $err) { }
                        return response()->json(['response'=>$body,'message'=>'OK'],200,$this->header,JSON_UNESCAPED_UNICODE);
                    }
                    else
                        return response()->json(['response'=>$body,'message'=>''],$response->getStatusCode(),$this->header,JSON_UNESCAPED_UNICODE);

                } catch (\Exception $e) {
                    return response()->json(['response'=>'','message'=>$e->getMessage()],400,$this->header,JSON_UNESCAPED_UNICODE);
                    // dd($e->getMessage());
                }
            }
        }

        if(strcmp($pktramite,"9") == 0) // AVISO DE ENAJENACION
        {
        	// dd("foliopago => ", $foliopago, "fechapago => ", $fechapago, "montopago => ", $montopago, "estadonotaria => ", $estadonotaria);
            if(empty($foliopago) || empty($fechapago) || empty($estadonotaria))
                return response()->json(['response'=>'','message'=>'Faltan parametros para aviso de enajenacion'],400,$this->header,JSON_UNESCAPED_UNICODE); 
            else 
            {
                try {
                    $this->client = new \GuzzleHttp\Client();

                    if((int)$operacion == 0 && empty($motivooperacion))
                        return response()->json(['response'=>'','message'=>'Obligatorio el motivo de la operacion si la operacion del monto es 0'],400,$this->header,JSON_UNESCAPED_UNICODE);

                    if(empty($actafprot) && empty($escriturapub))
                        return response()->json(['response'=>'','message'=>'Obligatorio acta fuera de protocolo o escritura publica'],400,$this->header,JSON_UNESCAPED_UNICODE);

                    $elements = 'expedientecatastral='.$expediente;
                    $elements.= '&pktramite='.$pktramite;
                    $elements.= '&pknotaria='.$pknotaria;
                    $elements.= '&estadonotaria='.$estadonotaria;
                    $elements.= '&tipoventa='.$tipoventa;
                    $elements.= '&isai='.$isai;
                    $elements.= '&fechaprot='.$fechaprot;
                    $elements.= '&fechafirma='.$fechafirma;
                    if(!empty($actafprot) && empty($escriturapub)) $elements.= '&actafprot='.$actafprot;
                    if(empty($actafprot) && !empty($escriturapub)) $elements.= '&escriturapub='.$escriturapub;
                    $elements.= '&operacion='.$operacion;
                    $elements.= '&motivo_operacion='.$motivooperacion;
                    $elements.= '&folio_forma='.$folioforma;
                    $elements.= '&descripcion_predio='.$descripcion_predio;
                    $elements.= '&adquirientes='.urlencode(serialize($adquirientes));
                    $elements.= '&vendedores='.urlencode(serialize($vendedores));

                    $url = $this->catastro_url_reg . '?' . $elements;
                    // dd($url);
                    
                    $response = $this->client->request('GET',$url);

                    if($response->getStatusCode() == 200)
                    {
                        $body = $response->getBody()->getContents();
                        return response()->json(['response'=>$body,'message'=>'OK'],200,$this->header,JSON_UNESCAPED_UNICODE);
                    }
                    else
                        return response()->json(['response'=>$body,'message'=>''],$response->getStatusCode(),$this->header,JSON_UNESCAPED_UNICODE);
                    
                } catch (\Exception $e) {
                    return response()->json(['response'=>'','message'=>$e->getMessage()],400,$this->header,JSON_UNESCAPED_UNICODE);
                }
            }

        }

    }


 /**
     * Consultar entidad
     *
     * @param clave de acceso
     *
     *
     * @return void
     */

    public function entidades(Request $request)
    {
     	try
		  {

			$origen = $request->origen;

			$url = $this->ws_ent[$origen];


			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsc="http://wscatef.wsbeans.iseries/">
			<soapenv:Header/>
			<soapenv:Body>
				<wsc:soapwscatef>
					<arg0>
						<ACCESO>MARISOL3004</ACCESO>
					</arg0>
				</wsc:soapwscatef>
			</soapenv:Body>
			</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
			$xml = new SimpleXMLElement($response);
			$body = $xml->xpath('//soapBody')[0];
			$array = json_decode(json_encode((array)$body), TRUE);


			foreach ($array["ns2soapwscatefResponse"]["return"]["WEFLISTA"] as $key => $value) {
				$estados = $this->estados->updateOrCreate(["clave" =>$value['WEFCLAVE']], [
					'clave' => $value['WEFCLAVE'],
					'nombre' => $value['WEFNOMBRE']
				]);
			}

			return json_encode(
				[
					"response" 	=> "Estados actualizados",
					"code"		=> 200
				]);





       }catch (\Exception $e){
                dd($e->getMessage());

       }
	}
	 /**
     * Consultar municipio
     *
     * @param clave de acceso
     *
     *
     * @return void
     */

	public function municipios(Request $request)
    {
     	try
		  {
			$origen = $request->origen;

			$EntidadFed =$request->clave_entidad;

			$url = $this->ws_mun[$origen];


			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsc="http://wscatmuns.wsbeans.iseries/">
			<soapenv:Header/>
			<soapenv:Body>
				<wsc:soapwscmuns>
					<arg0>
						<ACCESO>MARISOL3004</ACCESO>
						<WENTIDADFED>'.$EntidadFed.'</WENTIDADFED>
					</arg0>
				</wsc:soapwscmuns>
			</soapenv:Body>
			</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);

			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
			$xml = new SimpleXMLElement($response);
			$body = $xml->xpath('//soapBody')[0];
			$array = json_decode(json_encode((array)$body), TRUE);


			foreach ($array["ns2soapwscmunsResponse"]["return"]["WMUNSLISTA"] as $key => $value) {
				$municipios = $this->municipios->firstOrNew([
					'clave' => $value["WMUNSCLAVE"],
					'clave_estado' => $EntidadFed,
					'nombre'=>$value["WMUNSNOMBRE"]

				]);

				$municipios->save();

			}

			return json_encode(
				[
					"response" 	=> "Municipios actualizados",
					"code"		=> 200
				]);



       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }
	 /**
     * Consultar distritos
     *
     * @param clave de acceso
     *
     *
     * @return void
     */

	public function distritos(Request $request)
    {
     	try
		  {
			$origen = $request->origen;

			$Mun =$request->clave_municipio;

	        $url = $this->ws_mun[$origen].'/'.$Mun;

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

	public function curp($curp){
		try
        {
			$key = $this->consultar_token();
			$url = $this->insumos_curp.'?access_token='.$key.'&curp='.$curp;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch);

			curl_close($ch);
			$response =json_decode($response);
			foreach ($response->data as $key => &$value) {
				if($value==[]){
					$value="";
				}
			}
			return json_encode($response);


        }catch (\Exception $e){
        	dd($e->getMessage());
        }
	}


    /**
     * Consultar todos los tramites que tenga una notaria de valor
     * catastral sin aviso de enajenacion
     *
     * @param notaria
     *
     *
     * @return void
     */

    public function getValorCatastral(Request $request)
    {

        // $path = $this->url->to('/') . '/notary-offices-get-users/' . $request->id;

        $notary_users = array();

        $informativo_id = 3;

        $campos = $this->campos->all();

        $fields = array();

        foreach($campos as $f)
        {
            $fields[$f->id]= $f->descripcion;
        }

        try
        {
			$results = app()->call('App\Http\Controllers\PortalNotaryOfficesController@getUsers', [$request->id]);

            if(count($results) > 0)
            {
                foreach($results as $i => $v)
                {
                    // guardamos los id de usuarios
                    $notary_users []= $v->id;
                }
            }else{
                return json_encode(
                    [
                        "code" => 401,
                        "message" => "Notary has not user associated"
                    ]
                );
            }

            $tramites_notaria = $this->tickets
                ->whereIn('user_id' ,$notary_users)
                ->where('catalogo_id',$informativo_id)
                ->get();

            if($tramites_notaria->count() > 0)
            {
                $response = array();
                $campos =array();
                foreach($tramites_notaria as $tn){
                    if(isset($tn->info)){            
                        $info=$this->claves($tn->info);
                        $campos[$tn->id]=$info->campos;
                    }
                   
                   
                    // $node = json_decode($tn->info);

                    // $in = $node->campos;

                    // $new = array();
                    // //dd($in);
                    // foreach($in as $i => $j)
                    // {
                    //     $new[$i] = array(
                    //         "field" => $fields[$i],
                    //         "value" => $j,
                    //     );
                    // }

                    // unset($node->campos);

                    // $node->campos= (object)$new;

				}
                    $response[]= (array)$campos;


                return json_encode($response,JSON_UNESCAPED_SLASHES);
            }else{
                return json_encode(
                [
                    "code" => 402,
                    "message" => "La notaria no tiene tramites de Informativo Valor Catastral"
                ]
            );
            }


        }catch (\Exception $e){
            return json_encode(
                [
                    "code" => 400,
                    "message" => $e->getMessage()
                ]
            );


        }
    }
	public function consultar_token(){
		$this->client = new \GuzzleHttp\Client();

	    	$response = $this->client->post(
	    		$this->insumos_auth_produccion,
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

			return  $results->token;
	}
  /**
	 * Regresa el valor del monto de operación correspondiente al folio informativo ingresado
	 * @param expediente catastral
	 * @param folio folio informativo
	 * @param id_notaria Id de la notaria en la que se hace el trámite
	 * @return data
	 */
  public function getMontoOperacion(Request $request){

    $expediente = $request->expediente;
    $folio = $request->folio;
    $id_notaria = $request->id_notaria;

    $url = $this->insumos_montop ."?expediente=".$expediente."&folio=".$folio."&notaria=".$id_notaria;

    try{
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

      return json_encode($results->data);
    }catch(\Exception $e){

    }
  }

	/********************* Metodos para validar **********************************/

	/**
	 *
	 * Regresa el total de avisos de enajenacion de un expediente catastral
	 *
	 * @param expediente catastral
	 *
	 *
	 * @return listado de tickets
	 *
	 *
	 */

	public function getTicketsAviso(Request $request)
	{

		$ec 	= $request->expediente;

		$tramite = $request->tramite;

		$users = $this->getUsersbyID($request->userid);

		$campos = $this->campos->all();

		$fields = array();

        foreach($campos as $f)
        {
            $fields[$f->id]= $f->descripcion;
        }

		// buscar las solicitudes del aviso de enajenacion de la notaria
		$solicitudes = PortalSolicitudesTicket::leftJoin('solicitudes_tramite', 'solicitudes_ticket.id_transaccion', '=', 'solicitudes_tramite.id')
			->where('solicitudes_ticket.catalogo_id',$tramite)
			->whereIn('solicitudes_ticket.user_id', $users)
			->whereIn('solicitudes_tramite.estatus', [0, 60])
			->get();



		if($solicitudes->count() > 0)
        {
            $response = array();

            foreach($solicitudes as $tn){

                $node = json_decode($tn->info);

                $in = $node->campos;

                $new = array();
                //dd($in);
                foreach($in as $i => $j)
                {
                    $new[$i] = array(
                        "field" => $fields[$i],
                        "value" => $j,
                    );
                }

                unset($node->campos);

                $node->campos= (object)$new;

                $response[]= (array)$node;
			}


            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }else{
			return json_encode(
                [
                    "code" => 402,
                    "message" => "No hay solicitudes de aviso de enajenacion" 
				]);
		}

	}


	private function getUsersbyID($id)
	{
		$users = $this->usernotary->findWhere(["user_id" => $id]);

		foreach($users as $u){

			$notary = $u->notary_office_id;
		}

		$users = $this->usernotary->findWhere(["notary_office_id" => $notary]);

		foreach($users as $u){
			$response []= $u->user_id;
		}

		return $response;

	}

	private function toJSON($check){
		parse_str($check, $parse);
		return $parse;
	}

    public function claves($info){
        $informacion = json_decode($info);
        $campos = [];
        if(isset($informacion->campos)){
          foreach($informacion->campos as $key=>$value){
            if(is_numeric($key)){
              $catalogo= $this->campos->select('descripcion')->where('id',$key)->first();
              $campos[$catalogo->descripcion] = $value;
            }else{
              $campos[$key] = $value;
            }
    
          }
          $informacion->campos = $campos;
        }
    
        return $informacion;
      }


}
