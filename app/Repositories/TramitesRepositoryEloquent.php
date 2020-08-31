<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramitesRepository;
use App\Entities\Tramites;
use App\Validators\TramitesValidator;
use Illuminate\Support\Facades\Log;

/**
 * Class TramitesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramitesRepositoryEloquent extends BaseRepository implements TramitesRepository
{
    protected $db='egobierno';
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
        try{        
            log::info($rfc);
        $data = Tramites::where($rfc)
        ->leftjoin('oper_transacciones','oper_transacciones.id_transaccion_motor','=','oper_tramites.id_transaccion_motor')    
        ->leftjoin($this->db . '.status',$this->db . '.status.Status','=','oper_transacciones.estatus')
        ->leftjoin('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->leftjoin('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->leftjoin('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->leftjoin($this->db . '.tipo_servicios',$this->db . '.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')        
        ->leftjoin($this->db . '.tipopago',$this->db . '.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        //->where('oper_transacciones.fecha_transaccion','>=',$fechaIn)           
        //->where('oper_transacciones.fecha_transaccion','<=',$fechaFin)           
        ->select($this->db . '.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad',$this->db . '.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion',$this->db . '.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite',$this->db . '.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia','oper_tramites.id_transaccion_motor')
        ->groupBy('oper_tramites.id_tramite_motor')
        ->get();

        return $data;
       
       }catch( \Exception $e){
            Log::info('[TramitesRepositoryEloquent@ConsultaRFC] Error ' . $e->getMessage());
        } 
    }
   
    
    
}
