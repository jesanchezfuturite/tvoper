<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobfoliosRepository;
use App\Entities\Egobfolios;
use App\Validators\EgobfoliosValidator;

/**
 * Class EgobfoliosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobfoliosRepositoryEloquent extends BaseRepository implements EgobfoliosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobfolios::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
