<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MunicipiosRepository;
use App\Entities\Municipios;
use App\Validators\MunicipiosValidator;

/**
 * Class MunicipiosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MunicipiosRepositoryEloquent extends BaseRepository implements MunicipiosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Municipios::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
