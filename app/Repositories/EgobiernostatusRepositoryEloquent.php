<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernostatusRepository;
use App\Entities\Egobiernostatus;
use App\Validators\EgobiernostatusValidator;

/**
 * Class EgobiernostatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernostatusRepositoryEloquent extends BaseRepository implements EgobiernostatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernostatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
