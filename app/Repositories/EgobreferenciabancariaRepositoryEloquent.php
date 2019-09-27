<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobreferenciabancariaRepository;
use App\Entities\Egobreferenciabancaria;
use App\Validators\EgobreferenciabancariaValidator;

/**
 * Class EgobreferenciabancariaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobreferenciabancariaRepositoryEloquent extends BaseRepository implements EgobreferenciabancariaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobreferenciabancaria::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
