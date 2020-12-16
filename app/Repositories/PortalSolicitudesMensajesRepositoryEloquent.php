<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalSolicitudesMensajesRepository;
use App\Entities\PortalSolicitudesMensajes;
use App\Validators\PortalSolicitudesMensajesValidator;

/**
 * Class PortalSolicitudesMensajesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalSolicitudesMensajesRepositoryEloquent extends BaseRepository implements PortalSolicitudesMensajesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalSolicitudesMensajes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
