<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetalleretencionesRepository;
use App\Entities\Contdetalleretenciones;
use App\Validators\ContdetalleretencionesValidator;

/**
 * Class ContdetalleretencionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetalleretencionesRepositoryEloquent extends BaseRepository implements ContdetalleretencionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetalleretenciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
