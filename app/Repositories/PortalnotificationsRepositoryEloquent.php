<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalnotificationsRepository;
use App\Entities\Portalnotifications;
use App\Validators\PortalnotificationsValidator;

/**
 * Class PortalnotificationsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalnotificationsRepositoryEloquent extends BaseRepository implements PortalnotificationsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalnotifications::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
