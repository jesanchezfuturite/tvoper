<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DistritoRepository;
use App\Entities\Distrito;
use App\Validators\DistritoValidator;

/**
 * Class DistritoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DistritoRepositoryEloquent extends BaseRepository implements DistritoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Distrito::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
