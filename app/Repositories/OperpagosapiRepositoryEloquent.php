<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperpagosapiRepository;
use App\Entities\Operpagosapi;
use App\Validators\OperpagosapiValidator;

/**
 * Class OperpagosapiRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperpagosapiRepositoryEloquent extends BaseRepository implements OperpagosapiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operpagosapi::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
