<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Detalletramite.
 *
 * @package namespace App\Entities;
 */
class Detalletramite extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "oper_detalle_tramite";
    
    protected $fillable = [
    	'id_detalle_tramite',
    	'id_tramite_motor',
    	'concepto',
    	'importe_concepto',
    	'partida'
    ];

}
