<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RegistradoresRepository;
use App\Entities\Registradores;
use App\Validators\RegistradoresValidator;

/**
 * Class RegistradoresRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RegistradoresRepositoryEloquent extends BaseRepository implements RegistradoresRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Registradores::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
