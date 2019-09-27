<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetalleretenciones.
 *
 * @package namespace App\Entities;
 */
class Contdetalleretenciones extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql5";
    protected $fillable = ['idtrans','rfcalfa','rfcnum','rfchom','nombre_retenedora','rfc_prestadora','nombre_prestadora','cuenta','mes','anio','no_empleados','remuneraciones','retencion','tipo_declaracion','num_complementaria'];
    protected $table = "detalle_retenciones";

    public $timestamps = false;

}
