<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PagosupdatelogRepository;
use App\Entities\Pagosupdatelog;
use App\Validators\PagosupdatelogValidator;

/**
 * Class PagosupdatelogRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PagosupdatelogRepositoryEloquent extends BaseRepository implements PagosupdatelogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pagosupdatelog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function findbyDates($fechaIn,$fechaF)
    {
        
        $data = Pagosupdatelog::whereBetween('fecha_pago',[$fechaIn,$fechaF])
        ->select('fecha_pago','referencia','id_transaccion','banco_desc','plataforma','monto')
        ->get();
        
        return $data;
       
    }
    
}
