<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalreglaoperativaRepository;
use App\Entities\Portalreglaoperativa;
use App\Validators\PortalreglaoperativaValidator;

/**
 * Class PortalreglaoperativaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalreglaoperativaRepositoryEloquent extends BaseRepository implements PortalreglaoperativaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalreglaoperativa::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
