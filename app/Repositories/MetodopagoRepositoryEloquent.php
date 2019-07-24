<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MetodopagoRepository;
use App\Entities\Metodopago;
use App\Validators\MetodopagoValidator;

/**
 * Class MetodopagoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MetodopagoRepositoryEloquent extends BaseRepository implements MetodopagoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Metodopago::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
