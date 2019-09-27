<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernocontvehRepository;
use App\Entities\Egobiernocontveh;
use App\Validators\EgobiernocontvehValidator;

/**
 * Class EgobiernocontvehRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernocontvehRepositoryEloquent extends BaseRepository implements EgobiernocontvehRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernocontveh::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
