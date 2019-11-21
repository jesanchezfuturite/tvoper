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
    
}
