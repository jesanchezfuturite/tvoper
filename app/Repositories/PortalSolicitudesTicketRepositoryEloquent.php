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
    public function findTicket($campo,$var)
    {
        $data = PortalSolicitudesTicket::whereIn('solicitudes_ticket.'.$campo,$var)
        ->leftjoin('solicitudes_status','solicitudes_status.id','=','solicitudes_ticket.status')        
        ->leftjoin('solicitudes_mensajes','solicitudes_mensajes.ticket_id','=','solicitudes_ticket.id')   
        ->where('solicitudes_ticket.status','=','2')    
        ->where('solicitudes_ticket.doc_firmado','<>',null)    
        ->select('solicitudes_ticket.id',
            'solicitudes_ticket.clave',
            'solicitudes_ticket.id_tramite',
            'solicitudes_ticket.recibo_referencia',
            'solicitudes_ticket.catalogo_id',
            'solicitudes_ticket.id_transaccion',
            'solicitudes_ticket.info',
            'solicitudes_ticket.relacionado_a',
            'solicitudes_ticket.ticket_relacionado',
            'solicitudes_ticket.user_id',
            'solicitudes_ticket.creado_por',
            'solicitudes_ticket.asignado_a',
            'solicitudes_ticket.en_carrito',
            'solicitudes_ticket.firmado',
            'solicitudes_ticket.por_firmar',
            'solicitudes_ticket.doc_firmado',
            'solicitudes_ticket.required_docs',
            'solicitudes_ticket.status',
            'solicitudes_ticket.created_at',
            'solicitudes_ticket.updated_at',
            'solicitudes_status.descripcion',
            'solicitudes_mensajes.id as id_mensaje',
            'solicitudes_mensajes.mensaje',
            'solicitudes_mensajes.attach'
        )->get();
        return $data;
    }
}
