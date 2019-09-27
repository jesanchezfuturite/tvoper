<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetalleish.
 *
 * @package namespace App\Entities;
 */
class Contdetalleish extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql5";
    protected $fillable = ['idTrans','Folio','erogaciones','impuesto','actualizacion','recargos','multa','gastos_ejecucion','total_contribuciones','subsidio_imp','subsidio_recargos','total_pagar','declaracion_anterior','total_cargo','pago_exceso','folio_anterior','tipo_declaracion','anio','mes','num_complementaria','rfcalf','rfcnum','rfchom','curp','nombre_razonS','cuenta','area','sucursal','dif_imp','dif_act','dif_rec'];
    protected $table = "detalle_ish";

    public $timestamps = false;

}
