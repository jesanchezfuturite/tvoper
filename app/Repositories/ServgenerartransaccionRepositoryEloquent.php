<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ServgenerartransaccionRepository;
use App\Entities\Servgenerartransaccion;
use App\Validators\ServgenerartransaccionValidator;

/**
 * Class ServgenerartransaccionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ServgenerartransaccionRepositoryEloquent extends BaseRepository implements ServgenerartransaccionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servgenerartransaccion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
