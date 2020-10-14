<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperacionRoleRepository;
use App\Entities\OperacionRole;
use App\Validators\OperacionRoleValidator;

/**
 * Class OperacionRoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperacionRoleRepositoryEloquent extends BaseRepository implements OperacionRoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperacionRole::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
