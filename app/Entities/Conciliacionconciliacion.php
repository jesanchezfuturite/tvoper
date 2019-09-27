<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Conciliacionconciliacion.
 *
 * @package namespace App\Entities;
 */
class Conciliacionconciliacion extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql4";

    protected $table = "conciliacion";

    public $timestamps = false;

    protected $fillable = ['idtrans','fecha_conciliacion','importe','anomalia','statusAnterior','bancoAnterior','claveConciliacion','fecha_archivo','archivo','fecha_banco','Banco','Autorizacion','metodo_pago'];

}
