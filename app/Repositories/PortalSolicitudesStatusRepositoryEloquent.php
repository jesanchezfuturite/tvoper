<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalSolicitudesStatusRepository;
use App\Entities\PortalSolicitudesStatus;
use App\Validators\PortalSolicitudesStatusValidator;

/**
 * Class PortalSolicitudesStatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalSolicitudesStatusRepositoryEloquent extends BaseRepository implements PortalSolicitudesStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalSolicitudesStatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
