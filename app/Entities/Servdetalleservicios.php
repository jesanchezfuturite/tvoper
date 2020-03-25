<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Servdetalleservicios.
 *
 * @package namespace App\Entities;
 */
class Servdetalleservicios extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = ['id','idTrans','Folio','rfc','curp','calle','no_ext','no_int','colonia','minicipio_delegacion','cp','monto','partida','estado_pais','consepto','nombre_razonS','desc_partida','created_at','updated_at'];

    protected $table = "serv_detalle_servicios";

}
