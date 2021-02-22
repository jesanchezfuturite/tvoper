<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SolicitudesMotivoRepository;
use App\Entities\SolicitudesMotivo;
use App\Validators\SolicitudesMotivoValidator;

/**
 * Class SolicitudesMotivoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SolicitudesMotivoRepositoryEloquent extends BaseRepository implements SolicitudesMotivoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SolicitudesMotivo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
