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
    
}
