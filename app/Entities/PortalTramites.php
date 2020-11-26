<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalTramites.
 *
 * @package namespace App\Entities;
 */
class PortalTramites extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $connection = "mysql6";

    protected $fillable = ['id','id_transaccion_motor', 'estatus', 'json_envio'];

    protected $table = "solicitudes_tramite";

}
