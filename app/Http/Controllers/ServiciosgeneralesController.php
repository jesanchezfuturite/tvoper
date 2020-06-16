<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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
use App\Repositories\AdministratorsRepositoryEloquent;
use App\Repositories\ServclavesgRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

use App\Repositories\MenuRepositoryEloquent;
use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $administratordb;
	protected $servclavesgdb;
    protected $menudb;
    protected $tiposerviciodb;

	public function __construct( 
    	ServaccesopartidasRepositoryEloquent $servaccesopartidasdb,
    	ServpartidasRepositoryEloquent $servpartidasdb,
    	ServproyectoprogramasRepositoryEloquent $servproyectoprogramasdb,
    	EntidadtramiteRepositoryEloquent $entidadtramitedb,
    	EntidadRepositoryEloquent $entidaddb,
    	ServdetalleaportacionRepositoryEloquent $servdetalleaportaciondb,
    	ServgenerartransaccionRepositoryEloquent $servgeneratransacciondb,
        ServdetalleserviciosRepositoryEloquent $servdetalleserviciosdb,
        UsersRepositoryEloquent $usersdb,
        AdministratorsRepositoryEloquent $administratordb,
    	ServclavesgRepositoryEloquent $servclavesgdb,
        MenuRepositoryEloquent $menudb,
        EgobiernotiposerviciosRepositoryEloquent $tiposerviciodb

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
        $this->administratordb=$administratordb;
		$this->servclavesgdb=$servclavesgdb;
        $this->menudb = $menudb;
        $this->tiposerviciodb = $tiposerviciodb;
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
    		'email' => '', 
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
    		'email' => '', 
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
        $menu_info = $this->menudb->find(1);
        if($menu_info->count() > 0)
        {
            /* get the info and make the arrays */
            $menu = json_decode($menu_info->content,true);
            if(count($menu) > 0)
            {
                $data = $this->getLevelsFromArrays($menu); 
            }else{
                $data = array(
                    "first_level"   => '[]',
                    "second_level"  => '[]',
                    "third_level"   => '[]',
                );  
            }
        }else{
            /* load the view with the info saved */
            $data = array(
                "first_level"   => '[]',
                "second_level"  => '[]',
                "third_level"   => '[]',
            );  
        } 
        return view('controlacceso/controlacceso',$data);
    }
    public function insertUser(Request $request)
    {   
        $response=array();
        $nombre=$request->nombre;
        $apellido_pat=$request->apellido_pat;
        $apellido_mat=$request->apellido_mat;
        $dependencia=$request->dependencia;
        $email=$request->email;
        $password=$request->password;
        $confirmpassword=$request->confirmpassword;
        $finduser=$this->usersdb->findWhere(['email'=>$email]);
        if($password==$confirmpassword)
        {
            if($finduser->count()==0)
            {
                $id_user='';
                $insertuser=$this->usersdb->create(['name'=>$nombre.' '.$apellido_pat.' '.$apellido_mat,'email'=>$email,'status'=>'1','password'=> Hash::make($password)]);
                $id_user=$insertuser->id;
                $insertadministrator=$this->administratordb->create(['name'=>$email,'is_admin'=>'0','menu'=>'[]']);
                $insertclavesg=$this->servclavesgdb->create(['usuario'=>$email,'Password'=>$password,'dependencia'=>$dependencia,'nombre'=>$nombre,'apellido_paterno'=>$apellido_pat,'apellido_materno'=>$apellido_mat,'user_id'=>$id_user,'estatus'=>'1']);
                $response=array();
                $response [] = array(
                'code' => '0',
                'message'=>'Success' 
                );
            }else{
                $response=array();
                $response [] = array(
                'code' => '1',
                'message'=>'Usuario Ya Existe!!' 
                );
            }
        }else
        {
            $response=array();
                $response [] = array(
                'code' => '2',
                'message'=>'La constraseña no coincide!!' 
                );
        }
        
        return json_encode($response);

    }
     public function findUser(Request $request)
    {   
        $response=array();
        $id=$request->id;
         
        $findServclave=$this->servclavesgdb->findWhere(['id'=>$id]);
        foreach ($findServclave as $e) {
            $response [] = array(
                'email' => $e->usuario,
                'dependencia'=>$e->dependencia, 
                'nombre'=>$e->nombre, 
                'ape_pat'=>$e->apellido_paterno, 
                'ape_mat'=>$e->apellido_materno, 
                'password'=>$e->Password
            );
        }
            
        
        return json_encode($response);

    }
   
    public function updateUser(Request $request)
    {   
        $response=array();
        $id=$request->id;
        $user_id=$request->user_id;
        $nombre=$request->nombre;
        $apellido_pat=$request->apellido_pat;
        $apellido_mat=$request->apellido_mat;
        $dependencia=$request->dependencia;
        $password=$request->password;
        $confirmpassword=$request->confirmpassword;
        if($password==$confirmpassword)
        {               
            $updatetUs=$this->usersdb->update(['name'=>$nombre.' '.$apellido_pat.' '.$apellido_mat,'password'=> Hash::make($password)],$user_id);
            $updateClavesg=$this->servclavesgdb->update(['Password'=>$password,'dependencia'=>$dependencia,'nombre'=>$nombre,'apellido_paterno'=>$apellido_pat,'apellido_materno'=>$apellido_mat],$id);
                            
            $response=array();
            $response [] = array(
                'code' => '0',
                'message'=>'Success' 
            );
            
        }else
        {
            $response=array();
                $response [] = array(
                'code' => '2',
                'message'=>'La contraseña no coincide!!' 
                );
        }
        
        return json_encode($response);

    }
    public function deletedUser(Request $request)
    {   
        $response=array();
        $id=$request->id;
        $user_id=$request->user_id;
        try {
            $email='';
            $findclave=$this->servclavesgdb->findWhere(['id'=>$id]);
            foreach ($findclave as $i) {
                $email=$i->usuario;
            }
            $deleteAdministrator=$this->administratordb->deleteWhere(['name'=>$email]);
            $deleteUser=$this->usersdb->deleteWhere(['id'=>$user_id]);
            $deleteServclave=$this->servclavesgdb->deleteWhere(['id'=>$id]);
            $response=array();
            $response [] = array(
                'code' => '0',
                'message'=>'Success' 
            );
                    
        } catch (Exception $e) {
                    $response=array();
                $response [] = array(
                'code' => '2',
                'message'=>'Error al Eliminar!!' 
                );
        }
        return json_encode($response);

    }
    public function findUserAcceso()
    {   
        $response=array();
        $finduser=$this->servclavesgdb->consultaRegistros();
        foreach ($finduser as $clv) {
            $response []= array(
                'id' =>$clv->id , 
                'emial' =>$clv->email , 
                'dependencia' =>$clv->dependencia , 
                'nombre' =>$clv->nombre , 
                'ape_pat' =>$clv->apellido_paterno , 
                'ape_mat' =>$clv->apellido_materno , 
                'user_id' =>$clv->user_id 
            );
        }
        return json_encode($response);
    }
     protected function getLevelsFromArrays($menu)
    {
        // get first level
        $first_level = $second_level = $second_level_complete = $third_level = $third_level_complete = array();
        foreach($menu as $j => $elements)
        {   
            foreach($elements as $i => $element)
            {
                switch($i){
                    case "info":
                        $first_level []= $element;
                        break ;
                    case "childs":
                        $second_level_complete[]= $element;
                        break ; 
                }   
            }       
        }
        foreach ($second_level_complete as $j => $elements) 
        {
            foreach($elements as $i => $element)
            {
                $second_level []= $element["info"];
                
                if(count($element["childs"]))
                {
                    $third_level_complete[]= $element["childs"];    
                }
            }
        }
        foreach ($third_level_complete as $elements) 
        {   
            foreach($elements as $e)
            {
                $third_level []= $e;
            }
        }
        $data = array(
            "first_level" => json_encode($first_level),
            "second_level" => json_encode($second_level),
            "third_level" => json_encode($third_level),

        );
        return $data;
    }
    public function loadUserMenu(Request $request)
    {
        $id=$request->id;
        $email='';
        $findclave=$this->servclavesgdb->findWhere(['id'=>$id]);
            foreach ($findclave as $i) {
                $email=$i->usuario;
            }
        $users = $this->administratordb->findWhere( [ "name" => trim($email) ] );

        if($users->count())
        {
            foreach($users as $u)
            {
                $menu = $u->menu;
            }
            return $menu;
        }else{
            return "[]";
        }

    }
     public function saveMenuUSer(Request $request)
    {
        /* here i have to modify to just save the identifier */
        try{
            $id=$request->id;
            $email='';
            $findclave=$this->servclavesgdb->findWhere(['id'=>$id]);
            foreach ($findclave as $i) {
                $email=$i->usuario;
            }
            $this->administratordb->updateMenuByName( ['name' => $email], [ 'menu' => $request->tools ]);
        }catch( \Exception $e){
            Log::info('[AsignaHerramientasController@saveUserProfile] Error ' . $e->getMessage());    
        }
        
    }
    public function deleteElementMenuUser(Request $request)
    {
        
        $id_user=$request->id_user;
        $email='';
        $findclave=$this->servclavesgdb->findWhere(['id'=>$id_user]);
            foreach ($findclave as $i) {
                $email=$i->usuario;
            }
        $users = $this->administratordb->findWhere( [ "name" => trim($email) ] );

        try{
            $toDelete = $request->id;    
        }catch( \Exception $e){
            log::info("Error while update tools" . $e->getMessage() );
        }
        
        if($users->count())
        {
            foreach($users as $u)
            {
                $menu = $u->menu;
            }
            
            $menu  = json_decode($menu);

            foreach($menu as $m => $v)
            { log::info($toDelete);

                if($v->id == $toDelete)
                {
                    unset($menu[$m]);

                }
            }
            foreach($menu as $sub => $n)
            { 

                if($n->id_father == $toDelete)
                {
                    unset($menu[$sub]);
                }
            }

            //log::info($menu);
            /* here change to json and updates the db*/
            try{
                //log::info($menu);
                $this->admins->updateMenuByName( ['name' => $u->name ], [ 'menu' => json_encode($menu) ]);
                return 1 ;

            }catch( \Exception $e){
                log::info('[AsignaHerramientasController@deleteElementUserProfile] Error ' . $e->getMessage()); 
                return 0;
            }
        }
    }
    public function findPartidasWhere(Request $request)
    {    
        $response=array();   
        $responsePartidas = array();
        $id_user=$request->id_user;
        $accesoPartidas=$this->servaccesopartidasdb->findWhere(['usuario'=>$id_user]);
         foreach($accesoPartidas as $ii)
        {
            $responsePartidas []= array(
                $ii->partida
            );
        }
        //log::info($responsePartidas);
        $info = $this->servpartidasdb->findWhereNotIn('id_partida',$responsePartidas);
        foreach($info as $i)
        {
            $response []= array(
               "id" => $i->id_partida,
                "nombre" => $i->descripcion,
            );
        }

        return json_encode($response);
        
    }
    public function findPartidasWhereUser(Request $request)
    {    
        $response=array();
        $id_user=$request->id_user;
        $accesoPartidas=$this->servaccesopartidasdb->findWhere(['usuario'=>$id_user]);
         foreach($accesoPartidas as $ii)
        {
            $info = $this->servpartidasdb->findWhere(['id_partida'=>$ii->partida]);
            foreach($info as $i)
            {
                $response []= array(
                "id" => $i->id_partida,
                "nombre" => $i->descripcion,
                );
            }
        }
        return json_encode($response);        
    }
    public function insertPartidasUser(Request $request)
    {    
        $checkedsAll =json_decode($request->checkedsAll);        
        $id_user=$request->id_user;     
        $contador=0;
        
        try{
            foreach($checkedsAll as $i) 
            {             
                //log::info($i);
                $info2 = $this->servaccesopartidasdb->create(['usuario'=>$id_user,'partida'=>$i]);
                $contador=$contador+1;
            }       

        }
        catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
           $contador=0;            
        }
        return $contador;

    }
    public function deletePartidasUser(Request $request)
    {    
        $checkedsAll =json_decode($request->checkedsAll);        
        $id_user=$request->id_user;     
        $contador=0;
        
        try{
            foreach($checkedsAll as $i) 
            {             
                //log::info($i);
                $info2 = $this->servaccesopartidasdb->deleteWhere(['usuario'=>$id_user,'partida'=>$i]);
                $contador=$contador+1;
            }       

        }
        catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
           $contador=0;            
        }
        return $contador;

    }
    public function altapartidas(Request $request)
    {
        return view('controlacceso/altapartidas');
    }
    public function insertPartidasServicios(Request $request)
    {
        $idpartida=$request->idpartida;
        $idservicio=$request->idservicio;
        $descripcion=$request->descripcion;
        $response = "false";
        try{  
        $findpartida=$this->servpartidasdb->findWhere(['id_partida'=>$idpartida]);
            if($findpartida->count()==0)
            {
            $insertpartidas=$this->servpartidasdb->create(['id_servicio'=>$idservicio,'id_partida'=>$idpartida,'descripcion'=>$descripcion]);
            $response = "true";
            }else{
                $response = "false";
            }
        } catch( \Exception $e ){
            Log::info('Error Method partidasInsert: '.$e->getMessage());
        $response = "false";
        }
       return $response;

    }
    public function partidasFindAllServicios()
    {   
        $response= array();
        $servicio;
        $partidasfind=$this->servpartidasdb->all();
        foreach ($partidasfind as $part) {
            $serviciofind=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$part->id_servicio]);
            foreach ($serviciofind as $serv) {
                $servicio=$serv->Tipo_Descripcion;
            }
            $response []= array(
                'id_partida' => $part->id_partida, 
                'id_servicio' => $part->id_servicio, 
                'servicio' => $servicio, 
                'descripcion' => $part->descripcion 

            );
        }
        return json_encode($response);
    }
    public function serviciosPartidasFindWhere(Request $request)
    {
        $response= array();
        $idpartida=$request->idpartida;
         $findpartida=$this->servpartidasdb->findWhere(['id_partida'=>$idpartida]);
         foreach ($findpartida as $part) {
            $response []= array(
                'id_partida' => $part->id_partida, 
                'id_servicio' => $part->id_servicio,
                'descripcion' => $part->descripcion 

            );
         }
         return json_encode($response);
    }
    public  function serviciosPartidasUpdate(Request $request)
    {
        $idpartida=$request->idpartida;
        $idservicio=$request->idservicio;
        $descripcion=$request->descripcion;
        $response = "false";
        try{ 

        $updatepartidas=$this->servpartidasdb->updatePartida(['id_servicio'=>$idservicio,'descripcion'=>$descripcion],['id_partida'=>$idpartida]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method partidasUpdate: '.$e->getMessage());
            $response = "false";
        }
       return $response;
    }
    public function serviciosPartidasDeleted(Request $request)
    {
         $idpartida=$request->idpartida;
         $response = "false";
        try{   
        $deletedpartidas=$this->servpartidasdb->deleteWhere(['id_partida'=>$idpartida]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method partidasDeleted: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }

}
