<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalNotaryOfficesRepository;
use App\Entities\PortalNotaryOffices;
use App\Validators\PortalNotaryOfficesValidator;

/**
 * Class PortalNotaryOfficesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalNotaryOfficesRepositoryEloquent extends BaseRepository implements PortalNotaryOfficesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalNotaryOffices::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
