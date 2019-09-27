<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetalleisnprestadora.
 *
 * @package namespace App\Entities;
 */
class Contdetalleisnprestadora extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql5";
    protected $fillable = ['idtrans','Folio','rfcalfa','rfcnum','rfchom','nombre_razonS','curp','cuenta','mes','anio','no_empleados','sueldos_salarios','asimilados_salarios','remuneraciones','impuesto','impuesto_acreditable','diferencia_cargo','otras_cantidades_favor','actualizacion','recargos','total_contribuciones','declaracion_anterior','total_pagar','saldo_favor','tipo_declaracion','folio_anterior','num_complementaria','cant_acreditada','dif_impuesto','dif_actualizacion','dif_recargos'];
    protected $table = "detalle_isn_prestadora";

    public $timestamps = false;

}
