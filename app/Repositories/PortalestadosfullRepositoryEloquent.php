<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalestadosfullRepository;
use App\Entities\Portalestadosfull;
use App\Validators\PortalestadosfullValidator;

/**
 * Class PortalpaisesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalestadosfullRepositoryEloquent extends BaseRepository implements PortalestadosfullRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalestadosfull::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
