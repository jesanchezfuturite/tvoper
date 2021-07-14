<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Operanomalias.
 *
 * @package namespace App\Entities;
 */
class Operanomalias extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','origen','referencia','id_processed','transaccion_id','monto','banco_id','cuenta_banco','cuenta_alias','fecha_ejecucion','fecha_pago','estatus_anomalia','created_at','updated_at'];

    protected $table = "oper_anomalias";


}
