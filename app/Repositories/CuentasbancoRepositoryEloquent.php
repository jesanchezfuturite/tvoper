<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CuentasbancoRepository;
use App\Entities\Cuentasbanco;
use App\Validators\CuentasbancoValidator;

/**
 * Class CuentasbancoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CuentasbancoRepositoryEloquent extends BaseRepository implements CuentasbancoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cuentasbanco::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
