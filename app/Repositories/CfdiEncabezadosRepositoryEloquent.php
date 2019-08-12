<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CfdiEncabezadosRepository;
use App\Entities\CfdiEncabezados;
use App\Validators\CfdiEncabezadosValidator;

/**
 * Class CfdiEncabezadosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CfdiEncabezadosRepositoryEloquent extends BaseRepository implements CfdiEncabezadosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CfdiEncabezados::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * Update by idcfdi_encabezado,
     */
    public function updateByIdCFDI($idcfdi,$metodo)
    {
        try {
            
            return CfdiEncabezados::where( $idcfdi )->update($metodo);

        } catch (Exception $e) {
            
            Log::info('[CfdiEncabezadosRepositoryEloquent@updateByIdCFDI] Error ' . $e->getMessage());
        }
    }

    
}
