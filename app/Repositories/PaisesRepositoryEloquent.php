<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PaisesRepository;
use App\Entities\Paises;
use App\Validators\PaisesValidator;

/**
 * Class PaisesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaisesRepositoryEloquent extends BaseRepository implements PaisesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Paises::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
