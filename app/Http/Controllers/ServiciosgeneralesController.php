<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use File;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use phpmailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use GuzzleHttp\Client;
use SimpleXMLElement;
use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;
use App\Repositories\ServaccesopartidasRepositoryEloquent;
use App\Repositories\ServpartidasRepositoryEloquent;
use App\Repositories\ServproyectoprogramasRepositoryEloquent;
use App\Repositories\EntidadtramiteRepositoryEloquent;
use App\Repositories\EntidadRepositoryEloquent;
use App\Repositories\ServdetalleaportacionRepositoryEloquent;
use App\Repositories\ServgenerartransaccionRepositoryEloquent;
use App\Repositories\ServdetalleserviciosRepositoryEloquent;
use App\Repositories\UsersRepositoryEloquent;

class ServiciosgeneralesController extends Controller
{
	protected $servaccesopartidasdb;
	protected $servpartidasdb;
	protected $servproyectoprogramasdb;
	protected $entidadtramitedb;
	protected $entidaddb;
	protected $servdetalleaportaciondb;
	protected $servgeneratransacciondb;
    protected $servdetalleserviciosdb;
	protected $usersdb;

	public function __construct( 
    	ServaccesopartidasRepositoryEloquent $servaccesopartidasdb,
    	ServpartidasRepositoryEloquent $servpartidasdb,
    	ServproyectoprogramasRepositoryEloquent $servproyectoprogramasdb,
    	EntidadtramiteRepositoryEloquent $entidadtramitedb,
    	EntidadRepositoryEloquent $entidaddb,
    	ServdetalleaportacionRepositoryEloquent $servdetalleaportaciondb,
    	ServgenerartransaccionRepositoryEloquent $servgeneratransacciondb,
        ServdetalleserviciosRepositoryEloquent $servdetalleserviciosdb,
    	UsersRepositoryEloquent $usersdb

    ){
    	$this->middleware('auth');
		$this->servaccesopartidasdb=$servaccesopartidasdb;
		$this->servpartidasdb=$servpartidasdb;
		$this->servproyectoprogramasdb=$servproyectoprogramasdb;
		$this->entidadtramitedb=$entidadtramitedb;
		$this->entidaddb=$entidaddb;
		$this->servdetalleaportaciondb=$servdetalleaportaciondb;
		$this->servgeneratransacciondb=$servgeneratransacciondb;
        $this->servdetalleserviciosdb=$servdetalleserviciosdb;
		$this->usersdb=$usersdb;
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
    	
    	$ejercicio_fiscal=$request->ejercicio_fiscal;
        $partida=$request->partida;
        $folio=$request->folio;        
        $modalidad_ejecucion=$request->modalidad_ejecucion;
        $referencia_contrato=$request->referencia_contrato;
        $numero_factura=$request->numero_factura;
        $estimacion_pagada=$request->estimacion_pagada;
        $fecha_retencion=$request->fecha_retencion;
        $fecha_retencion=Carbon::parse($fecha_retencion)->format('Y-m-d');
        $monto_retencion=$request->monto_retencion;
        $razon_social=$request->razon_social;
        $dependencia_normativa=$request->dependencia_normativa;
        $dependencia_ejecutora=$request->dependencia_ejecutora;
        $email=$request->email;
        $proyecto; 
    	$descripcion_proyecto;    			
    	$programa;
    	$descripcion_programa; 
    	$subprograma;
    	$descripcion_subprograma; 
    	$oficio;
    	$descripcion_oficio;
    	$descripcion_clasificacion_geografica; 
    	$descripcion_dependencia_normativa; 
    	$descripcion_dependencia_ejecutora;
    	$id_programa='0';        
        $findprogramas=$this->servproyectoprogramasdb->findWhere(['folio'=>$folio,'ejercicio'=>$ejercicio_fiscal,'partida'=>$partida]);
    	foreach ($findprogramas as $e) {
    		
    			$proyecto = $e->proyecto; 
    			$descripcion_proyecto = $e->descripcion_proyecto;    			
    			$programa = $e->programa;
    			$descripcion_programa = $e->descripcion_programa; 
    			$subprograma = $e->subprograma;
    			$descripcion_subprograma = $e->descripcion_subprograma; 
    			$oficio =$e->oficio;
    			$descripcion_oficio = $e->descripcion_oficio;
    			$descripcion_clasificacion_geografica = $e->descripcion_clasificacion_geografica; 
    			$descripcion_dependencia_normativa = $e->descripcion_dependencia_normativa; 
    			$descripcion_dependencia_ejecutora = $e->descripcion_dependencia_ejecutora; 
    		
    	}
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
    	$insert=$this->servgeneratransacciondb->create(['partida'=>$partida,'folio'=>$folio]);
    	$id_trans=$insert->id;
    	//log::info($fecha_retencion);
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
    		'importe_tramite' => $monto_retencion, 
    		'auxiliar_1' => '', 
    		'auxiliar_2' => '', 
    		'auxiliar_3' => '',
    		'datos_solicitante'=>$datos_solicitante,
    		'datos_factura'=>$datos_factura,
    		'detalle'=>$detalle
    	);
    	$request_json= array(
    		'token' => $token,
    		'importe_transaccion' =>$monto_retencion,
    		'id_transaccion' =>$id_trans,
    		'url_retorno' =>'www.prueba.com',
    		'entidad' =>'1',//$entidad
    		'tramite' =>$tramite
    	);
	
    	$json=json_encode($request_json);
    	try {
        $parameters=['json'=>$json];
		$server = new \SoapClient('http://10.153.165.22:8080/WsGobNL/AltaReferencia.asmx?WSDL',[
            'encoding' => 'UTF-8',
            'verifypeer'=>false,
            'trace' => true
        ]);
		$datos =$server->GeneraReferencia($parameters)->GeneraReferenciaResult;
		$json_d =json_decode($datos);
		$folio_resp=$json_d->id_transaccion_motor;
		$url_resp=$json_d->url_recibo;
		$json_response=array();
		$json_response []=array(
			'folio'=>$folio_resp,
			'url'=>$url_resp
		);
		$fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d');
		
		$insertdetalle=$this->servdetalleaportaciondb->create(['id_transaccion'=>$folio_resp,'folio'=>$id_trans,'nombre_proyecto'=>$proyecto,'folio_sie'=>$folio,'id_programa'=>$id_programa,'nombre_programa'=>$programa,'ejercicio_fiscal'=>$ejercicio_fiscal,'modalidad'=>$modalidad_ejecucion,'contrato'=>$referencia_contrato,'numero_factura'=>$numero_factura,'estimacion_pagada'=>$estimacion_pagada,'partida'=>$partida,'fecha_retencion'=>$fecha_retencion,'monto_retencion'=>$monto_retencion,'razon_social_contratado'=>$razon_social,'dependencia_normativa'=>$dependencia_normativa,'dependencia_ejecutora'=>$dependencia_ejecutora,'proyecto'=>$proyecto,'desc_proyecto'=>$descripcion_proyecto,'programa'=>$programa,'desc_programa'=>$descripcion_programa,'subprograma','desc_subprograma'=>$descripcion_subprograma,'oficio'=>$oficio,'desc_oficio'=>$descripcion_oficio,'desc_clasificacion_geografica'=>$descripcion_clasificacion_geografica,'desc_dependencia_normativa'=>$descripcion_dependencia_normativa,'desc_dependencia_ejecutora'=>$descripcion_dependencia_ejecutora,'fecha_tramite'=>$date]);
		if($email<>''){
			//$this->SendEmial($url_resp,$folio_resp,$email);
		}
		//log::info($repuesta);
		} catch (\Exception $e) {
    		log::info('Exception:' . $e->getMessage());
    		$json_response=array();
		}

		return json_encode($json_response);
    }
    private function wsToken($entidad,$clave)
    {
		
		$token='';
		try {
        $parameters=['entidad'=>$entidad,'clave'=>$clave];
		$server = new \SoapClient('http://10.153.165.22:8080/WsGobNL/AltaReferencia.asmx?WSDL',[
            'encoding' => 'UTF-8',
            'verifypeer'=>false,
            'trace' => true
        ]);
		$responseXML =$server->GeneraToken($parameters)->GeneraTokenResult->sToken;
		$token=(string)$responseXML;

		} catch (\Exception $e) {
    		log::info('Exception:' . $e->getMessage());
		}
		
		return $token;
    }
    private function loadXmlStringAsArray($xml)
    {
    	$array=(array)@simplexml_load_string($xml);
    	if(!$array)
    	{
    		$array=(array)json_decode($xml,true);
    	}else{
    		$array=(array)json_decode(json_encode($array),true);
    	}
    	return $array;
    }
    public function SendEmial($url,$referencia,$email)
    {
        //$url='http://localhost:8080';
        //$referencia='222222444424';
         $mail = new PHPMailer(true);
         $message=$this->plantillaEmail($url,$referencia);
        try{
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth =true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.outlook.com';
            $mail->Port = '587'; 
            $mail->Username = 'juan.carlos.cruz.bautista@hotmail.com';
            $mail->Password = 'yashiro96';
            $mail->setFrom('juan.carlos.cruz.bautista@hotmail.com', 'NAME'); 
            $mail->Subject = 'MENSAJE PRUEBA';
            $mail->MsgHTML($message);
            $mail->addAddress($email , 'NAME'); 
            $mail->send();
        }catch(phpmailerException $e){
            log::info($e);
        }
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
    	$finddetalleaport=$this->servdetalleaportaciondb->findWhere(['partida'=>$partida,['fecha_tramite','>=',$fechaInicio],['fecha_tramite','<=',$fechaFin]]);
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

    public function pagoArrendamiento()
    {
    	return view('serviciosgenerales/pagoarrendamientos');
    }
    public function wsArrendamientoR(Request $request)
    {
    	
    	$nombre=$request->nombre;
    	$rfc=$request->rfc;
    	$curp=$request->curp;
    	$calle=$request->calle;
    	$nointerior=$request->nointerior;
    	$noexterior=$request->noexterior;
    	$colonia=$request->colonia;
    	$municipio=$request->municipio;
    	$estado=$request->estado;
    	$cp=$request->cp;
    	$pagos=$request->pagos;
 		$email=$request->email;
        
        
    	$request_json=array();
    	$tramite=array();
    	$datos_solicitante=array();
    	$datos_factura=array();
    	$detalle=array();
    	$subsidios=array();
    	$clave='';
    	$entidad='';
    	$servicio_id='';
    	$pagosJson=json_decode($pagos);
    	$partida;
    	$sumMonto=0;
    	foreach ($pagosJson as $p) {
    		$partida=$p->partida;
    		$sumMonto=$sumMonto+floatval($p->monto);    		
    	}
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
    	$insert=$this->servgeneratransacciondb->create(['partida'=>$partida,'folio'=>$partida]);
    	$id_trans=$insert->id;
    	//log::info($fecha_retencion);
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
    		'razon_social' => '',//$nombre, 
    		'rfc' =>'' ,//$rfc, 
    		'curp' => '',//$curp, 
    		'email' => 'edmundo.mtz86@gmail.com', 
    		'calle' =>'',//$calle , 
    		'colonia' =>'',//$colonia, 
    		'numexterior' =>'',//$noexterior, 
    		'nombre' =>'',  
    		'numinterior' =>'',//$nointerior,  
    		'municipio' =>'',//$municipio,  
    		'codigopostal' =>''//$cp 
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
    		'importe_tramite' => $sumMonto, 
    		'auxiliar_1' => '', 
    		'auxiliar_2' => '', 
    		'auxiliar_3' => '',
    		'datos_solicitante'=>$datos_solicitante,
    		'datos_factura'=>$datos_factura,
    		'detalle'=>$detalle
    	);
    	$request_json= array(
    		'token' => $token,
    		'importe_transaccion' =>$sumMonto,
    		'id_transaccion' =>$id_trans,
    		'url_retorno' =>'www.prueba.com',
    		'entidad' =>$entidad,
    		'tramite' =>$tramite
    	);

		$repuesta;
		$datos;
       	$json=json_encode($request_json);
    	try {
        $parameters=['json'=>$json];
		$server = new \SoapClient('http://10.153.165.22:8080/WsGobNL/AltaReferencia.asmx?WSDL',[
            'encoding' => 'UTF-8',
            'verifypeer'=>false,
            'trace' => true
        ]);
		$datos =$server->GeneraReferencia($parameters)->GeneraReferenciaResult;
		$json_d =json_decode($datos);
		
		$folio_resp=$json_d->id_transaccion_motor;
		$url_resp=$json_d->url_recibo;
		$json_response=array();
		$json_response []=array(
			'folio'=>$folio_resp,
			'url'=>$url_resp
		);
		$fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d');
		foreach ($pagosJson as $j) {
			$desc_partida='';
			$findPartida=$this->servpartidasdb->findWhere(['id_partida'=>$j->partida]);
    		foreach ($findPartida as $s) {
    			$desc_partida=$s->descripcion;
    		}
    		$insertdetalle=$this->servdetalleserviciosdb->create(['idTrans'=>$folio_resp,'Folio'=>$folio_resp,'rfc'=>$rfc,'curp'=>$curp,'calle'=>$calle,'no_ext'=>$noexterior,'no_int'=>$nointerior,'colonia'=>$colonia,'municipio_delegacion'=>$municipio,'cp'=>$cp,'monto'=>$j->monto,'partida'=>$j->partida,'estado_pais'=>$estado,'consepto'=>$j->consepto,'nombre_razonS'=>'IVAN','desc_partida'=>$desc_partida]);    		
    	}
		
		if($email<>''){
			$this->SendEmial($url_resp,$folio_resp,$email);
		}
		//log::info($repuesta);
		} catch (\Exception $e) {
    		log::info('Exception:' . $e->getMessage());
    		$json_response=array();
		}

		return json_encode($json_response);
    }
    public function pagoserviciosgenerales()
    {
    	return view('serviciosgenerales/pagoserviciosgenerales');
    }
    public function accesoServicios()
    {
        return view('controlacceso/controlacceso');
    }
    public function insertUser(Request $request)
    {
        $nombre=$request->nombre;
        $email=$request->email;
        $password=$request->password;
        $confirmpassword=$request->confirmpassword;
        $finduser=$this->usersdb->findWhere();
        
    }
    private function plantillaEmail($url,$referencia)
    {
        $email='<!doctype html><html><head><meta name="viewport" content="width=device-width" /><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>test Email</title><style> 
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; 
      }
      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }
      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; 
      }
      .body {
        background-color: #f6f6f6;
        width: 100%; 
      }
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; 
      }
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 580px;
        padding: 10px; 
      }
      .main {
        background: #ffffff;
        border-radius: 3px;
        width: 100%; 
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 15px; 
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; 
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; 
      }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; 
      }
      .btn-primary table td {
        background-color: #3498db; 
      }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; 
      }
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }

      .align-right {
        text-align: right; 
      }

      .align-left {
        text-align: left; 
      }

      .clear {
        clear: both; 
      }

      .mt0 {
        margin-top: 0; 
      }

      .mb0 {
        margin-bottom: 0; 
      }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; 
      }

      .powered-by a {
        text-decoration: none; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0; 
      }
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; 
        }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; 
        }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; 
        }
        table[class=body] .content {
          padding: 0 !important; 
        }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; 
        }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; 
        }
        table[class=body] .btn table {
          width: 100% !important; 
        }
        table[class=body] .btn a {
          width: 100% !important; 
        }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; 
        }
      }
      @media all {
        .ExternalClass {
          width: 100%; 
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; 
        }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; 
        }
        #MessageViewBody a {
          color: inherit;
          text-decoration: none;
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit;
          line-height: inherit;
        }
        .btn-primary table td:hover {
          background-color: #34495e !important; 
        }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; 
        } 
      }
    </style>
  </head>
  <body class="">  
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <table role="pre<sentation" class="main">
              <tr>
                <td class="wrapper">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p>Referencia:</p>
                        <p>'.$referencia.'</p>
                        <br><br>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                  <tbody >
                                    <tr> </td>
                                      <td whidth="100%" align="center"> <a href="'.$url.'" target="_blank">Ver Recibo</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <div class="footer">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr><td class="content-block"><span class="apple-link">Emial Prueba</span></td></tr><tr> </tr></table></div></div></td><td>&nbsp;</td></tr></table></body></html>
    ';
    return $email;
    }


}
