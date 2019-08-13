<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernocontrolRepository;
use App\Entities\Egobiernocontrol;
use App\Validators\EgobiernocontrolValidator;

/**
 * Class EgobiernocontrolRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernocontrolRepositoryEloquent extends BaseRepository implements EgobiernocontrolRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernocontrol::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
