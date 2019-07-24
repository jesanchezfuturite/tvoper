<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EntidadRepository;
use App\Entities\Entidad;
use App\Validators\EntidadValidator;

/**
 * Class EntidadRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EntidadRepositoryEloquent extends BaseRepository implements EntidadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Entidad::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
