<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernotipopagoRepository;
use App\Entities\Egobiernotipopago;
use App\Validators\EgobiernotipopagoValidator;

/**
 * Class EgobiernotipopagoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernotipopagoRepositoryEloquent extends BaseRepository implements EgobiernotipopagoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernotipopago::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
