<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
/**** Repository ****/
use App\Repositories\ConceptsCalculationRepositoryEloquent;
use App\Repositories\ConceptsubsidiesRepositoryEloquent;
use App\Repositories\UmahistoryRepositoryEloquent;
use App\Repositories\CurrenciesRepositoryEloquent;
use App\Repositories\ApplicableSubjectRepositoryEloquent;
use App\Repositories\UsuariodbentidadRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\PagossolicitudRepositoryEloquent;
/***/
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

/*agrego esto para complementar la consulta necesaria*/
use App\Repositories\MetodopagoRepositoryEloquent;
use App\Repositories\ProcessedregistersRepositoryEloquent;


class ConsultasController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $tiposerviciodb;  
    protected $partidasdb;
    protected $conceptscalculationdb;
    protected $conceptsubsidiesdb;
    protected $umahistorydb;
    protected $currenciesdb;
    protected $applicablesubjectdb;
    protected $usuarioentidaddb;
    protected $oper_transaccionesdb;
    protected $pagossolicituddb;
    protected $metodospago;

    protected $users_entidad;
    protected $list_mp;
    protected $conciliacion;
    // In this method we ensure that the user is logged in using the middleware


    public function __construct( 
       
        EgobiernotiposerviciosRepositoryEloquent $tiposerviciodb,
        EgobiernopartidasRepositoryEloquent $partidasdb,
        ConceptsCalculationRepositoryEloquent $conceptscalculationdb,
        ConceptsubsidiesRepositoryEloquent $conceptsubsidiesdb,
        UmahistoryRepositoryEloquent $umahistorydb,
        CurrenciesRepositoryEloquent $currenciesdb,
        ApplicableSubjectRepositoryEloquent $applicablesubjectdb,
        UsuariodbentidadRepositoryEloquent $usuarioentidaddb,
        TransaccionesRepositoryEloquent $oper_transaccionesdb,
        PagossolicitudRepositoryEloquent $pagossolicituddb,
        MetodopagoRepositoryEloquent $metodospago,
        ProcessedregistersRepositoryEloquent $conciliacion

    )
    {
        $this->tiposerviciodb           = $tiposerviciodb;
        $this->partidasdb               = $partidasdb;
        $this->conceptscalculationdb    = $conceptscalculationdb;
        $this->conceptsubsidiesdb       = $conceptsubsidiesdb;
        $this->umahistorydb             = $umahistorydb;
        $this->currenciesdb             = $currenciesdb;
        $this->applicablesubjectdb      = $applicablesubjectdb;
        $this->usuarioentidaddb         = $usuarioentidaddb;
        $this->oper_transaccionesdb     = $oper_transaccionesdb;
        $this->pagossolicituddb         = $pagossolicituddb;
        $this->metodospago              = $metodospago;
        $this->conciliacion             = $conciliacion;

        $this->loadUserEntities();
        $this->loadMetodosPago();
        
    }

    /**
     * loadUserEntities. regresa los usuarios de la tabla
     *
     * @param ninguna
     *
     * @return array()
     *
     */
    private function loadUserEntities()
    {
        
        $res = array();

        $info = $this->usuarioentidaddb->all();

        foreach($info as $i)
        {
            $res []= array(
                "us"    => $i->usuariobd,
                "en"    => $i->id_entidad
            );
        }

        $this->users_entidad = $res;
    }

    /**
     * loadMetodoPago. Regresa los metodos de pagos registrados en el sistema
     *
     * @param ninguna
     *
     * @return array()
     *
     */

    private function loadMetodosPago()
    {
        
        $res = array();

        $info = $this->metodospago->all();

        foreach($info as $i)
        {
            $res [$i->id]= $i->nombre;
        }

        $this->list_mp = $res;
    }
    /**
     * checkEntity. aqui regresamos cual es el id de la entidad 
     *
     * @param entidad
     *
     * @return integer if 0 la entidad no existe
     *
     */
    private function checkEntity($entidad)
    {   
        foreach($this->users_entidad as $name)
        {
            if(strcmp($name["us"],$entidad) == 0)
            {
                return (integer)$name["en"];
            }
        }

        return 0;

    }

    /**
     * obtenerfechaConciliacion. obtener la fecha en que se concilio un documento  
     *
     * @param entidad
     *
     * @return integer if 0 la entidad no existe
     *
     */
    private function obtenerfechaConciliacion($referencia)
    {   
        $info = $this->conciliacion->findWhere(
            [ "referencia" => $referencia ]
        );

        if($info->count() > 0){
            foreach($info as $i)
            {
                return $i->fecha_ejecucion;
            }
        }else{

            return "";
        }



    }


    public function calculoconceptos(Request $request)
    {
        try {
            $data=json_encode($request->data);
            $json_response=array();
            if(empty($data))
            {
                $json_response=$this->messagerror();
            }else{
                $json_response=$this->calulo_servicio($data);
            }
        } catch (\Exception $e) {
            $json_response=$this->messagerror();            
        }
        return response()->json($json_response);
    }
    private function calulo_servicio($data)
    {       
        $json_response=array();
        $datos=array();
        $total=0; $total_derechos=0; $total_subsidio=0; $motivo_subsidio=''; $total_curr=0;
        $date = Carbon::now();
        $date = $date->format('Y');
        $uma='';        
        $findUMA=$this->umahistorydb->findWhere(['year'=>$date]);
        if($findUMA->count()==0)
        {
            $date=$date-1;
            $findUMA=$this->umahistorydb->findWhere(['year'=>$date]);            
        }
        foreach ($findUMA as $u) {
            $uma=$u->daily;
        }
        foreach (json_decode($data) as $key) {
            $reingresar=$key->reingresar;
            $total_reingresar=$key->copia_tramite;
            $no_lotes=$key->no_lotes;
            $nombre_servicio=''; $nombre_concepto='';$formula='';$partida='';    
            $conceptos=array();           

            $findTipoServicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=>(string)$key->id_procedure]);
            foreach ($findTipoServicio as $e) {
               $nombre_servicio=$e->Tipo_Descripcion;
            }
            $findcalculoconcepto=$this->conceptscalculationdb->findWhere(['id_procedure'=>$key->id_procedure]);
            foreach ($findcalculoconcepto as $f) {
                $formula=$f->formula;
                $nombre_concepto=$f->name_concept;
                $partida=$f->id_budget_heading;
                $max=$f->max_price;
                $min=$f->min_price;
                $moneda_min=$f->currency_min;
                $moneda_max=$f->currency_max;
                $moneda_total=$f->currency_total;
                $moneda_formula=$f->currency_formula;
                $round_millar=$f->round_amount_thousand;
                $method=$f->method;
                $valor_fijo=$f->total;
                $has_lot=$f->has_lot;
                $lot_equivalent=$f->lot_equivalence;
                $moneda_lot=$f->currency_lot_equivalence;
                if($method=='Variable'){
                    $v=$key->valor_de_operacion;                                       
                    $formula = str_replace('v', '$v', $formula);
                    $resultado=eval('return '.$formula.';');
                    $resultado=(double)$resultado;
                    /*if($moneda_formula==2)
                    { $resultado=$resultado*$uma;  } */                    
                }else{
                    if($moneda_total==2)
                    {
                        $resultado=$valor_fijo*$uma;
                    }else{
                        $resultado=$valor_fijo;
                    }
                    $resultado=(double)$resultado;                    
                }
                if($has_lot==1)
                {
                    $resultado=$this->calculoLotes($no_lotes,$uma,$valor_fijo);
                }               

                if($moneda_max==2)
                { $max=(double)$max*$uma;   }

                if($moneda_min==2)
                { $min=(double)$min*$uma;  }

                if($min==0)
                { $min=$resultado;  }

                if($max==0)
                { $max=$resultado;  }

                if($resultado>=$min && $resultado<=$max)
                {
                    $resultado=$resultado;
                }else{
                    if($resultado>=$max)
                    { $resultado=$max;  }

                    if($resultado<=$min)
                    { $resultado=$min;  }
                }
                if($reingresar=="si")
                {
                    $resultado=$resultado-$total_reingresar;
                }

                $resultado=(string)number_format($resultado, 2, '.', '');
                $decimal=explode(".", $resultado);             
                $decimal='0.'.$decimal[1];
                if($decimal>=.51)
                {
                    $resultado=round($resultado, 0, PHP_ROUND_HALF_UP);
                }else
                {
                    $resultado=round($resultado, 0, PHP_ROUND_HALF_DOWN);
                }
                $total=$total+$resultado;
                $conceptos []= array(
                    'nombre' =>$nombre_concepto,  
                    'total' => '$'.(string)number_format($resultado, 2, '.', ','), 
                    'partida' => (string)$partida, 
                    'total_c' => (string)number_format($resultado, 2, '.', '')
                );
            }            
            $datos []= array(
                'id_tramite' => $key->id_procedure,
                'tramite_nombre'=> $nombre_servicio,
                'conceptos'=>$conceptos 
            );
            $subsidio=$this->calculoSubsidios($key->id_procedure,$uma,$resultado);
            $total_subsidio=$total_subsidio+$subsidio;
        }
       
       $json_response= array(
        'total' =>(string)number_format($total, 2, '.', ''),
        'datos'=>$datos,
        'total_derechos'=>(string)number_format($total, 2, '.', ''),
        'total_subsidio'=>(string)number_format($total_subsidio, 2, '.', ''),
        'motivo_subsidio'=>(string)$motivo_subsidio,
        'total_curr'=>'$'.(string)number_format($total, 2, '.', ','),
        'total_derechos_curr'=>'$'.(string)number_format($total, 2, '.', ','),
        'total_subsidio_curr'=>'$'.(string)number_format($total_subsidio, 2, '.', ',')
        );
       return $json_response;
    }
    private function calculoLotes($no_lotes,$uma,$valor_lote)
    {
        $resultado=0;
        $resultado=$no_lotes*$valor_lote*$uma;
        return $resultado;

    }
    private function calculoSubsidios($id,$uma,$resultado)
    {
        $valor=0;
        $total_after=0;
        $moneda_sub=1;
        $total_maxi=0;
        $total_max=0;
        $calculo=0;
        $calculo_max=0;
        $subsidy_des=0;
        $findcalculosubsidio=$this->conceptsubsidiesdb->findWhere(['id_procedure'=>$id]);
        foreach ($findcalculosubsidio as $e) {
            $total_after=$e->total_after_subsidy;
            $moneda_sub=$e->currency_total;
            $total_max=$e->total_max_to_apply;
            $subsidy_des=$e->subsidy_description;
        }
        if($moneda_sub==2)
        {
            $calculo=$uma*$total_after;
            $calculo_max=$uma*$total_max;
            $valor=$calculo;
        }
        else{
            $calculo=$total_after;
            $calculo_max=$total_max;
            $valor=$calculo;
        }        
        if($calculo==0)
        {
            $valor=0;
        }else{
            if($resultado>=$calculo && $resultado<=$calculo_max)
            {
                $valor=$resultado-$calculo;
            }else{
                $valor=0;
            }
        }
        $valor=(string)number_format($valor, 2, '.', '');
        $decimal=explode(".", $valor);             
        $decimal='0.'.$decimal[1];
        if($decimal>=.51)
        {
            $valor=round($valor, 0, PHP_ROUND_HALF_UP);
        }else
        {
            $valor=round($valor, 0, PHP_ROUND_HALF_DOWN);
        }
        return $valor;
    }
    private function messagerror()
    {
        $error=array();
        $error=array(
                    "Code" => 400,
                    "Message" => 'fields required' );
        return $error;
    }

    public function valorUma()
    {
        $date = Carbon::now();
        $date = $date->format('Y');
        $datos=array(); 
        $responseJson=array();       
        $findUMA=$this->umahistorydb->findWhere(['year'=>$date]);
        if($findUMA->count()==0)
        {
            $date=$date-1;
            $findUMA=$this->umahistorydb->findWhere(['year'=>$date]);            
        }
        foreach ($findUMA as $u) {
            $datos = array(
                'daily' => $u->daily ,
                'monthly' => $u->monthly, 
                'yearly' => $u->yearly 
            );           
        }
        $responseJson = array(
            'status' => 'ok',
            'datos' => $datos
        );
        return response()->json($responseJson);

    }
    public function consultaSubsidio($id_tramite='')
    {
        $responseJson=array();
        if($id_tramite=='')
        {
            $responseJson= array(
                'status' => 'error',
                'error' => 'id tramite required',
                'tiene_subsidio' => 'no',
            );
        }else{
            $findcalculosubsidio=$this->conceptsubsidiesdb->findWhere(['id_procedure'=>$id_tramite]);
            if($findcalculosubsidio->count()>0)
            {
                $responseJson= array(
                    'status' => 'ok',
                    'error' => '',
                    'tiene_subsidio' => 'si',
                 );
            }else{
                {
                $responseJson= array(
                    'status' => 'ok',
                    'error' => '',
                    'tiene_subsidio' => 'no',
                 );
            }
            }
        }
        
        return response()->json($responseJson);
        
       
    }

    public function consultaPagos(Request $request)
    { 
        //log::info($request);
        $responseJson=array();
        $response=array();

        try
        {
            $user = ( isset($request->user) ) ? $request->user : "externo";
            
            $entidad= $this->checkEntity($user);

            if($entidad == 0)
            {
                $responseJson= $this->reponseVerf('400','user requerido',[]);
                
                return response()->json($responseJson);

            }else{
                
                // obtener todos los registros que ya se arrojaron
                $procesados = array();

                $pro = $this->pagossolicituddb->all();

                foreach($pro as $p)
                {
                    $procesados[]= $p->id_transaccion_motor;
                }

                $response=$this->oper_transaccionesdb
                    ->where('entidad',$entidad)
                    ->where('estatus',0)
                    ->whereNotIn('id_transaccion_motor', $procesados)->get();
               
               //log::info('registros: ' . $response->count());
                if($response->count() > 0)
                {
                    $temp = array();
                    foreach($response as $r)
                    {   
                        $temp[]= array(
                            "usuario"               => $user,
                            "entidad"               => $entidad,
                            "referencia"            => $r->referencia,
                            "id_transaccion_motor"  => $r->id_transaccion_motor,
                            "id_transaccion"        => $r->id_transaccion,
                            "estatus"               => $r->estatus,
                            "Total"                 => $r->importe_transaccion,
                            "MetododePago"          => $this->list_mp[$r->metodo_pago_id],
                            "cve_Banco"             => $r->tipo_pago,
                            "FechaTransaccion"      => $r->fecha_transaccion,
                            "FechaPago"             => $r->fecha_pago,
                            "FechaConciliacion"     => $this->obtenerfechaConciliacion($r->referencia),
                        );
                        
                    }

                    $responseJson= $this->reponseVerf('202','',$temp);
                }else{
                    $responseJson= $this->reponseVerf('202','Sin registros',$response);
                }
            }
        }catch (\Exception $e) {
            log::info('consultaPagos ' . $e->getMessage());
            dd($e->getMessage());
            $responseJson= $this->reponseVerf('400','ocurrio un error',[]);     
          return  response()->json($responseJson);            
        }
        return response()->json($responseJson);

    }

    public function PagosVerificados(Request $request)
    { 
        $fecha=Carbon::now()->format('Y-m-d H:m:s');
        $responseJson=array();
        $noInsert=array();
        //log::info($request->request);
        try{            
            $insolicitud=array();            
            $folios=$request->id_transaccion_motor;
            $user=$request->user;
            if($user==null)
            {
                $responseJson= $this->reponseVerf('400','user requerido',$noInsert);
                return response()->json($responseJson);
            }
            //(log::info(is_array($folios));
            if(empty($folios))
            {
                $responseJson= $this->reponseVerf('400','id_transaccion_motor requerido',$noInsert);
                return response()->json($responseJson);
            }
            foreach ($folios as $f) {
                $findEntTra=$this->oper_transaccionesdb->verifTransaccionesPagado($user,$f);                
                if($findEntTra->count()>0)
                {
                    foreach ($findEntTra as $e) {                        
                        if($e->existe<>null)
                        {
                            $noInsert []=array(
                                "estatus"=>"Ya se encuentra registrado",
                                "id_transaccion_motor"=>$f
                            );
                        }else{
                            //$insolicitud []=array(
                           // );
                            $inserts=$this->pagossolicituddb->create([
                                'id_transaccion_motor'=>$f
                            ]);  
                        }
                        
                    }
                }else{
                     $noInsert []=array(
                        "estatus"=>"No pertenece a una entidad y/o no existe el folio",
                        "id_transaccion_motor"=>$f
                    );
                }                       
            }
                //log::info($insolicitud);               
            
            //$inserts=$this->pagossolicituddb->insert($insolicitud);              
            $responseJson= $this->reponseVerf('202','Guardado exitoso',$noInsert);  
         }catch (\Exception $e) {
            $responseJson=$this->reponseVerf('400','ocurrio un error',[]);
            log::info('PagosVerificados insert' . $e->getMessage());
          return  response()->json($responseJson);            
        }
        return response()->json($responseJson);

    }
    public function consultaEntidadFolios(Request $request)
    { 
        $responseJson=array();
        $select=array();
        try{            
            $insolicitud=array();            
            $folios=$request->id_transaccion_motor;
            $entidad=$request->entidad;
            $user=$request->user;
            if($user==null){
                $responseJson= $this->reponseVerf('400','user requerido',[]);
                return response()->json($responseJson);
            }
            if($entidad==null && $folios==null){
                $responseJson= $this->reponseVerf('400','entidad / id_transaccion_motor requerido',[]);
                return response()->json($responseJson);
            }
            if($entidad==null)
            {
                $select=$this->oper_transaccionesdb->findTransaccionesFolio($user,'oper_transacciones.id_transaccion_motor',$folios);
            }else{
                $select=$this->oper_transaccionesdb->findTransaccionesEntidad($user,'oper_transacciones.entidad',$entidad);
            }           
                   
            $responseJson= $this->reponseVerf('202','',$select);  
         }catch (\Exception $e) {
            $responseJson=$this->reponseVerf('400','ocurrio un error',[]);
            log::info('PagosVerificados insert' . $e->getMessage());
          return  response()->json($responseJson);            
        }
        return response()->json($responseJson);

    }
    private function reponseVerf($status,$error,$responseJ)
    {
        $response=array();

        $response= array(
                    'code' => $status,
                    'status' => $error,
                    'response' => $responseJ,
                );
        return $response;
    }
}
