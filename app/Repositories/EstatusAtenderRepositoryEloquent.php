<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EstatusAtencionRepository;
use App\Entities\EstatusAtencion;
use App\Validators\EstatusAtencionValidator;

/**
 * Class EstatusAtencionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EstatusAtencionRepositoryEloquent extends BaseRepository implements EstatusAtencionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EstatusAtencion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
