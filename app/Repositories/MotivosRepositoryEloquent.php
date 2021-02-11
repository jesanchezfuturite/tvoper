<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MotivosRepository;
use App\Entities\Motivos;
use App\Validators\MotivosValidator;

/**
 * Class MotivosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MotivosRepositoryEloquent extends BaseRepository implements MotivosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Motivos::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
