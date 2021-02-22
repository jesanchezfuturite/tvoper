<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcamposagrupacionesRepository;
use App\Entities\Portalcamposagrupaciones;
use App\Validators\PortalcamposagrupacionesValidator;

/**
 * Class PortalcamposagrupacionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcamposagrupacionesRepositoryEloquent extends BaseRepository implements PortalcamposagrupacionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcamposagrupaciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function findTramites($id_tramite)
    {
             
        $data = Portalcamposagrupaciones::where('id_tramite',$id_tramite)
        ->leftjoin('tramites_prelacion','tramites_prelacion.tramite_id','=','campos_agrupaciones.id_tramite')
        ->leftjoin('tramites_divisas','tramites_divisas.tramite_id','=','campos_agrupaciones.id_tramite')
        ->select('campos_agrupaciones.id',
            'campos_agrupaciones.descripcion',
            'campos_agrupaciones.id_tramite',
            'campos_agrupaciones.id_categoria',
            'campos_agrupaciones.orden',
            'tramites_prelacion.id as check',
            'tramites_divisas.id as divisa')
        ->orderBy('campos_agrupaciones.orden','ASC')
        ->get();

        return $data;
       
    }
    
}
