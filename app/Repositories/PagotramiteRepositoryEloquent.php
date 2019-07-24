<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PagotramiteRepository;
use App\Entities\Pagotramite;
use App\Validators\PagotramiteValidator;

/**
 * Class PagotramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PagotramiteRepositoryEloquent extends BaseRepository implements PagotramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pagotramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
