<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConciliacionconciliacionotrostipopagoRepository;
use App\Entities\Conciliacionconciliacionotrostipopago;
use App\Validators\ConciliacionconciliacionotrostipopagoValidator;

/**
 * Class ConciliacionconciliacionotrostipopagoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConciliacionconciliacionotrostipopagoRepositoryEloquent extends BaseRepository implements ConciliacionconciliacionotrostipopagoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conciliacionconciliacionotrostipopago::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
