<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CfdiDatosfiscalesRepository;
use App\Entities\CfdiDatosfiscales;
use App\Validators\CfdiDatosfiscalesValidator;

/**
 * Class CfdiDatosfiscalesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CfdiDatosfiscalesRepositoryEloquent extends BaseRepository implements CfdiDatosfiscalesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CfdiDatosfiscales::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
