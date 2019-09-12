<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IcvremotodetalleRepository;
use App\Entities\Icvremotodetalle;
use App\Validators\IcvremotodetalleValidator;

/**
 * Class IcvremotodetalleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IcvremotodetalleRepositoryEloquent extends BaseRepository implements IcvremotodetalleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Icvremotodetalle::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
