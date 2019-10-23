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
            ->join('status','status.Status','=','transacciones.Status')
            ->join('operacion.oper_entidadtramite','operacion.oper_entidadtramite.tipo_servicios_id','=','transacciones.TipoServicio')
            ->join('operacion.oper_entidad','operacion.oper_entidad.id','=','operacion.oper_entidadtramite.entidad_id')
            ->join('tipo_servicios','tipo_servicios.Tipo_Code', '=','transacciones.TipoServicio')
            ->join('tipopago','tipopago.TipoPago', '=','transacciones.TipoPago')
            ->select('status.Descripcion as status','transacciones.idTrans','operacion.oper_entidad.nombre as entidad','tipo_servicios.Tipo_Descripcion as tiposervicio','transacciones.TitularTC','transacciones.fechatramite','transacciones.HoraTramite','transacciones.BancoSeleccion','tipopago.Descripcion as tipopago','transacciones.TotalTramite')
            ->groupBy('transacciones.idTrans')
            ->get();
            return $data;
            //Log::info($data);
        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent @ consultaTransacciones]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }
    
}
