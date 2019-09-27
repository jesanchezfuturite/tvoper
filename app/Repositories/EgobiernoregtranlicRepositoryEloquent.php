<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernoregtranlicRepository;
use App\Entities\Egobiernoregtranlic;
use App\Validators\EgobiernoregtranlicValidator;

/**
 * Class EgobiernoregtranlicRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernoregtranlicRepositoryEloquent extends BaseRepository implements EgobiernoregtranlicRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernoregtranlic::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
