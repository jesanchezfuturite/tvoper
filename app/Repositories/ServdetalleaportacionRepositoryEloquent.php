<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ServdetalleaportacionRepository;
use App\Entities\Servdetalleaportacion;
use App\Validators\ServdetalleaportacionValidator;

/**
 * Class ServdetalleaportacionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServdetalleaportacionRepositoryEloquent extends BaseRepository implements ServdetalleaportacionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servdetalleaportacion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
