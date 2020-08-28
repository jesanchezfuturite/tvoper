<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramitesBDRepository;
use App\Entities\TramitesBD;
use App\Validators\TramitesBDValidator;

/**
 * Class TramitesBDRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramitesBDRepositoryEloquent extends BaseRepository implements TramitesBDRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TramitesBD::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
