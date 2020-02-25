<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RespuestatransaccionRepository;
use App\Entities\Respuestatransaccion;
use App\Validators\RespuestatransaccionValidator;

/**
 * Class RespuestatransaccionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RespuestatransaccionRepositoryEloquent extends BaseRepository implements RespuestatransaccionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Respuestatransaccion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
