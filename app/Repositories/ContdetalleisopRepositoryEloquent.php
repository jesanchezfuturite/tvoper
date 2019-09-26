<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetalleisopRepository;
use App\Entities\Contdetalleisop;
use App\Validators\ContdetalleisopValidator;

/**
 * Class ContdetalleisopRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetalleisopRepositoryEloquent extends BaseRepository implements ContdetalleisopRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetalleisop::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
