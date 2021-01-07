<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UsuariodbentidadRepository;
use App\Entities\Usuariodbentidad;
use App\Validators\UsuariodbentidadValidator;

/**
 * Class UsuariodbentidadRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UsuariodbentidadRepositoryEloquent extends BaseRepository implements UsuariodbentidadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Usuariodbentidad::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
