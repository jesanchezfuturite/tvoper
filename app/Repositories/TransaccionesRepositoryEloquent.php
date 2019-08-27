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
    
    
}
