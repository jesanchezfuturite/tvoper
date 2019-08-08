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

    protected $fillable = ['concepto','precio_unitario','importe','partida'];

    protected $table = "cfdi_detalle_t";

    public $timestamps = false;

}
