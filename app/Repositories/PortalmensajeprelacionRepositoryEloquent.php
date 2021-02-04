<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalmensajeprelacionRepository;
use App\Entities\Portalmensajeprelacion;
use App\Validators\PortalmensajeprelacionValidator;

/**
 * Class PortalmensajeprelacionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalmensajeprelacionRepositoryEloquent extends BaseRepository implements PortalmensajeprelacionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalmensajeprelacion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
