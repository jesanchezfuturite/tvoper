<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CfdiDetalleRepository;
use App\Entities\CfdiDetalle;
use App\Validators\CfdiDetalleValidator;

/**
 * Class CfdiDetalleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CfdiDetalleRepositoryEloquent extends BaseRepository implements CfdiDetalleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CfdiDetalle::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    
    /**
     * Update by idcfdi_detalle,
     */
    public function updateByIdCFDI($idcfdi,$metodo)
    {
        try {
            
            return CfdiDetalle::where( $idcfdi )->update($metodo);

        } catch (Exception $e) {
            
            Log::info('[CfdiDetalleRepositoryEloquent@updateByIdCFDI] Error ' . $e->getMessage());
        }
    }
}
