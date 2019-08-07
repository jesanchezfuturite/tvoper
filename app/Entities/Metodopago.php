<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Metodopago.
 *
 * @package namespace App\Entities;
 */
class Metodopago extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','nombre','abreviatura','created_at','update_at'];

    protected $table = "oper_metodopago";

    public $timestamps = false;

}
