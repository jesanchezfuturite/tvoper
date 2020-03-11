<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ServaccesopartidasRepository;
use App\Entities\Servaccesopartidas;
use App\Validators\ServaccesopartidasValidator;

/**
 * Class ServaccesopartidasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServaccesopartidasRepositoryEloquent extends BaseRepository implements ServaccesopartidasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servaccesopartidas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
