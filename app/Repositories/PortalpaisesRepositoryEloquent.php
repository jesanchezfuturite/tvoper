<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalpaisesRepository;
use App\Entities\Portalpaises;
use App\Validators\PortalpaisesValidator;

/**
 * Class PortalpaisesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalpaisesRepositoryEloquent extends BaseRepository implements PortalpaisesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalpaises::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
