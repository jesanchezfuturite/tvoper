<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConciliacionconciliacionRepository;
use App\Entities\Conciliacionconciliacion;
use App\Validators\ConciliacionconciliacionValidator;

/**
 * Class ConciliacionconciliacionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConciliacionconciliacionRepositoryEloquent extends BaseRepository implements ConciliacionconciliacionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conciliacionconciliacion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
