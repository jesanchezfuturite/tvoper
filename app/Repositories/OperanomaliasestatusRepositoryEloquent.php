<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperanomaliasestatusRepository;
use App\Entities\Operanomaliasestatus;
use App\Validators\OperanomaliasestatusValidator;

/**
 * Class OperanomaliasestatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperanomaliasestatusRepositoryEloquent extends BaseRepository implements OperanomaliasestatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operanomaliasestatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
