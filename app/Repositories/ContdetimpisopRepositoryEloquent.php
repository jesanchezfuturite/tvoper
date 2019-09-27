<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetimpisopRepository;
use App\Entities\Contdetimpisop;
use App\Validators\ContdetimpisopValidator;

/**
 * Class ContdetimpisopRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetimpisopRepositoryEloquent extends BaseRepository implements ContdetimpisopRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetimpisop::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
