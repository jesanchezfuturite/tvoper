<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Tramite.
 *
 * @package namespace App\Entities;
 */
class Tramite extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id_transaccion_motor','id_tipo_servicio','id_seguimiento','id_tramite','nombre','apellido_paterno','apellido_materno','razon_social','rfc','curp','email','calle','colonia','numexterior','numinterior','municipio','codigopostal','importe_tramite','auxiliar_1','auxiliar_2','auxiliar_3','nombre_factura','apellido_paterno_factura','apellido_materno_factura','razon_social_factura','rfc_factura','curp_factura','email_factura','calle_factura','colonia_factura','numexteior_factura','numinterior_factura','municipio_factura','codigopostal_factura'];

    protected $table = "oper_tramites";

    public $timestamps = false;

}
