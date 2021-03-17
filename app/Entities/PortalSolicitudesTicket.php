<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalSolicitudesTicket.
 *
 * @package namespace App\Entities;
 */
class PortalSolicitudesTicket extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = [
        'id','clave','catalogo_id', 'info','relacionado_a','ticket_relacionado',
        'id_transaccion', 'user_id','creado_por', 'asignado_a', 'status',
        'en_carrito','por_firmar', 'id_tramite', 'recibo_referencia'
        ];

    protected $table = "solicitudes_ticket";

 
    public function catalogo(){
	  	return $this->hasMany('App\Entities\Portalsolicitudescatalogo', 'id', 'catalogo_id');
    }
    public function mensajes(){
	  	return $this->hasMany('App\Entities\PortalSolicitudesMensajes', 'ticket_id', 'id');
    }
    public function tramites(){
        return $this->hasMany('App\Entities\PortalTramites', 'id', 'id_transaccion');
    }

}
