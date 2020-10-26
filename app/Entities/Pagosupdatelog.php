<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pagosupdatelog.
 *
 * @package namespace App\Entities;
 */
class Pagosupdatelog extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "oper_pagosupdate_log";

    protected $fillable = ['fecha_pago','referencia','id_transaccion','banco_desc','plataforma','monto','data','extra'];

}
