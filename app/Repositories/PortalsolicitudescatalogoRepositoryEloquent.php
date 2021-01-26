<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsolicitudescatalogoRepository;
use App\Entities\Portalsolicitudescatalogo;
use App\Validators\PortalsolicitudescatalogoValidator;

/**
 * Class PortalsolicitudescatalogoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsolicitudescatalogoRepositoryEloquent extends BaseRepository implements PortalsolicitudescatalogoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsolicitudescatalogo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function findSolicitudes($user,$padre_id)
    {
        try{        
        $data = Portalsolicitudescatalogo::where("atendido_por",$user)
        ->select("solicitudes_catalogo.id","solicitudes_catalogo.atendido_por", "solicitudes_catalogo.titulo", "solicitudes_catalogo.padre_id","solicitudes_ticket.status")
        ->Join('solicitudes_ticket',  'solicitudes_catalogo.id', '=','solicitudes_ticket.catalogo_id')
        ->where("solicitudes_catalogo.padre_id",$padre_id)
       // ->where("solicitudes_ticket.status","2")
        ->groupBy('solicitudes_catalogo.id')
        ->get()->toArray();

        return $data;
       
       }catch( \Exception $e){
            Log::info('[PortalsolicitudescatalogoRepositoryEloquent@findSolicitudes] Error ' . $e->getMessage());
        } 
    }
    
}
