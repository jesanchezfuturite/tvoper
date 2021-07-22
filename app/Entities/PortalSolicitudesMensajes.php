<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalSolicitudesMensajes.
 *
 * @package namespace App\Entities;
 */
class PortalSolicitudesMensajes extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";


    protected $fillable = ['id','ticket_id','mensaje','attach','mensaje_para','status'];


    protected $table = "solicitudes_mensajes";

    public function ticket(){
		return $this->hasMany('App\Entities\PortalSolicitudesTicket', 'ticket_id', 'id');
	}
 

}
