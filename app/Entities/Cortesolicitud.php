<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Cortesolicitud.
 *
 * @package namespace App\Entities;
 */
class Cortesolicitud extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','fecha_ejecucion','banco_id','cuenta_banco','cuenta_alias','status','created_at','updated_at'];

    protected $table = "oper_corte_solicitud";

}
