<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalCatalogoescuelasRepository;
use App\Entities\PortalCatalogoescuelas;
use App\Validators\PortalCatalogoescuelasValidator;

/**
 * Class PortalCatalogoescuelasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalCatalogoescuelasRepositoryEloquent extends BaseRepository implements PortalCatalogoescuelasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalCatalogoescuelas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
