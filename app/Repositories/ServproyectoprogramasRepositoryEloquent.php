<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ServproyectoprogramasRepository;
use App\Entities\Servproyectoprogramas;
use App\Validators\ServproyectoprogramasValidator;

/**
 * Class ServproyectoprogramasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServproyectoprogramasRepositoryEloquent extends BaseRepository implements ServproyectoprogramasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servproyectoprogramas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
