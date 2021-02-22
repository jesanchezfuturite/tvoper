<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsolicitudesresponsablesRepository;
use App\Entities\Portalsolicitudesresponsables;
use App\Validators\PortalsolicitudesresponsablesValidator;

/**
 * Class PortalsolicitudesresponsablesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsolicitudesresponsablesRepositoryEloquent extends BaseRepository implements PortalsolicitudesresponsablesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsolicitudesresponsables::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
