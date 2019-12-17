<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransaccionesRepository;
use App\Entities\Transacciones;
use App\Validators\TransaccionesValidator;

/**
 * Class TransaccionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TransaccionesRepositoryEloquent extends BaseRepository implements TransaccionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transacciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function updateTransacciones($estatus,$id_transaccion_motor)
    {
        try{

            return Transacciones::where( $id_transaccion_motor )->update($estatus);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@updateTransacciones] Error ' . $e->getMessage());
        }       

    }
    public function consultaTransacciones($fechaIn,$fechaF)
    {
        try{

        $data = Transacciones::whereBetween('fecha_transaccion',[$fechaIn,$fechaF])
        ->join('egob.status','egob.status.Status','=','oper_transacciones.estatus')
        ->join('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->join('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->join('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->join('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->join('egob.tipo_servicios','egob.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')        
        ->join('egob.tipopago','egob.tipopago.TipoPago','=','oper_transacciones.tipo_pago')        
        ->select('egob.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad','egob.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion','egob.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite','egob.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia')
        ->groupBy('oper_transacciones.id_transaccion')
        ->get();
        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaTransacciones] Error ' . $e->getMessage());
        }      
    }
    public function consultaTransaccionesWhere($fechaIn,$fechaF,$rfc)
    {
        try{        
        $data = Transacciones::whereBetween('fecha_transaccion',[$fechaIn,$fechaF])
        ->join('egob.status','egob.status.Status','=','oper_transacciones.estatus')
        ->join('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->join('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->join('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->join('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->join('egob.tipo_servicios','egob.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')        
        ->join('egob.tipopago','egob.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        ->where('oper_tramites.rfc',$rfc)       
        ->select('egob.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad','egob.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion','egob.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite','egob.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia')
        ->groupBy('oper_transacciones.id_transaccion')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaTransaccionesWhere] Error ' . $e->getMessage());
        }      
    }
    
    
}
