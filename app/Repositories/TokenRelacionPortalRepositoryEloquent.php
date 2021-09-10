<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TokenRelacionPortalRepository;
use App\Entities\TokenRelacionPortal;

/**
 * Class TokenPortalRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TokenRelacionPortalRepositoryEloquent extends BaseRepository implements TokenRelacionPortalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TokenRelacionPortal::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
