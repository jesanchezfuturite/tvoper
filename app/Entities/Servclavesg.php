<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Servclavesg.
 *
 * @package namespace App\Entities;
 */
class Servclavesg extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','usuario','Password','dependencia','nombre','apellido_paterno','apellido_materno','estatus','user_id','created_at','updated_at'];

    protected $table = "serv_clave_sg";
}
