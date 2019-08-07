<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Limitereferencia.
 *
 * @package namespace App\Entities;
 */
class Limitereferencia extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','descripcion','periodicidad','vencimiento','created_at','updated_at'];

    protected $table = "oper_limitereferencia";
    public $timestamps = false;
}
