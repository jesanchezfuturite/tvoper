<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProcessedregistersRepository;
use App\Entities\Processedregisters;
use App\Validators\ProcessedregistersValidator;

use Illuminate\Support\Facades\Log;

/**
 * Class ProcessedregistersRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProcessedregistersRepositoryEloquent extends BaseRepository implements ProcessedregistersRepository
{
    protected $db="egobierno";
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Processedregisters::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * This method updates the control table in status serialized field and updates the message
     * @param info => array with the info to modify, option => status to be configured
     *
     * @return false if get an error 
     */
    public function updateStatusTo($info, $option)
    {
        try
        {
            $data = Processedregisters::whereIn('transaccion_id', $info)->update( ['status' => $option]);

        }catch( \Exception $e ){
            Log::info("[ProcessedregistersRepositoryEloquent @ updateStatusInArray]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }

    /**
     * This method updates the control table in status serialized field and updates the message
     * @param info => array with the info to modify, option => status to be configured
     *
     * @return false if get an error 
     */
    public function updateStatusPerReferenceTo($info, $option)
    {
        try
        {
            $data = Processedregisters::whereIn('referencia', $info)->update( ['status' => $option]);

        }catch( \Exception $e ){
            Log::info("[ProcessedregistersRepositoryEloquent @ updateStatusInArray]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }
    public function Generico_Corte($fecha,$banco,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)   
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join($this->db . '.partidas',$this->db . '.partidas.id_servicio','=','oper_processedregisters.tipo_servicio')    
        ->join($this->db . '.folios',$this->db . '.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join($this->db . '.referenciabancaria',$this->db . '.referenciabancaria.idTrans','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.id','oper_processedregisters.referencia','oper_processedregisters.banco_id','oper_processedregisters.tipo_servicio','oper_processedregisters.info_transacciones',$this->db . '.partidas.id_partida',$this->db . '.partidas.descripcion',$this->db . '.folios.Folio',$this->db . '.folios.CartImporte',$this->db . '.referenciabancaria.Linea','oper_processedregisters.cuenta_banco','oper_processedregisters.cuenta_alias','oper_processedregisters.fecha_ejecucion','oper_processedregisters.day','oper_processedregisters.month','oper_processedregisters.year')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@GenericoCorte] Error ' . $e->getMessage());
            return null;
        }        
    }
   
   public function Generico_Corte_Oper($fecha,$banco,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)   
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join('oper_transacciones','oper_transacciones.id_transaccion_motor','=','oper_processedregisters.transaccion_id')    
        ->join('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.id','oper_processedregisters.referencia','oper_processedregisters.banco_id','oper_processedregisters.info_transacciones','oper_processedregisters.cuenta_banco','oper_processedregisters.cuenta_alias','oper_processedregisters.fecha_ejecucion','oper_processedregisters.day','oper_processedregisters.month','oper_processedregisters.year','oper_transacciones.metodo_pago_id','oper_transacciones.cuenta_deposito','fecha_transaccion as fecha_tramite','fecha_transaccion as hora_tramite','oper_tramites.id_tramite_motor as Folio','oper_tramites.id_tipo_servicio as tipo_servicio')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@GenericoCorte] Error ' . $e->getMessage());
            return null;
        }        
    }

    public function Nomina_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio) 
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join($this->db . '.transacciones',$this->db . '.transacciones.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join($this->db . '.nomina',$this->db . '.nomina.idtran','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones',$this->db . '.transacciones.fuente',$this->db . '.transacciones.TipoPago',$this->db . '.nomina.folio',$this->db . '.nomina.munnom',$this->db . '.nomina.cvenom',$this->db . '.nomina.rfcalf',$this->db . '.nomina.rfcnum',$this->db . '.nomina.rfchomo',$this->db . '.nomina.tipopago',$this->db . '.nomina.mesdec',$this->db . '.nomina.tridec',$this->db . '.nomina.anodec',$this->db . '.nomina.numemp',$this->db . '.nomina.remuneracion',$this->db . '.nomina.base',$this->db . '.nomina.actualiza',$this->db . '.nomina.recargos',$this->db . '.nomina.gtoeje',$this->db . '.nomina.sancion',$this->db . '.nomina.compensacion')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@NominaCorte] Error ' . $e->getMessage());
            return null;
        }        
    }
    public function ISAN_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio)  
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)  
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join('contribuyente.detalle_isan','contribuyente.detalle_isan.idTrans','=','oper_processedregisters.transaccion_id')
        ->join($this->db . '.transacciones',$this->db . '.transacciones.idTrans','=','oper_processedregisters.transaccion_id')
        ->join($this->db . '.folios',$this->db . '.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones',$this->db . '.transacciones.TipoPago',$this->db . '.folios.Folio',$this->db . '.folios.CartKey1','contribuyente.detalle_isan.cuenta','contribuyente.detalle_isan.curp','contribuyente.detalle_isan.nombre_razonS','contribuyente.detalle_isan.tipo_declaracion','contribuyente.detalle_isan.tipo_tramite','contribuyente.detalle_isan.anio_1','contribuyente.detalle_isan.mes_1','contribuyente.detalle_isan.num_complementaria','contribuyente.detalle_isan.folio_anterior','contribuyente.detalle_isan.declaracion_anterior','contribuyente.detalle_isan.tipo_establecimiento','contribuyente.detalle_isan.tipo_contribuyente','contribuyente.detalle_isan.ALR','contribuyente.detalle_isan.autos_enajenados_unidades','contribuyente.detalle_isan.camiones_enajenados_unidades','contribuyente.detalle_isan.autos_exentos_unidades','contribuyente.detalle_isan.vehiculos_exentos_unidades','contribuyente.detalle_isan.autos_enajenados_valor','contribuyente.detalle_isan.camiones_enajenados_valor','contribuyente.detalle_isan.autos_exentos_valor','contribuyente.detalle_isan.vehiculos_exentos_valor','contribuyente.detalle_isan.total_unidades','contribuyente.detalle_isan.total_valor','contribuyente.detalle_isan.vehiculos_incorporados','contribuyente.detalle_isan.facturas_expedidas_inicial','contribuyente.detalle_isan.facturas_expedidas_final','contribuyente.detalle_isan.vehiculos_enajenados_periodo','contribuyente.detalle_isan.valor_total_enajenacion','contribuyente.detalle_isan.impuesto','contribuyente.detalle_isan.actualizacion','contribuyente.detalle_isan.recargos','contribuyente.detalle_isan.dif_impuesto','contribuyente.detalle_isan.dif_actualizacion','contribuyente.detalle_isan.dif_recargos',$this->db . '.transacciones.tipopago')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ISANCorte] Error ' . $e->getMessage());
            return null;
        }        
    }
    public function ISH_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
       $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio)  
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)  
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join('contribuyente.detalle_ish','contribuyente.detalle_ish.idTrans','=','oper_processedregisters.transaccion_id') 
        ->join($this->db . '.transacciones',$this->db . '.transacciones.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join($this->db . '.folios',$this->db . '.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones',$this->db . '.transacciones.TipoPago',$this->db . '.folios.Folio',$this->db . '.folios.CartKey1','contribuyente.detalle_ish.cuenta','contribuyente.detalle_ish.curp','contribuyente.detalle_ish.nombre_razonS','contribuyente.detalle_ish.tipo_declaracion','contribuyente.detalle_ish.anio','contribuyente.detalle_ish.mes','contribuyente.detalle_ish.num_complementaria','contribuyente.detalle_ish.folio_anterior','contribuyente.detalle_ish.declaracion_anterior','contribuyente.detalle_ish.erogaciones','contribuyente.detalle_ish.impuesto','contribuyente.detalle_ish.actualizacion','contribuyente.detalle_ish.recargos','contribuyente.detalle_ish.dif_imp','contribuyente.detalle_ish.dif_act','contribuyente.detalle_ish.dif_rec',$this->db . '.transacciones.tipopago')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ISHCorte] Error ' . $e->getMessage());
            return null;
        }        
    }
   
    public function ISOP_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio)  
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)  
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join('contribuyente.detalle_isop','contribuyente.detalle_isop.idTrans','=','oper_processedregisters.transaccion_id') 
        ->join($this->db . '.transacciones',$this->db . '.transacciones.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join($this->db . '.folios',$this->db . '.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones',$this->db . '.transacciones.TipoPago',$this->db . '.folios.Folio',$this->db . '.folios.CartKey1','contribuyente.detalle_isop.cuenta','contribuyente.detalle_isop.curp','contribuyente.detalle_isop.nombre_razonS','contribuyente.detalle_isop.mes','contribuyente.detalle_isop.anio','contribuyente.detalle_isop.premio','contribuyente.detalle_isop.impuesto','contribuyente.detalle_isop.actualizacion','contribuyente.detalle_isop.recargos','contribuyente.detalle_isop.total_contribuciones')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ISOPCorte] Error ' . $e->getMessage());
            return null;
        }        
    }
    public function PrestadoraServicios_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio)  
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)  
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join('contribuyente.detalle_isn_prestadora','contribuyente.detalle_isn_prestadora.idtrans','=','oper_processedregisters.transaccion_id')   
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','contribuyente.detalle_isn_prestadora.Folio' ,'contribuyente.detalle_isn_prestadora.rfcalfa' ,'contribuyente.detalle_isn_prestadora.rfcnum' ,'contribuyente.detalle_isn_prestadora.rfchom' ,'contribuyente.detalle_isn_prestadora.cuenta' ,'contribuyente.detalle_isn_prestadora.nombre_razonS' ,'contribuyente.detalle_isn_prestadora.tipo_declaracion' ,'contribuyente.detalle_isn_prestadora.anio' ,'contribuyente.detalle_isn_prestadora.mes' ,'contribuyente.detalle_isn_prestadora.folio_anterior' ,'contribuyente.detalle_isn_prestadora.num_complementaria' ,'contribuyente.detalle_isn_prestadora.declaracion_anterior' ,'contribuyente.detalle_isn_prestadora.no_empleados' ,'contribuyente.detalle_isn_prestadora.remuneraciones' ,'contribuyente.detalle_isn_prestadora.impuesto' ,'contribuyente.detalle_isn_prestadora.cant_acreditada' ,'contribuyente.detalle_isn_prestadora.actualizacion','contribuyente.detalle_isn_prestadora.recargos','contribuyente.detalle_isn_prestadora.dif_impuesto','contribuyente.detalle_isn_prestadora.dif_actualizacion','contribuyente.detalle_isn_prestadora.dif_recargos' )
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@PrestadoraServicios_Corte] Error ' . $e->getMessage());
            return null;
        }        
    }
    public function RetenedoraServicios_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio)  
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta) 
        ->where('oper_processedregisters.archivo_corte','=','') 
        ->join('contribuyente.detalle_isn_retenedor','contribuyente.detalle_isn_retenedor.idtrans','=','oper_processedregisters.transaccion_id')   
        ->join('contribuyente.detalle_retenciones','contribuyente.detalle_retenciones.idtrans','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','contribuyente.detalle_isn_retenedor.Folio','contribuyente.detalle_isn_retenedor.rfcalfa','contribuyente.detalle_isn_retenedor.rfcnum','contribuyente.detalle_isn_retenedor.rfchom','contribuyente.detalle_isn_retenedor.cuenta','contribuyente.detalle_isn_retenedor.tipo_declaracion','contribuyente.detalle_isn_retenedor.anio','contribuyente.detalle_isn_retenedor.mes','contribuyente.detalle_isn_retenedor.num_complementaria','contribuyente.detalle_isn_retenedor.folio_anterior','contribuyente.detalle_isn_retenedor.declaracion_anterior','contribuyente.detalle_isn_retenedor.actualizacion','contribuyente.detalle_isn_retenedor.recargos', 'contribuyente.detalle_retenciones.nombre_retenedora','contribuyente.detalle_retenciones.rfc_prestadora','contribuyente.detalle_retenciones.cuenta as cuenta_2','contribuyente.detalle_retenciones.nombre_prestadora','contribuyente.detalle_retenciones.no_empleados','contribuyente.detalle_retenciones.remuneraciones','contribuyente.detalle_retenciones.retencion')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@RetenedoraServicios_Corte] Error ' . $e->getMessage());
            return null;
        }        
    }
    public function Juegos_Apuestas_Corte($fecha,$banco,$tipoServicio,$cuenta,$alias)
    {
       try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.fecha_ejecucion','=',$fecha)  
        ->where('oper_processedregisters.banco_id','=',$banco)  
        ->where('oper_processedregisters.tipo_servicio','=',$tipoServicio)  
        ->where('oper_processedregisters.cuenta_alias','=',$alias)
        ->where('oper_processedregisters.cuenta_banco','=',$cuenta)
        ->where('oper_processedregisters.archivo_corte','=','')
        ->join('contribuyente.det_imp_isop','contribuyente.det_imp_isop.idTrans','=','oper_processedregisters.transaccion_id')
        ->join($this->db . '.folios',$this->db . '.folios.idTrans','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones',$this->db . '.folios.Folio',$this->db . '.folios.CartDescripcion', 'contribuyente.det_imp_isop.rfcalf','contribuyente.det_imp_isop.rfcnum','contribuyente.det_imp_isop.rfchom','contribuyente.det_imp_isop.cve_mpo','contribuyente.det_imp_isop.cuenta','contribuyente.det_imp_isop.curp','contribuyente.det_imp_isop.cve_imp','contribuyente.det_imp_isop.tipo_dec','contribuyente.det_imp_isop.mes','contribuyente.det_imp_isop.anio','contribuyente.det_imp_isop.num_comp','contribuyente.det_imp_isop.folio_anterior','contribuyente.det_imp_isop.imp_anterior' )
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@Juegos_Apuestas_Corte] Error ' . $e->getMessage());
            return null;
        }        
    }  

    public function UpdatePorTransaccion($campos,$id_transaccion)
    {
        try{
            $data= Processedregisters::where('id','=',$id_transaccion)->update(['archivo_corte'=>$campos]);
        
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@UpdatePorTransaccion] Error ' . $e->getMessage());
            return null;
        }

    } 

    public function ConsultaFechaEjecucion($fechaIn,$fechaFin)
    {
        try{        
        $data = Processedregisters::where('oper_processedregisters.status','=','p')
        ->where('oper_processedregisters.created_at','>',$fechaIn)      
        ->where('oper_processedregisters.created_at','<',$fechaFin)            
        ->where('oper_processedregisters.archivo_corte','=','')
        ->select('oper_processedregisters.banco_id','oper_processedregisters.cuenta_alias','oper_processedregisters.cuenta_banco','oper_processedregisters.fecha_ejecucion')
        ->groupBy('oper_processedregisters.banco_id','oper_processedregisters.cuenta_alias','oper_processedregisters.cuenta_banco','oper_processedregisters.fecha_ejecucion')
        ->distinct()
        ->get();

        return $data;      
        
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ConsultaFechaEjecucion] Error ' . $e->getMessage());
            return null;
        }

    }




    /**
     * This method is used in command Egobtransacciones
     *  AS FOLLOWS:
     *  update the info from transacciones where registers are processed
     *  
     * @param $data: info to update / idTrans CID
     *
     *
     * @return true / false
    */

    public function completeInfoFromEgob($data,$idTrans)
    {
        try
        {
            $data = Processedregisters::where('transaccion_id', $idTrans)->update( $data );
            return true;
        }catch( \Exception $e ){
            Log::info("[ProcessedRegistersRepositoryEloquent @ completeInfoFromEgob] ERROR - " . $e->getMessage());
            return false;
        }    
    }
}
