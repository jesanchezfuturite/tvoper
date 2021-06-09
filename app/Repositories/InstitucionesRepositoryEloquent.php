<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InstitucionesRepository;
use App\Entities\Instituciones;
use App\Validators\InstitucionesValidator;

/**
 * Class InstitucionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InstitucionesRepositoryEloquent extends BaseRepository implements InstitucionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Instituciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
