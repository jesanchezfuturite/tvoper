<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramiteRepository;
use App\Entities\Tramite;
use App\Validators\TramiteValidator;

/**
 * Class TramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramiteRepositoryEloquent extends BaseRepository implements TramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
