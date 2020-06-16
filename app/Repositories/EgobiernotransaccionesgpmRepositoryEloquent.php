<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernotransaccionesgpmRepository;
use App\Entities\Egobiernotransaccionesgpm;
use App\Validators\EgobiernotransaccionesgpmValidator;

/**
 * Class EgobiernotransaccionesgpmRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernotransaccionesgpmRepositoryEloquent extends BaseRepository implements EgobiernotransaccionesgpmRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernotransaccionesgpm::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
