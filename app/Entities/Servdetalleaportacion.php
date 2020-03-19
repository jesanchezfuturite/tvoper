<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Servdetalleaportacion.
 *
 * @package namespace App\Entities;
 */
class Servdetalleaportacion extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = ['id','id_transaccion','folio','nombre_proyecto','folio_sie','id_programa','nombre_programa','ejercicio_fiscal','modalidad','contrato','numero_factura','estimacion_pagada','partida','fecha_retencion','monto_retencion','razon_social_contratado','dependencia_normativa','dependencia_ejecutora','proyecto','desc_proyecto','programa','desc_programa','subprograma','desc_subprograma','oficio','desc_oficio','desc_clasificacion_geografica','desc_dependencia_normativa','desc_dependencia_ejecutora','fecha_tramite','created_at','updated_at'];

    protected $table = "serv_detalle_aportacion";

}
