<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LimitereferenciaRepository;
use App\Entities\Limitereferencia;
use App\Validators\LimitereferenciaValidator;

/**
 * Class LimitereferenciaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LimitereferenciaRepositoryEloquent extends BaseRepository implements LimitereferenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Limitereferencia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
