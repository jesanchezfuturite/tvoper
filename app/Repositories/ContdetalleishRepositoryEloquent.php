<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetalleishRepository;
use App\Entities\Contdetalleish;
use App\Validators\ContdetalleishValidator;

/**
 * Class ContdetalleishRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetalleishRepositoryEloquent extends BaseRepository implements ContdetalleishRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetalleish::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
