<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EntidadtramiteRepository;
use App\Entities\Entidadtramite;
use App\Validators\EntidadtramiteValidator;

/**
 * Class EntidadtramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EntidadtramiteRepositoryEloquent extends BaseRepository implements EntidadtramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Entidadtramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
