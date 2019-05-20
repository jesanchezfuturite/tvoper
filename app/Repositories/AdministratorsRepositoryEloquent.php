<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdministratorsRepository;
use App\Entities\Administrators;
use App\Validators\AdministratorsValidator;

/**
 * Class AdministratorsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdministratorsRepositoryEloquent extends BaseRepository implements AdministratorsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Administrators::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
