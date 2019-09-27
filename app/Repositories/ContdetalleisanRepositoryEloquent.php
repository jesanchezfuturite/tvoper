<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetalleisanRepository;
use App\Entities\Contdetalleisan;
use App\Validators\ContdetalleisanValidator;

/**
 * Class ContdetalleisanRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetalleisanRepositoryEloquent extends BaseRepository implements ContdetalleisanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetalleisan::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
