<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalSolicitudesTicketRepository;
use App\Entities\PortalSolicitudesTicket;
use App\Validators\PortalSolicitudesTicketValidator;

/**
 * Class PortalSolicitudesTicketRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalSolicitudesTicketRepositoryEloquent extends BaseRepository implements PortalSolicitudesTicketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalSolicitudesTicket::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function findPrelacion($id)
    {
             
        $data = PortalSolicitudesTicket::where('solicitudes_ticket.id',$id)
        ->leftjoin('solicitudes_catalogo','solicitudes_catalogo.id','=','solicitudes_ticket.catalogo_id')
        ->leftjoin('tramites_prelacion','tramites_prelacion.tramite_id','=','solicitudes_catalogo.tramite_id')
        ->leftjoin('mensaje_prelacion','mensaje_prelacion.solicitud_id','=','solicitudes_ticket.id')
        ->leftjoin('egobierno.tipo_servicios','egobierno.tipo_servicios.Tipo_Code','=','solicitudes_catalogo.tramite_id')
        ->select('solicitudes_ticket.id','tramites_prelacion.tramite_id as tramite_prelacion','mensaje_prelacion.solicitud_id as mensaje_prelacion','solicitudes_catalogo.tramite_id','egobierno.tipo_servicios.Tipo_Descripcion as tramite')
        ->get();

        return $data;
       
    }
    
}
