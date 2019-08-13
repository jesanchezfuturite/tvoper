<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernoctavtlregRepository;
use App\Entities\Egobiernoctavtlreg;
use App\Validators\EgobiernoctavtlregValidator;

/**
 * Class EgobiernoctavtlregRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernoctavtlregRepositoryEloquent extends BaseRepository implements EgobiernoctavtlregRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernoctavtlreg::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
