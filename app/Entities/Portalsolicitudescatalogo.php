<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalsolicitudescatalogo.
 *
 * @package namespace App\Entities;
 */
class Portalsolicitudescatalogo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = ['tramite_id','padre_id','titulo','atendido_por','status'];

    protected $table = "solicitudes_catalogo";

    
	public function ticket(){
		return $this->hasMany('App\Entities\PortalSolicitudesTicket', 'catalogo_id', 'id');
	}
 

}
