<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\umahistoryRepository;
use App\Entities\Umahistory;
use App\Validators\UmahistoryValidator;

/**
 * Class UmahistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UmahistoryRepositoryEloquent extends BaseRepository implements UmahistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Umahistory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
