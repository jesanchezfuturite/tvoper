<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FamiliaentidadRepository;
use App\Entities\Familiaentidad;
use App\Validators\FamiliaentidadValidator;

/**
 * Class FamiliaentidadRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FamiliaentidadRepositoryEloquent extends BaseRepository implements FamiliaentidadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Familiaentidad::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function findFamilia($familia_id)
    {
        try{

        $data = Familiaentidad::where('familia_id',$familia_id)
        ->join('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->join('oper_entidad','oper_entidad.id','=','oper_familiaentidad.entidad_id')
        ->select('oper_familiaentidad.id','oper_familia.nombre as familia','oper_entidad.nombre as entidad','oper_familiaentidad.familia_id','oper_familiaentidad.entidad_id')        
        ->groupBy('oper_familiaentidad.id')
        ->get();
        return $data;
       
        }catch( \Exception $e){
            Log::info('[FamiliaentidadRepositoryEloquent@findFamilia] Error ' . $e->getMessage());
        }      
    }
    
}
