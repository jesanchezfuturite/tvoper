<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TramitesDivisasRepository;
use App\Entities\TramitesDivisas;
use App\Validators\TramitesDivisasValidator;

/**
 * Class TramitesDivisasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TramitesDivisasRepositoryEloquent extends BaseRepository implements TramitesDivisasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TramitesDivisas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
