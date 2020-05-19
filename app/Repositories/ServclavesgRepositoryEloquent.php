<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ServclavesgRepository;
use App\Entities\Servclavesg;
use App\Validators\ServclavesgValidator;

/**
 * Class ServclavesgRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServclavesgRepositoryEloquent extends BaseRepository implements ServclavesgRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servclavesg::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function consultaRegistros()
    {
        try{        
        $data = Servclavesg::where(['estatus'=>'1'])
        ->join('users','users.email','=','serv_clave_sg.usuario')           
        ->select('serv_clave_sg.id','users.email','serv_clave_sg.usuario','serv_clave_sg.dependencia','serv_clave_sg.nombre','serv_clave_sg.apellido_paterno','serv_clave_sg.apellido_materno','serv_clave_sg.user_id')
        ->groupBy('serv_clave_sg.usuario')
        ->get();

        return $data;
       
       }catch( \Exception $e){
            Log::info('[TramitesRepositoryEloquent@ConsultaRFC] Error ' . $e->getMessage());
        } 
    }
    
}
