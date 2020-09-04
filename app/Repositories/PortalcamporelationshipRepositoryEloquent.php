<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcamporelationshipRepository;
use App\Entities\Portalcamporelationship;
use App\Validators\PortalcamporelationshipValidator;

/**
 * Class PortalcamporelationshipRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcamporelationshipRepositoryEloquent extends BaseRepository implements PortalcamporelationshipRepository
{
    
    protected $db='egobierno';

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcamporelationship::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function searchRelation($idrel)
    {
        try{        

            $data = Portalcamporelationship::where(['tramite_id'=>$idrel])       
            ->leftjoin('campos_type','campos_type.id','=','campos_relationship.tipo_id')     
            ->leftjoin('campos_catalogue','campos_catalogue.id','=','campos_relationship.campo_id')     
            ->select('campos_type.id as tipo_id','campos_type.descripcion as tipo_nombre','campos_catalogue.id as campo_id','campos_catalogue.descripcion as tipo_nombre','campos_relationship.caracteristicas')
            ->get();

            return $data;
       
       }catch( \Exception $e){
            Log::info('[PortalcamporelationshipRepositoryEloquent@searchRelation] Error ' . $e->getMessage());
        } 
    }
    
}
