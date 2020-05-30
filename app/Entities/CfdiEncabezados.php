<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CfdiEncabezados.
 *
 * @package namespace App\Entities;
 */
class CfdiEncabezados extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql2";

    protected $fillable = [
        "folio_unico",
        "fecha_transaccion",
        "template_id",
        "tipo_documento",
        "total_transaccion",
        "forma_de_pago",
        "descuento",
        "subtotal",
        "total",
        "metodo_de_pago",
        "numero_de_cuenta",
        "motivo_descuento",
        "lugar_expedicion",
        "rfc_receptor"
    ];
    
    protected $table = "cfdi_encabezados_t";

    public $timestamps = false;
    

}
