<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IcvremotoreferenciaRepository;
use App\Entities\Icvremotoreferencia;
use App\Validators\IcvremotoreferenciaValidator;

/**
 * Class IcvremotoreferenciaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IcvremotoreferenciaRepositoryEloquent extends BaseRepository implements IcvremotoreferenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Icvremotoreferencia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
