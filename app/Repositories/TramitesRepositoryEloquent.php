<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramitesRepository;
use App\Entities\Tramites;
use App\Validators\TramitesValidator;

/**
 * Class TramitesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramitesRepositoryEloquent extends BaseRepository implements TramitesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tramites::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function consultaRFCoper($rfc,$fechaIn,$fechaFin)
    {
        //try{        
        $data = Tramites::where($rfc)
        ->join('oper_transacciones','oper_transacciones.id_transaccion_motor','=','oper_tramites.id_transaccion_motor')    
        ->join('egob.status','egob.status.Status','=','oper_transacciones.estatus')
        ->join('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->join('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->join('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->join('egob.tipo_servicios','egob.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')        
        ->join('egob.tipopago','egob.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        ->where('oper_transacciones.fecha_transaccion','>=',$fechaIn)           
        ->where('oper_transacciones.fecha_transaccion','<=',$fechaFin)           
        ->select('egob.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad','egob.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion','egob.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite','egob.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia')
        ->groupBy('oper_transacciones.id_transaccion')
        ->get();

        return $data;
       
       /*}catch( \Exception $e){
            Log::info('[TramitesRepositoryEloquent@ConsultaRFC] Error ' . $e->getMessage());
        } */
    }
   
    
    
}
