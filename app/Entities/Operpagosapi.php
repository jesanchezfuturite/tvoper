<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Operpagosapi.
 *
 * @package namespace App\Entities;
 */
class Operpagosapi extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql";

    protected $fillable = ['transacciones_id','id_transaccion_motor','id_transaccion','estatus','entidad','referencia','Total','MetododePago','cve_Banco','FechaTransaccion','FechaPago','FechaConciliacion','procesado'];

    protected $table = "oper_pagos_api";

}
