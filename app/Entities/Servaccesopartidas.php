<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Servaccesopartidas.
 *
 * @package namespace App\Entities;
 */
class Servaccesopartidas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','usuario','partida','created_at','updated_at'];

    protected $table = "serv_acceso_partidas";

}
