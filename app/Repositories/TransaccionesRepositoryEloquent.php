<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransaccionesRepository;
use App\Entities\Transacciones;
use App\Validators\TransaccionesValidator;
use Illuminate\Support\Facades\Log;

/**
 * Class TransaccionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TransaccionesRepositoryEloquent extends BaseRepository implements TransaccionesRepository
{
    protected $db='egobierno';
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
        ->join($this->db . '.status',$this->db . '.status.Status','=','oper_transacciones.estatus')
        ->join('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->join('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->join('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->join('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->join($this->db . '.tipo_servicios',$this->db . '.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')        
        ->join($this->db . '.tipopago',$this->db . '.tipopago.TipoPago','=','oper_transacciones.tipo_pago')        
        ->select($this->db . '.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad',$this->db . '.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion',$this->db . '.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite',$this->db . '.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia','oper_transacciones.referencia','oper_transacciones.id_transaccion_motor')
        ->groupBy('oper_transacciones.id_transaccion_motor')
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
        ->join($this->db . '.status',$this->db . '.status.Status','=','oper_transacciones.estatus')
        ->join('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->join('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->join('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->join('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->join($this->db . '.tipo_servicios',$this->db . '.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')        
        ->join($this->db . '.tipopago',$this->db . '.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        ->where('oper_tramites.rfc',$rfc)       
        ->select($this->db . '.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad',$this->db . '.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion',$this->db . '.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite',$this->db . '.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia')
        ->groupBy('oper_transacciones.id_transaccion')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaTransaccionesWhere] Error ' . $e->getMessage());
        }      
    }
    public function updateEnvioCorreo($estatus,$id_transaccion_motor)
    {
        try{

            return Transacciones::where( $id_transaccion_motor )->update($estatus);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@updateEnvioCorreo] Error ' . $e->getMessage());
        }       

    }
    public function ConsultaCorreo($estatus)
    {
        try{

            return Transacciones::where($estatus)->take(100);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@ConsultaCorreo] Error ' . $e->getMessage());
        }       

    }
    public function updateTransStatus($estatus)
    {
        try{

            return Transacciones::where( $referencia )->update($estatus);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@updateTransacciones] Error ' . $e->getMessage());
        }       

    }
    public function updateStatusReferenceStatus60($info)
    {
        try
        {
            $data = Transacciones::whereIn('referencia', $info)->where('estatus','=','60')->update( ['estatus' => '0']);

        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@updateStatusReferenceStatus60]  ERROR al actualizar las transacciones como procesadas");
            return false;
        }
    }
    public function updateStatusReferenceStatus65($info)
    {
        try
        {
            $data = Transacciones::whereIn('referencia', $info)->where('estatus','=','65')->update( ['estatus' => '0']);

        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@updateStatusReferenceStatus65]  ERROR al actualizar las transacciones como procesadas");
            return false;
        }
    }
     public function findTransaccionesNoConciliadas($fechaIn,$fechaF)
    {
        
           $data = Transacciones::whereBetween('fecha_pago',[$fechaIn,$fechaF])
        ->select('oper_transacciones.id_transaccion_motor as folio','oper_transacciones.referencia','oper_transacciones.banco','oper_transacciones.importe_transaccion as monto','egobierno.status.Descripcion as status')
        ->leftjoin('egobierno.status','egobierno.status.Status','=','oper_transacciones.estatus')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
        ->where('oper_transacciones.estatus','=','0')  
        ->Where('oper_processedregisters.referencia','=',null)
        ->groupBy('oper_transacciones.id_transaccion_motor')
        ->get();
          return $data;
       
    }

    
    
}
