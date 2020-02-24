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
        //try {
            $data=json_encode($request->data);
            $json_response=array();
            if(empty($data))
            {
                $json_response=$this->messagerror();
            }else{
                $json_response=$this->calulo_servicio($data);
            }
        /*} catch (\Exception $e) {
            $json_response=$this->messagerror();            
        }*/
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
}