<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**** Repository ****/
use App\Repositories\ConceptsCalculationRepositoryEloquent;
use App\Repositories\ConceptsubsidiesRepositoryEloquent;
use App\Repositories\UmahistoryRepositoryEloquent;
use App\Repositories\CurrenciesRepositoryEloquent;
use App\Repositories\ApplicableSubjectRepositoryEloquent;
/***/
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

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

    // In this method we ensure that the user is logged in using the middleware


    public function __construct( 
       
        EgobiernotiposerviciosRepositoryEloquent $tiposerviciodb,
        EgobiernopartidasRepositoryEloquent $partidasdb,
        ConceptsCalculationRepositoryEloquent $conceptscalculationdb,
        ConceptsubsidiesRepositoryEloquent $conceptsubsidiesdb,
        UmahistoryRepositoryEloquent $umahistorydb,
        CurrenciesRepositoryEloquent $currenciesdb,
        ApplicableSubjectRepositoryEloquent $applicablesubjectdb

    )
    {
        $this->tiposerviciodb=$tiposerviciodb;
        $this->partidasdb=$partidasdb;
        $this->conceptscalculationdb=$conceptscalculationdb;
        $this->conceptsubsidiesdb=$conceptsubsidiesdb;
        $this->umahistorydb=$umahistorydb;
        $this->currenciesdb=$currenciesdb;
        $this->applicablesubjectdb=$applicablesubjectdb;
    }

    public function calculoconceptos(Request $request)
    {
        
        $data=json_encode($request->data);
        $json_response=array();
        if(empty($data))
        {
            $json_response=$this->messagerror();
        }
        else{

            $json_response=$this->calulo_servicio($data);
        }
        return response()->json($json_response);
    }
    private function calulo_servicio($data)
    {
       
        $json_response=array();
        $datos=array();
        $total=0;
        $total_derechos=0;
        $total_subsidio=0;
        $motivo_subsidio=0;
        $total_curr=0;
        $total_derechos_curr=0;
        $total_subsidio_curr=0;
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
            //log::info($uma);
        }
        foreach (json_decode($data) as $key) {
            $nombre_servicio='';
            $nombre_concepto='';
            $formula='';
            $partida='';
            $conceptos=array();           

            $findTipoServicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=>(string)$key->id_servicio]);
            foreach ($findTipoServicio as $e) {
               $nombre_servicio=$e->Tipo_Descripcion;
            }
            $findcalculoconcepto=$this->conceptscalculationdb->findWhere(['id_procedure'=>$key->id_servicio]);
            foreach ($findcalculoconcepto as $f) {
                $formula=$f->formula;
                $nombre_concepto=$f->name_concept;
                $partida=$f->id_budget_heading;
                $max=$f->max_price;
                $min=$f->min_price;
                $round_millar=$f->round_amount_thousand;
                $method=$f->method;
                $valor_fijo=$f->total;
                //log::info($min.' '.$max.' '.$round_millar.' '.$method);
                if($method=='Variable'){
                    $v=$key->valor_de_operacion;
                    $formula = str_replace('v', '$v', $formula);
                    $resultado=eval('return '.$formula.';');
                    $resultado=(double)$resultado;
                }else{
                    $resultado=$valor_fijo*$uma;
                    $resultado=(double)$resultado;                    
                }
                               $max=(double)$max*$uma;
                $min=(double)$min*$uma;
                if($min==0)
                {
                    $min=$resultado;
                }
                if($max==0)
                {
                    $max=$resultado;
                }
                if($resultado>=$min && $resultado<=$max)
                {
                    $resultado=$resultado;
                }else{

                    if($resultado>=$max)
                    {
                        $resultado=$max;
                    }
                    if($resultado<=$min)
                    {
                        $resultado=$min;
                    }
                }
                 $decimal=explode(".", $resultado);
                log::info($decimal);
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
                'id_tramite' => $key->id_servicio,
                'tramite_nombre'=> $nombre_servicio,
                'conceptos'=>$conceptos 
            );
        }
       
       $json_response= array(
        'total' =>(string)number_format($total, 2, '.', ''),
        'datos'=>$datos,
        'total_derechos'=>(string)number_format($total, 2, '.', ''),
        'total_subsidio'=>(string)$total_subsidio,
        'motivo_subsidio'=>(string)$motivo_subsidio,
        'total_curr'=>(string)$total_curr,
        'total_derechos_curr'=>'$'.(string)number_format($total, 2, '.', ','),
        'total_subsidio_curr'=>(string)$total_subsidio_curr
        );
       return $json_response;
    }
    private function messagerror()
    {
        $error=array();
        $error=array(
                    "Code" => 400,
                    "Message" => 'field required' );
        return $error;
    }
}
