<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetalleisnretenedor.
 *
 * @package namespace App\Entities;
 */
class Contdetalleisnretenedor extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql5";
    protected $fillable = ['idtrans','Folio','rfcalfa','rfcnum','rfchom','nombre_razonS','curp','cuenta','mes','anio','tipo_declaracion','impuesto_retenido','actualizacion','recargos','total','folio_anterior','num_complementaria','declaracion_anterior','tipo_tramite','periodo'];
    protected $table = "detalle_isn_retenedor";

    public $timestamps = false;

}
