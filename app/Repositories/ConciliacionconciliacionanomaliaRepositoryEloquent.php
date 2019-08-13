<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConciliacionconciliacionanomaliaRepository;
use App\Entities\Conciliacionconciliacionanomalia;
use App\Validators\ConciliacionconciliacionanomaliaValidator;

/**
 * Class ConciliacionconciliacionanomaliaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConciliacionconciliacionanomaliaRepositoryEloquent extends BaseRepository implements ConciliacionconciliacionanomaliaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conciliacionconciliacionanomalia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
