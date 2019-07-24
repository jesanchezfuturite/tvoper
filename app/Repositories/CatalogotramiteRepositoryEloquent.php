<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CatalogotramiteRepository;
use App\Entities\Catalogotramite;
use App\Validators\CatalogotramiteValidator;

/**
 * Class CatalogotramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CatalogotramiteRepositoryEloquent extends BaseRepository implements CatalogotramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Catalogotramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
