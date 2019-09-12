<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DetalletramiteRepository;
use App\Entities\Detalletramite;
use App\Validators\DetalletramiteValidator;

/**
 * Class DetalletramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DetalletramiteRepositoryEloquent extends BaseRepository implements DetalletramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Detalletramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
