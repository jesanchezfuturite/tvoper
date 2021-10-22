<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BitacorawsbRepository;
use App\Entities\Bitacorawsb;
use App\Validators\BitacorawsbValidator;

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
        ->select('id','fecha','operacion','referencia','ip','banco','importe','respuesta')
        ->get();
        
        return $data;
       
    }
    
}
