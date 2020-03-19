<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Servgenerartransaccion.
 *
 * @package namespace App\Entities;
 */
class Servgenerartransaccion extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','partida','folio','created_at','updated_at'];

    protected $table = "serv_generar_transaccion";

}
