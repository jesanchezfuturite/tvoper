<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProcessedregistersRepository;
use App\Entities\Processedregisters;
use App\Validators\ProcessedregistersValidator;

use Illuminate\Support\Facades\Log;

/**
 * Class ProcessedregistersRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProcessedregistersRepositoryEloquent extends BaseRepository implements ProcessedregistersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Processedregisters::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * This method updates the control table in status serialized field and updates the message
     * @param info => array with the info to modify, option => status to be configured
     *
     * @return false if get an error 
     */
    public function updateStatusTo($info, $option)
    {
        try
        {
            $data = Processedregisters::whereIn('transaccion_id', $info)->update( ['status' => $option]);

        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent @ updateStatusInArray]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }

    /**
     * This method updates the control table in status serialized field and updates the message
     * @param info => array with the info to modify, option => status to be configured
     *
     * @return false if get an error 
     */
    public function updateStatusPerReferenceTo($info, $option)
    {
        try
        {
            $data = Processedregisters::whereIn('referencia', $info)->update( ['status' => $option]);

        }catch( \Exception $e ){
            Log::info("[EgobiernotransaccionesRepositoryEloquent @ updateStatusInArray]  ERROR al actualizar las transacciones como procesadas en egobierno");
            return false;
        }
    }


    /**
     * This method is used in command Egobtransacciones
     *  AS FOLLOWS:
     *  update the info from transacciones where registers are processed
     *  
     * @param $data: info to update / idTrans CID
     *
     *
     * @return true / false
    */

    public function completeInfoFromEgob($data,$idTrans)
    {
        try
        {
            $data = Processedregisters::where('transaccion_id', $idTrans)->update( $data );
            return true;
        }catch( \Exception $e ){
            Log::info("[ProcessedRegistersRepositoryEloquent @ completeInfoFromEgob] ERROR - " . $e->getMessage());
            return false;
        }    
    }
        
}
