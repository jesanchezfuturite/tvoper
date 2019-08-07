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

    protected $fillable = ['id','banco_id','metodopago','beneficiario_json','status','monto_min','monto_max','created_at','updated_at'];

    protected $table = "oper_cuentasbanco";
    public $timestamps = false;

}
