<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use File;
use Illuminate\Support\Str;
use App\Repositories\ServaccesopartidasRepositoryEloquent;
use App\Repositories\ServpartidasRepositoryEloquent;
use App\Repositories\ServproyectoprogramasRepositoryEloquent;
use App\Repositories\EntidadtramiteRepositoryEloquent;
use App\Repositories\EntidadRepositoryEloquent;
use App\Repositories\ServdetalleaportacionRepositoryEloquent;

class ServiciosgeneralesController extends Controller
{
	protected $servaccesopartidasdb;
	protected $servpartidasdb;
	protected $servproyectoprogramasdb;
	protected $entidadtramitedb;
	protected $entidaddb;
	protected $servdetalleaportaciondb;

	public function __construct( 
    	ServaccesopartidasRepositoryEloquent $servaccesopartidasdb,
    	ServpartidasRepositoryEloquent $servpartidasdb,
    	ServproyectoprogramasRepositoryEloquent $servproyectoprogramasdb,
    	EntidadtramiteRepositoryEloquent $entidadtramitedb,
    	EntidadRepositoryEloquent $entidaddb,
    	ServdetalleaportacionRepositoryEloquent $servdetalleaportaciondb

    ){
    	$this->middleware('auth');
		$this->servaccesopartidasdb=$servaccesopartidasdb;
		$this->servpartidasdb=$servpartidasdb;
		$this->servproyectoprogramasdb=$servproyectoprogramasdb;
		$this->entidadtramitedb=$entidadtramitedb;
		$this->entidaddb=$entidaddb;
		$this->servdetalleaportaciondb=$servdetalleaportaciondb;
    }

    public function retencionesAlMillar()
    {
    	return view('serviciosgenerales/retencionesalmillar');
    }
    public function accesopartidasFind(Request $request)
    {
    	$user=$request->user;
    	$response = array();
    	//log::info($user);
    	$part= array(81800, 81700, 41117);
    	$findAccesopart=$this->servaccesopartidasdb->findWhere(['usuario'=>$user]);
    	if($findAccesopart->count()>0)
    	{
    		foreach ($findAccesopart as $e) {
    			$valida=false;
    			foreach ($part as $p) {
    				if($p==$e->partida)
    				{
    					$valida=true;
    				}
    			}
    			if($valida)
    			{
    				$partidas=$this->servpartidasdb->findWhere(['id_partida'=>$e->partida]);
    				foreach ($partidas as $k) {
    					$response []= array(
    						'id' => $k->id_partida,
    						'nombre' => $k->descripcion
    					);
    				}
    			}

    		}
    	}
    	$cont=count($response);
    	if($cont<3)
    	{
    		foreach ($findAccesopart as $e) {    			
    			if(count($response)<3)
    			{
    				$partidas=$this->servpartidasdb->findWhere(['id_partida'=>$e->partida]);
    				foreach ($partidas as $k) {
    					$response []= array(
    						'id' => $k->id_partida,
    						'nombre' => $k->descripcion
    					);
    				}
    			}

    		}

    	}
    	//log::info($cont);
    	return json_encode($response);   	
    }
    public function proyectoprogramasFind(Request $request)
    {
    	$response=array();
    	$partida=$request->partida;
    	$folio=$request->folio;
    	$ejercicio=$request->ejercicio;
    	$findprogramas=$this->servproyectoprogramasdb->findWhere(['folio'=>$folio,'ejercicio'=>$ejercicio,'partida'=>$partida]);
    	foreach ($findprogramas as $e) {
    		$response []= array(
    			'proyecto' => $e->proyecto, 
    			'descproyecto' => $e->descripcion_proyecto, 
    			'programa' => $e->programa, 
    			'descprograma' => $e->descripcion_programa, 
    			'subprograma' => $e->subprograma, 
    			'descsubprograma' => $e->descripcion_subprograma, 
    			'oficio' => $e->oficio, 
    			'descoficio' => $e->descripcion_oficio, 
    			'descgeografica' => $e->descripcion_clasificacion_geografica, 
    			'descnormativa' => $e->descripcion_dependencia_normativa, 
    			'descejecutora' => $e->descripcion_dependencia_ejecutora, 
    		);
    	}
    	return json_encode($response);

    }
    public function wsReferencia(Request $request)
    {
    	
    	$ejercicio=$request->ejercicio;
        $partida=$request->partida;
        $folio=$request->folio;        
        $modejecucion=$request->modejecucion;
        $refcontrato=$request->refcontrato;
        $nofactura=$request->nofactura;
        $estpagada=$request->estpagada;
        $fecharet=$request->fecharet;
        $montoret=$request->montoret;
        $razonsoc=$request->razonsoc;
        $depnomativa=$request->depnomativa;
        $depejecutora=$request->depejecutora;
    	$clave='JBSUoiuYrLNoxcx6hkUB6OUtaTVnxdyQkmosQcSQ';
    	$request_json=array();
    	$tramite=array();
    	$datos_solicitante=array();
    	$datos_factura=array();
    	$detalle=array();
    	$subsidios=array();
    	$clave='';
    	$entidad='';
    	$servicio_id='';
    	$tipo_servicio=$this->servpartidasdb->findWhere(['id_partida'=>$partida]);
    	foreach ($tipo_servicio as $s) {
    		$servicio_id=$s->id_servicio;
    	}
    	$findEntidadTramite=$this->entidadtramitedb->findWhere(['tipo_servicios_id'=>$servicio_id]);
    	foreach ($findEntidadTramite as $i) {
    		$entidad=$i->entidad_id;
    	}
    	$findEntidad=$this->entidaddb->findWhere(['id'=>$entidad]);
    	foreach ($findEntidad as $k) {
    		$clave=$k->clave;
    	}
    	$entidad='1';
    	$clave='JBSUoiuYrLNoxcx6hkUB6OUtaTVnxdyQkmosQcSQ';
    	$token=$this->wsToken($entidad,$clave);
    	$datos_solicitante= array(
    		'nombre' =>'IVAN' , 
    		'apellido_paterno' => 'LEDEZMA', 
    		'apellido_materno' => 'SOSA', 
    		'razon_social' => '', 
    		'rfc' => '', 
    		'curp' => '', 
    		'email' => 'edmundo.mtz86@gmail.com', 
    		'calle' =>'' , 
    		'colonia' => '', 
    		'numexterior' => '', 
    		'nombre' =>'',  
    		'numinterior' =>'',  
    		'municipio' =>'',  
    		'codigopostal' =>'0'  
    	);
    	$datos_factura= array(
    		'nombre' =>'IVAN' , 
    		'apellido_paterno' => 'LEDEZMA', 
    		'apellido_materno' => 'SOSA', 
    		'razon_social' => '', 
    		'rfc' => '', 
    		'curp' => '', 
    		'email' => 'edmundo.mtz86@gmail.com', 
    		'calle' =>'' , 
    		'colonia' => '', 
    		'numexterior' =>'', 
    		'nombre' =>'',  
    		'numinterior' =>'',  
    		'municipio' =>'',  
    		'codigopostal' =>'0' 
    	);
    	$subsidios [] = array(
    		 'concepto' => 'prueba laravel',
    		 'importe_subsidio' => '1.0',
    		 'partida' => $partida
    		);
    	$detalle []= array(
    		'concepto' => 'prueba laravel',
    		'importe_concepto' => '1.0', 
			'partida' => $partida, 
			'subsidios' => $subsidios
    	);

    	$tramite []=$arrayName = array(
    		'id_tipo_servicio' => '1', //$servicio_id
    		'id_tramite' => '12', 
    		'importe_tramite' => $montoret, 
    		'auxiliar_1' => '', 
    		'auxiliar_2' => '', 
    		'auxiliar_3' => '',
    		'datos_solicitante'=>$datos_solicitante,
    		'datos_factura'=>$datos_factura,
    		'detalle'=>$detalle
    	);
    	$request_json= array(
    		'token' => $token,
    		'importe_transaccion' =>$montoret,
    		'id_transaccion' =>'12345678678',
    		'url_retorno' =>'www.prueba.com',
    		'entidad' =>'1',//$entidad
    		'tramite' =>$tramite
    	);
	
    	$json=json_encode($request_json);
    	//log::info($json);
    	$sopaBody='<tem:GeneraReferencia>';
		$sopaBody=$sopaBody.'<tem:json>'.$json.'</tem:json>';
		$sopaBody=$sopaBody.'</tem:GeneraReferencia>';
    	$soapHeader = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body>';
		$soapFooter = '</soapenv:Body></soapenv:Envelope>';
		$xmlRequest = $soapHeader . $sopaBody . $soapFooter;
		$client = new \GuzzleHttp\Client();

		try {
    		$response = $client->request('POST', 'http://10.153.165.22:8080/WsGobNL/AltaReferencia.asmx', [
            'Authenticate' => [],
            'body' => $xmlRequest,
            'headers' => [
                "Content-Type" => "text/xml; charset=utf-8"
            ]

        ]);
		$repuesta;
		$datos;
        $xmlResponse=$response->getBody()->getContents();
    	$soap = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlResponse);
		$xml = new \SimpleXMLElement($soap);
		$body = $xml->xpath('//soapBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE);
		foreach ($array as $e) {
			foreach ($e as $k) {
				$datos=json_decode($k,true);
				//$repuesta=$datos->id_transaccion_motor;				
			}			
		}
		$json_d =json_decode(json_encode($datos));

		$json_response=array();
		$json_response []=array(
			'folio'=>$json_d->id_transaccion_motor,
			'url'=>$json_d->url_recibo
		);

		//log::info($repuesta);
		} catch (\Exception $e) {
    		log::info('Exception:' . $e->getMessage());
    		$json_response=array();
		}

		return json_encode($json_response);
    }
    private function wsToken($entidad,$clave)
    {	
    	
    	$sopaBody='<tem:GeneraToken>';

		$sopaBody=$sopaBody.'<tem:entidad>'.$entidad.'</tem:entidad>';
		$sopaBody=$sopaBody.'<tem:clave>'.$clave.'</tem:clave>';

		$sopaBody=$sopaBody.'</tem:GeneraToken>';
    	$soapHeader = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body>';
		$soapFooter = '</soapenv:Body></soapenv:Envelope>';
		$xmlRequest = $soapHeader . $sopaBody . $soapFooter;
		//log::info($xmlRequest);
		$client = new \GuzzleHttp\Client();
		$token='';
		try {
    		$response = $client->request('POST', 'http://10.153.165.22:8080/WsGobNL/AltaReferencia.asmx', [
            'Authenticate' => [],
            'body' => $xmlRequest,
            'headers' => [
                "Content-Type" => "text/xml; charset=utf-8"
            ]

        ]);
		
        $xmlResponse=$response->getBody()->getContents();
    	$soap = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlResponse);
		$xml = new \SimpleXMLElement($soap);
		$body = $xml->xpath('//soapBody')[0];
		$array = json_decode(json_encode((array)$body), TRUE);
		//log::info($array);
		foreach ($array as $e) {
			foreach ($e as $k) {
				$datos=json_decode(json_encode($k));
				$token=$datos->sToken;				
			}			
		}
		} catch (\Exception $e) {
    		log::info('Exception:' . $e->getMessage());
		}
		
		return $token;
    }

    public function reporteretencionesalmillar()
    {
    	return view('serviciosgenerales/reporteretencionesalmillar');
    }

    public function detalleaportacionFind(Request $request)
    {
    	$partida=$request->partida;
    	$pagado=$request->pagado;
    	$fechaInicio=$request->fechaInicio;
    	$fechaFin=$request->fechaFin;
    	$response=array();
    	$finddetalleaport=$this->servdetalleaportaciondb->findWhere(['partida'=>$partida,['fecha_retencion','>=',$fechaInicio],['fecha_retencion','<=',$fechaFin]]);
    	foreach ($finddetalleaport as $k)
    	{
    		$response []= array(
    			'id_transaccion' => $k->id_transaccion, 
    			'ejercicio_fiscal' => $k->ejercicio_fiscal, 
    			'folio_sie' => $k->folio_sie, 
    			'modalidad_ejecucion' => $k->modalidad, 
    			'referencia_contrato' => $k->contrato, 
    			'numero_factura' => $k->numero_factura, 
    			'estimacion_pagada' => $k->estimacion_pagada, 
    			'id_retencion' => $k->id, 
    			'fecha_retencion' => $k->fecha_retencion, 
    			'monto_retenido' => $k->monto_retencion, 
    			'razon_social' => $k->razon_social_contrato, 
    			'dependencia_normativa' => $k->desc_dependencia_normativa, 
    			'dependencia_ejecutora' => $k->desc_dependencia_ejecutora, 
    			'fecha_tramite' => $k->created_at
    		);
    	}
    	return json_encode($response);
    }


}
