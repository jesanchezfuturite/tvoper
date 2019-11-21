<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CortesolicitudRepository;
use App\Entities\Cortesolicitud;
use App\Validators\CortesolicitudValidator;

/**
 * Class CortesolicitudRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CortesolicitudRepositoryEloquent extends BaseRepository implements CortesolicitudRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cortesolicitud::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
