<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernotransaccionesgpm.
 *
 * @package namespace App\Entities;
 */
class Egobiernotransaccionesgpm extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql3";

    protected $fillable = ['idtransacciones_gpm','id_entidad','id_transaccion','id_transaccion_entidad','json','id_transaccion_datalogic','respuesta_datalogic','fecha'];

    protected $table = "transacciones_gpm";
}
