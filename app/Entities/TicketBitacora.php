<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketBitacora.
 *
 * @package namespace App\Entities;
 */
class TicketBitacora extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = [
        'id',
        'id_ticket' ,
        'grupo_clave',
        'id_estatus_atencion',
        'user_id',
        'mensaje',
        'status'
    ];

    

    protected $table = "solicitudes_ticket_bitacora";

}
