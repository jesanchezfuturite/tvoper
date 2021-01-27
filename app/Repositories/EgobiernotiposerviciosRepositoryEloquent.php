<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernotiposerviciosRepository;
use App\Entities\Egobiernotiposervicios;
use App\Validators\EgobiernotiposerviciosValidator;

/**
 * Class EgobiernotiposerviciosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernotiposerviciosRepositoryEloquent extends BaseRepository implements EgobiernotiposerviciosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernotiposervicios::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function updateMenuByName($Tipo_Descripcion,$Tipo_Code)
    {
        try{

            return Egobiernotiposervicios::where( $Tipo_Code )->update($Tipo_Descripcion);    
        
         }catch( \Exception $e){
            Log::info('[EgobiernotiposerviciosRepositoryEloquent@updateMenuByName] Error ' . $e->getMessage());
        }   
    }
     public function ServiciosfindAll()
    {
        //try{        
        $data = Egobiernotiposervicios::join('operacion.oper_tiporeferencia','operacion.oper_tiporeferencia.id','=','tipo_servicios.tiporeferencia_id')
        ->leftjoin('operacion.oper_entidadtramite','operacion.oper_entidadtramite.tipo_servicios_id','=','tipo_servicios.Tipo_Code')
        ->leftjoin('operacion.oper_entidad','operacion.oper_entidad.id','=','operacion.oper_entidadtramite.entidad_id')
        ->leftjoin('operacion.oper_limitereferencia','operacion.oper_limitereferencia.id','=','tipo_servicios.limitereferencia_id')
        ->select('tipo_servicios.Tipo_Code as id','operacion.oper_entidad.nombre as Entidad','tipo_servicios.Tipo_Code','tipo_servicios.Tipo_Descripcion','tipo_servicios.Origen_URL','tipo_servicios.GpoTrans_Num','tipo_servicios.id_gpm','.descripcion_gpm','operacion.oper_limitereferencia.descripcion','operacion.oper_limitereferencia.periodicidad','operacion.oper_limitereferencia.vencimiento','operacion.oper_tiporeferencia.fecha_condensada','operacion.oper_entidadtramite.id as id_entidadtramite')
        //->groupBy('tipo_servicios.Tipo_Code')    
        ->get();

        return $data;
       
        /*}catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaTransaccionesWhere] Error ' . $e->getMessage());
        }*/  
    }

    
}
