<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperacionUsuariosEstatusRepository;
use App\Entities\OperacionUsuariosEstatus;
use App\Validators\OperacionUsuariosEstatusValidator;

/**
 * Class OperacionUsuariosEstatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperacionUsuariosEstatusRepositoryEloquent extends BaseRepository implements OperacionUsuariosEstatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperacionUsuariosEstatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
