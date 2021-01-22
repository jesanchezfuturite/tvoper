<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperanomaliasRepository;
use App\Entities\Operanomalias;
use App\Validators\OperanomaliasValidator;

/**
 * Class OperanomaliasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperanomaliasRepositoryEloquent extends BaseRepository implements OperanomaliasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operanomalias::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
