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
        'info',
        'mensaje',        
        'status'
    ];

    

    protected $table = "solicitudes_ticket_bitacora";

    public function atencion(){
        return $this->hasOne('App\Entities\EstatusAtencion', 'id', 'id_estatus_atencion');
    }
    public function usuario(){
        return $this->hasOne('App\Entities\Users', 'id', 'user_id'); 
    }

    public function statusticket(){
        return $this->hasOne('App\Entities\StatusTicket', 'id', 'status'); 
    }

}
