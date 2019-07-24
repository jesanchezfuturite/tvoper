<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pagotramite.
 *
 * @package namespace App\Entities;
 */
class Pagotramite extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['metodo_id','tramite_id','status_id','catalogotramite_id','descripcion','monto_minimo','monto_maximo','fecha_inicio','fecha_fin'];

    protected $table = "oper_pagotramite";

}
