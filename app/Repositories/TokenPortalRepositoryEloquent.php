<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TokenPortalRepository;
use App\Entities\TokenPortal;
use App\Validators\TokenPortalValidator;

/**
 * Class TokenPortalRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TokenPortalRepositoryEloquent extends BaseRepository implements TokenPortalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TokenPortal::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
