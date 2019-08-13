<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConciliacionanomaliaRepository;
use App\Entities\Conciliacionanomalia;
use App\Validators\ConciliacionanomaliaValidator;

/**
 * Class ConciliacionanomaliaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConciliacionanomaliaRepositoryEloquent extends BaseRepository implements ConciliacionanomaliaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conciliacionanomalia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
