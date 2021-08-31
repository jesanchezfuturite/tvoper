<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalDocumentosBitacoraRepository;
use App\Entities\PortalDocumentosBitacora;
use App\Validators\PortalDocumentosBitacoraValidator;

/**
 * Class PortalDocumentosBitacoraRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalDocumentosBitacoraRepositoryEloquent extends BaseRepository implements PortalDocumentosBitacoraRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalDocumentosBitacora::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
