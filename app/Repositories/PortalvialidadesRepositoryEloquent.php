<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalvialidadesRepository;
use App\Entities\Portalvialidades;
use App\Validators\PortalvialidadesValidator;

/**
 * Class PortalvialidadesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalvialidadesRepositoryEloquent extends BaseRepository implements PortalvialidadesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalvialidades::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
