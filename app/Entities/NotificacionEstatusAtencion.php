<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @package namespace App\Entities;
 */
class NotificacionEstatusAtencion extends Model 
{
    protected $connection = "mysql6";
    protected $table ="portal.notificacion_estatus_atencion";
    /**
     * @var array
     */
    protected $fillable = ['user', 'id_estatus_atencion', 'message', 'sent', 'logs', 'tries'];



}
