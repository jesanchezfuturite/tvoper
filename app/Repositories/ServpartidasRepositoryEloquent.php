<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ServpartidasRepository;
use App\Entities\Servpartidas;
use App\Validators\ServpartidasValidator;

/**
 * Class ServpartidasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServpartidasRepositoryEloquent extends BaseRepository implements ServpartidasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servpartidas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
