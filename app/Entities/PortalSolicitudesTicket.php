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

    protected $fillable = ['id','clave','catalogo_id','relacionado_a','creado_por', 'asignado_a', 'status'];

    protected $table = "solicitudes_ticket";

 


}
