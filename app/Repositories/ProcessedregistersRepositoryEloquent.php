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
        ->join('egob.partidas','egob.partidas.id_servicio','=','oper_processedregisters.tipo_servicio')    
        ->join('egob.folios','egob.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join('egob.referenciabancaria','egob.referenciabancaria.idTrans','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.tipo_servicio','oper_processedregisters.info_transacciones','egob.partidas.id_partida','egob.partidas.descripcion','egob.folios.Folio','egob.folios.CartImporte','egob.referenciabancaria.Linea','oper_processedregisters.cuenta_banco','oper_processedregisters.cuenta_alias','oper_processedregisters.fecha_ejecucion')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@GenericoCorte] Error ' . $e->getMessage());
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
        ->join('egob.transacciones','egob.transacciones.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join('egob.nomina','egob.nomina.idtran','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','egob.transacciones.fuente','egob.transacciones.TipoPago','egob.nomina.folio','egob.nomina.munnom','egob.nomina.cvenom','egob.nomina.rfcalf','egob.nomina.rfcnum','egob.nomina.rfchomo','egob.nomina.tipopago','egob.nomina.mesdec','egob.nomina.tridec','egob.nomina.anodec','egob.nomina.numemp','egob.nomina.remuneracion','egob.nomina.base','egob.nomina.actualiza','egob.nomina.recargos','egob.nomina.gtoeje','egob.nomina.sancion','egob.nomina.compensacion')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@NominaCorte] Error ' . $e->getMessage());
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
        ->join('cont.detalle_isan','cont.detalle_isan.idTrans','=','oper_processedregisters.transaccion_id')
        ->join('egob.transacciones','egob.transacciones.idTrans','=','oper_processedregisters.transaccion_id')
        ->join('egob.folios','egob.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','egob.transacciones.TipoPago','egob.folios.Folio','egob.folios.CartKey1','cont.detalle_isan.cuenta','cont.detalle_isan.curp','cont.detalle_isan.nombre_razonS','cont.detalle_isan.tipo_declaracion','cont.detalle_isan.tipo_tramite','cont.detalle_isan.anio_1','cont.detalle_isan.mes_1','cont.detalle_isan.num_complementaria','cont.detalle_isan.folio_anterior','cont.detalle_isan.declaracion_anterior','cont.detalle_isan.tipo_establecimiento','cont.detalle_isan.tipo_contribuyente','cont.detalle_isan.ALR','cont.detalle_isan.autos_enajenados_unidades','cont.detalle_isan.camiones_enajenados_unidades','cont.detalle_isan.autos_exentos_unidades','cont.detalle_isan.vehiculos_exentos_unidades','cont.detalle_isan.autos_enajenados_valor','cont.detalle_isan.camiones_enajenados_valor','cont.detalle_isan.autos_exentos_valor','cont.detalle_isan.vehiculos_exentos_valor','cont.detalle_isan.total_unidades','cont.detalle_isan.total_valor','cont.detalle_isan.vehiculos_incorporados','cont.detalle_isan.facturas_expedidas_inicial','cont.detalle_isan.facturas_expedidas_final','cont.detalle_isan.vehiculos_enajenados_periodo','cont.detalle_isan.valor_total_enajenacion','cont.detalle_isan.impuesto','cont.detalle_isan.actualizacion','cont.detalle_isan.recargos','cont.detalle_isan.dif_impuesto','cont.detalle_isan.dif_actualizacion','cont.detalle_isan.dif_recargos','egob.transacciones.tipopago')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ISANCorte] Error ' . $e->getMessage());
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
        ->join('cont.detalle_ish','cont.detalle_ish.idTrans','=','oper_processedregisters.transaccion_id') 
        ->join('egob.transacciones','egob.transacciones.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join('egob.folios','egob.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','egob.transacciones.TipoPago','egob.folios.Folio','egob.folios.CartKey1','cont.detalle_ish.cuenta','cont.detalle_ish.curp','cont.detalle_ish.nombre_razonS','cont.detalle_ish.tipo_declaracion','cont.detalle_ish.anio','cont.detalle_ish.mes','cont.detalle_ish.num_complementaria','cont.detalle_ish.folio_anterior','cont.detalle_ish.declaracion_anterior','cont.detalle_ish.erogaciones','cont.detalle_ish.impuesto','cont.detalle_ish.actualizacion','cont.detalle_ish.recargos','cont.detalle_ish.dif_imp','cont.detalle_ish.dif_act','cont.detalle_ish.dif_rec','egob.transacciones.tipopago')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ISHCorte] Error ' . $e->getMessage());
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
        ->join('cont.detalle_isop','cont.detalle_isop.idTrans','=','oper_processedregisters.transaccion_id') 
        ->join('egob.transacciones','egob.transacciones.idTrans','=','oper_processedregisters.transaccion_id')    
        ->join('egob.folios','egob.folios.idTrans','=','oper_processedregisters.transaccion_id')    
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','egob.transacciones.TipoPago','egob.folios.Folio','egob.folios.CartKey1','cont.detalle_isop.cuenta','cont.detalle_isop.curp','cont.detalle_isop.nombre_razonS','cont.detalle_isop.mes','cont.detalle_isop.anio','cont.detalle_isop.premio','cont.detalle_isop.impuesto','cont.detalle_isop.actualizacion','cont.detalle_isop.recargos','cont.detalle_isop.total_contribuciones')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@ISOPCorte] Error ' . $e->getMessage());
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
        ->join('cont.detalle_isn_prestadora','cont.detalle_isn_prestadora.idtrans','=','oper_processedregisters.transaccion_id')   
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','cont.detalle_isn_prestadora.Folio' ,'cont.detalle_isn_prestadora.rfcalfa' ,'cont.detalle_isn_prestadora.rfcnum' ,'cont.detalle_isn_prestadora.rfchom' ,'cont.detalle_isn_prestadora.cuenta' ,'cont.detalle_isn_prestadora.nombre_razonS' ,'cont.detalle_isn_prestadora.tipo_declaracion' ,'cont.detalle_isn_prestadora.anio' ,'cont.detalle_isn_prestadora.mes' ,'cont.detalle_isn_prestadora.folio_anterior' ,'cont.detalle_isn_prestadora.num_complementaria' ,'cont.detalle_isn_prestadora.declaracion_anterior' ,'cont.detalle_isn_prestadora.no_empleados' ,'cont.detalle_isn_prestadora.remuneraciones' ,'cont.detalle_isn_prestadora.impuesto' ,'cont.detalle_isn_prestadora.cant_acreditada' ,'cont.detalle_isn_prestadora.actualizacion','cont.detalle_isn_prestadora.recargos','cont.detalle_isn_prestadora.dif_impuesto','cont.detalle_isn_prestadora.dif_actualizacion','cont.detalle_isn_prestadora.dif_recargos' )
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@PrestadoraServicios_Corte] Error ' . $e->getMessage());
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
        ->join('cont.detalle_isn_retenedor','cont.detalle_isn_retenedor.idtrans','=','oper_processedregisters.transaccion_id')   
        ->join('cont.detalle_retenciones','cont.detalle_retenciones.idtrans','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','cont.detalle_isn_retenedor.Folio','cont.detalle_isn_retenedor.rfcalfa','cont.detalle_isn_retenedor.rfcnum','cont.detalle_isn_retenedor.rfchom','cont.detalle_isn_retenedor.cuenta','cont.detalle_isn_retenedor.tipo_declaracion','cont.detalle_isn_retenedor.anio','cont.detalle_isn_retenedor.mes','cont.detalle_isn_retenedor.num_complementaria','cont.detalle_isn_retenedor.folio_anterior','cont.detalle_isn_retenedor.declaracion_anterior','cont.detalle_isn_retenedor.actualizacion','cont.detalle_isn_retenedor.recargos', 'cont.detalle_retenciones.nombre_retenedora','cont.detalle_retenciones.rfc_prestadora','cont.detalle_retenciones.cuenta as cuenta_2','cont.detalle_retenciones.nombre_prestadora','cont.detalle_retenciones.no_empleados','cont.detalle_retenciones.remuneraciones','cont.detalle_retenciones.retencion')
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@RetenedoraServicios_Corte] Error ' . $e->getMessage());
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
        ->join('cont.det_imp_isop','cont.det_imp_isop.idTrans','=','oper_processedregisters.transaccion_id')
        ->join('egob.folios','egob.folios.idTrans','=','oper_processedregisters.transaccion_id')
        ->select('oper_processedregisters.transaccion_id','oper_processedregisters.fecha_ejecucion','oper_processedregisters.info_transacciones','egob.folios.Folio','egob.folios.CartDescripcion', 'cont.det_imp_isop.rfcalf','cont.det_imp_isop.rfcnum','cont.det_imp_isop.rfchom','cont.det_imp_isop.cve_mpo','cont.det_imp_isop.cuenta','cont.det_imp_isop.curp','cont.det_imp_isop.cve_imp','cont.det_imp_isop.tipo_dec','cont.det_imp_isop.mes','cont.det_imp_isop.anio','cont.det_imp_isop.num_comp','cont.det_imp_isop.folio_anterior','cont.det_imp_isop.imp_anterior' )
        ->groupBy('oper_processedregisters.transaccion_id')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@Juegos_Apuestas_Corte] Error ' . $e->getMessage());
        }        
    }  

    public function UpdatePorTransaccion($campos,$id_transaccion)
    {
        try{
            $data= Processedregisters::where('transaccion_id','=',$id_transaccion)->update(['archivo_corte'=>$campos]);  
        
        }catch( \Exception $e){
            Log::info('[ProcessedregistersRepositoryEloquent@UpdatePorTransaccion] Error ' . $e->getMessage());
        }

    } 
}
