<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DistritosRepository;
use App\Entities\Distritos;
use App\Validators\DistritosValidator;

/**
 * Class DistritosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DistritosRepositoryEloquent extends BaseRepository implements DistritosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Distritos::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
