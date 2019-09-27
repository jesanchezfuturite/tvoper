<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernonominaRepository;
use App\Entities\Egobiernonomina;
use App\Validators\EgobiernonominaValidator;

/**
 * Class EgobiernonominaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernonominaRepositoryEloquent extends BaseRepository implements EgobiernonominaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernonomina::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
