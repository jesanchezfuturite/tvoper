<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CfdiDetalle.
 *
 * @package namespace App\Entities;
 */
class CfdiDetalle extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 	protected $connection = "mysql2";

    protected $fillable = [
    	'folio_unico',
    	'cantidad',
    	'unidad',
    	'concepto',
    	'precio_unitario',
    	'importe',
    	'partida',
    	'fecha_registro',
    	'id_oper',
    	'id_mov',
    	'st_gen',
    	'st_doc',
    	'info'
    ];

    protected $table = "cfdi_detalle_t";

    public $timestamps = false;

}
