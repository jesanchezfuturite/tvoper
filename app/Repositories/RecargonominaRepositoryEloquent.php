<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RecargonominaRepository;
use App\Entities\Recargonomina;
use App\Validators\RecargonominaValidator;

/**
 * Class RecargonominaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RecargonominaRepositoryEloquent extends BaseRepository implements RecargonominaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Recargonomina::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
