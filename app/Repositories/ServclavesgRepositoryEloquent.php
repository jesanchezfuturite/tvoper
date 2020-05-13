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
    
}
