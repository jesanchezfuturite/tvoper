<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetalleisop.
 *
 * @package namespace App\Entities;
 */
class Contdetalleisop extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql5";
    protected $fillable = ['idTrans','Folio','premio','impuesto','actualizacion','recargos','total_contribuciones','anio','mes','rfcalf','rfcnum','rfchom','curp','nombre_razonS','cuenta'];
    protected $table = "detalle_isop";

    public $timestamps = false;

}
