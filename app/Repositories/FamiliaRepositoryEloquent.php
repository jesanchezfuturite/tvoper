<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FamiliaRepository;
use App\Entities\Familia;
use App\Validators\FamiliaValidator;

/**
 * Class FamiliaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FamiliaRepositoryEloquent extends BaseRepository implements FamiliaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Familia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
