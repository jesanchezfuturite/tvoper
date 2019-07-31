<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Cuentasbanco.
 *
 * @package namespace App\Entities;
 */
class Cuentasbanco extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['banco_id','metodopago','beneficiario_json','status','monto_min','monto_max'];

    protected $table = "oper_cuentasbanco";

}
