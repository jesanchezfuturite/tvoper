<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramitePorRegistradorRepository;
use App\Entities\TramitePorRegistrador;
use App\Validators\TramitePorRegistradorValidator;

/**
 * Class TramitePorRegistradorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramitePorRegistradorRepositoryEloquent extends BaseRepository implements TramitePorRegistradorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TramitePorRegistrador::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
