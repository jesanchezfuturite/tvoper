<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Processedregisters.
 *
 * @package namespace App\Entities;
 */
class Processedregisters extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $table = "oper_processedregisters";

    protected $fillable = ['transaccion_id','day','month','year','monto','status','filename','origen','referencia','cuenta_banco','cuenta_alias','banco_id','fecha_ejecucion','info_transacciones','archivo_corte','tipo_servicio'];

}
