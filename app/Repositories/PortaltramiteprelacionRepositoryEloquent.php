<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortaltramiteprelacionRepository;
use App\Entities\Portaltramiteprelacion;
use App\Validators\PortaltramiteprelacionValidator;

/**
 * Class PortaltramiteprelacionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortaltramiteprelacionRepositoryEloquent extends BaseRepository implements PortaltramiteprelacionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portaltramiteprelacion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
