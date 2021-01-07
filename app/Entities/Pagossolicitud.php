<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pagossolicitud.
 *
 * @package namespace App\Entities;
 */
class Pagossolicitud extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id_transaccion_motor','created_at','updated_at'];

    protected $table = "oper_pagos_solicitud";

}
