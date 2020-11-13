<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalreglaoperativacamposRepository;
use App\Entities\Portalreglaoperativacampos;
use App\Validators\PortalreglaoperativacamposValidator;

/**
 * Class PortalreglaoperativacamposRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalreglaoperativacamposRepositoryEloquent extends BaseRepository implements PortalreglaoperativacamposRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalreglaoperativacampos::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
