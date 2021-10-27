<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BitacorawsbRepository;
use App\Entities\Bitacorawsb;
use App\Validators\BitacorawsbValidator;
use Illuminate\Support\Facades\Log;
/**
 * Class BitacorawsbRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BitacorawsbRepositoryEloquent extends BaseRepository implements BitacorawsbRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bitacorawsb::class;
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
        $data = Bitacorawsb::whereBetween('fecha',[$fechaIn,$fechaF])
        ->select('id','fecha','referencia','ip','banco','importe','respuesta')
        ->selectRaw("(CASE operacion WHEN 'Consulta de transaccion - DBC' THEN 'Consulta de transaccion' WHEN 'Notificar Pago - DBC' THEN 'Notificar Pago' WHEN 'Reversa Pago - DBC' THEN 'Reversa Pago' ELSE operacion END) AS operacion")
        ->get();
        
        return $data;       
    }

    public function findbyReferencia($ref)
    {
        $data = Bitacorawsb::where('referencia',$ref)
         ->select('id','fecha','referencia','ip','banco','importe','respuesta')
        ->selectRaw("(CASE operacion WHEN 'Consulta de transaccion - DBC' THEN 'Consulta de transaccion' WHEN 'Notificar Pago - DBC' THEN 'Notificar Pago' WHEN 'Reversa Pago - DBC' THEN 'Reversa Pago' ELSE operacion END) AS operacion")
        ->get();

        return $data;
    }
    
}
