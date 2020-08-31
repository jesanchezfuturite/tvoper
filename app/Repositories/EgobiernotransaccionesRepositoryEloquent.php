<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernotransaccionesRepository;
use App\Entities\Egobiernotransacciones;
use App\Validators\EgobiernotransaccionesValidator;

use Illuminate\Support\Facades\Log;

/**
 * Class EgobiernotransaccionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernotransaccionesRepositoryEloquent extends BaseRepository implements EgobiernotransaccionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernotransacciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

     public function updateStatus($Status,$idTrans)
    {
        try{

            return Egobiernotransacciones::where( $idTrans )->update($Status);    
        
         }catch( \Exception $e){
            Log::info('[EgobiernotransaccionesRepositoryEloquent@updateStatus] Error ' . $e->getMessage());
        }
        

    }

    public function updateStatusInArray($ids)
    {
        try
        {
            
            $data = Egobiernotransacciones::whereIn('idTrans', $ids)->update( ['Status' => 0]);

        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent @ updateStatusInArray]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }
    public function consultaTransacciones($fechaIn,$fechaF)
    {
        try
       { 
            $data = Egobiernotransacciones::whereBetween('fechatramite',[$fechaIn,$fechaF])
            ->leftjoin('tipo_servicios', 'tipo_servicios.Tipo_Code','=','transacciones.TipoServicio')
            ->leftjoin('tipopago','tipopago.TipoPago', '=','transacciones.TipoPago')
            ->leftjoin('folios','folios.idTrans', '=','transacciones.idTrans')
            ->leftjoin('status','status.Status','=','transacciones.Status')
            ->leftjoin('operacion.oper_entidadtramite','operacion.oper_entidadtramite.tipo_servicios_id','=','transacciones.TipoServicio')
            ->leftjoin('operacion.oper_entidad','operacion.oper_entidad.id','=','operacion.oper_entidadtramite.entidad_id')
            ->leftjoin('operacion.oper_familiaentidad','operacion.oper_familiaentidad.entidad_id','=','oper_entidadtramite.entidad_id')
            ->leftjoin('operacion.oper_familia','operacion.oper_familia.id','=','operacion.oper_familiaentidad.familia_id')
            ->leftjoin('operacion.oper_processedregisters','operacion.oper_processedregisters.transaccion_id','=','transacciones.idTrans')
            ->select('transacciones.idTrans','status.Descripcion as status','tipo_servicios.Tipo_Descripcion as tiposervicio','transacciones.TitularTC','transacciones.fechatramite','transacciones.HoraTramite','transacciones.BancoSeleccion','tipopago.Descripcion as tipopago','transacciones.TotalTramite','transacciones.TipoServicio as tiposervicio_id','transacciones.Status as estatus_id','folios.CartKey1 as rfc','folios.CartKey2 as declarado','operacion.oper_processedregisters.transaccion_id','operacion.oper_entidad.nombre as entidad','operacion.oper_familia.nombre as familia')
            ->groupBy('transacciones.idTrans')
            ->get();
            return $data;
            //Log::info($data);
        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent@consultaTransacciones]  ERROR al consultar ");
            return false;
        }
    }
    public function consultaTransaccionesFolio($folio)
    {
        try
       { 
            $data = Egobiernotransacciones::where('transacciones.idTrans',$folio)
            ->leftjoin('tipo_servicios', 'tipo_servicios.Tipo_Code','=','transacciones.TipoServicio')
            ->leftjoin('tipopago','tipopago.TipoPago', '=','transacciones.TipoPago')
            ->leftjoin('folios','folios.idTrans', '=','transacciones.idTrans')
            ->leftjoin('status','status.Status','=','transacciones.Status')
            ->leftjoin('operacion.oper_entidadtramite','operacion.oper_entidadtramite.tipo_servicios_id','=','transacciones.TipoServicio')
            ->leftjoin('operacion.oper_entidad','operacion.oper_entidad.id','=','operacion.oper_entidadtramite.entidad_id')
            ->leftjoin('operacion.oper_familiaentidad','operacion.oper_familiaentidad.entidad_id','=','oper_entidadtramite.entidad_id')
            ->leftjoin('operacion.oper_familia','operacion.oper_familia.id','=','operacion.oper_familiaentidad.familia_id')
            ->leftjoin('operacion.oper_processedregisters','operacion.oper_processedregisters.transaccion_id','=','transacciones.idTrans')
            ->select('transacciones.idTrans','status.Descripcion as status','tipo_servicios.Tipo_Descripcion as tiposervicio','transacciones.TitularTC','transacciones.fechatramite','transacciones.HoraTramite','transacciones.BancoSeleccion','tipopago.Descripcion as tipopago','transacciones.TotalTramite','transacciones.TipoServicio as tiposervicio_id','transacciones.Status as estatus_id','folios.CartKey1 as rfc','folios.CartKey2 as declarado','operacion.oper_processedregisters.transaccion_id','operacion.oper_entidad.nombre as entidad','operacion.oper_familia.nombre as familia')
            ->groupBy('transacciones.idTrans')
            ->get();
            return $data;
            //Log::info($data);
        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent@consultaTransacciones]  ERROR al consultar ".$e);
            return false;
        }
    }
     public function consultaTransaccionesWhere($fechaIn,$fechaF,$rfc)
    {
        try
       {                
            $data = Egobiernotransacciones::whereBetween('fechatramite',[$fechaIn,$fechaF])
            ->leftjoin('tipo_servicios', 'tipo_servicios.Tipo_Code','=','transacciones.TipoServicio')
            ->leftjoin('tipopago','tipopago.TipoPago', '=','transacciones.TipoPago')
            ->leftjoin('folios','folios.idTrans', '=','transacciones.idTrans')
            ->leftjoin('status','status.Status','=','transacciones.Status')
            ->leftjoin('operacion.oper_entidadtramite','operacion.oper_entidadtramite.tipo_servicios_id','=','transacciones.TipoServicio')
            ->leftjoin('operacion.oper_entidad','operacion.oper_entidad.id','=','operacion.oper_entidadtramite.entidad_id')
            ->leftjoin('operacion.oper_familiaentidad','operacion.oper_familiaentidad.entidad_id','=','oper_entidadtramite.entidad_id')
            ->leftjoin('operacion.oper_familia','operacion.oper_familia.id','=','operacion.oper_familiaentidad.familia_id')
            ->leftjoin('operacion.oper_processedregisters','operacion.oper_processedregisters.transaccion_id','=','transacciones.idTrans')
            ->where($rfc)
            ->select('transacciones.idTrans','status.Descripcion as status','tipo_servicios.Tipo_Descripcion as tiposervicio','transacciones.TitularTC','transacciones.fechatramite','transacciones.HoraTramite','transacciones.BancoSeleccion','tipopago.Descripcion as tipopago','transacciones.TotalTramite','transacciones.TipoServicio as tiposervicio_id','transacciones.Status as estatus_id','folios.CartKey1 as rfc','folios.CartKey2 as declarado','operacion.oper_processedregisters.transaccion_id','operacion.oper_entidad.nombre as entidad','operacion.oper_familia.nombre as familia')
            ->groupBy('transacciones.idTrans')
            ->get();
            
            return $data;
        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent@consultaTransaccionesWhere]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }
    public function consultaContr($fechaIn,$fechaF)
    {
        try{
        $data = Egobiernotransacciones::whereBetween('fechatramite',[$fechaIn,$fechaF])
        ->join('transacciones_gpm','transacciones_gpm.id_transaccion','=','transacciones.idTrans')
        ->join('tramites','tramites.id_transaccion','=','transacciones.idTrans')
        ->join('tipo_servicios','tipo_servicios.Tipo_Code','=','tramites.id_tipo_tramite')
        ->select('transacciones_gpm.id_transaccion', 'transacciones_gpm.id_transaccion_entidad', 'transacciones.TotalTramite','transacciones.fechaTramite', 'transacciones.horaTramite', 'tramites.id_tramite','tramites.id_tramite_entidad', 'tramites.importe_tramite','tipo_servicios.Tipo_Descripcion')
        //->groupBy('contribuyente.transacciones_gpm.id_transaccion')
        ->get();
        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@Egobiernotransacciones] Error ' . $e->getMessage());
        }      
    }

    
    
}
