<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperrolesRepository;
use App\Entities\Operroles;
use App\Validators\OperrolesValidator;

/**
 * Class OperrolesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperrolesRepositoryEloquent extends BaseRepository implements OperrolesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operroles::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
