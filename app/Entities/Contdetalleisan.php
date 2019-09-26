<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetalleisan.
 *
 * @package namespace App\Entities;
 */
class Contdetalleisan extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql5";

    protected $fillable = ['idTrans','Folio','isan_ejercicio','monto','impuesto','actualizacion','recargos','multa','gastosEjecucion','multa_requerimiento','no_control','total_contribuciones','declaracion_anterior','pago_exceso','total_cargo','autos_enajenados_unidades','camiones_enajenados_unidades','autos_exentos_unidades','vehiculos_exentos_unidades','autos_enajenados_valor','camiones_enajenados_valor','autos_exentos_valor','vehiculos_exentos_valor','total_unidades','total_valor','vehiculos_incorporados','facturas_expedidas_inicial','facturas_expedidas_final','vehiculos_enajenados_periodo','valor_total_enajenacion','tipo_tramite','tipo_declaracion','folio_anterior','anio_1','mes_1','anio_2','mes_2','num_complementaria','tipo_establecimiento','tipo_contribuyente','ALR','rfcalf','rfcnum','rfchom','curp','nombre_razonS','cuenta``dif_impuesto','dif_actualizacion','dif_recargos','dif_multa','dif_gastosE','dif_multaR'];

    protected $table = "detalle_isan";

    public $timestamps = false;

}
