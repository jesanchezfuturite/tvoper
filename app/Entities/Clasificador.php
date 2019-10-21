<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Clasificador.
 *
 * @package namespace App\Entities;
 */
class Clasificador extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = ['id','descripcion','entidad_id','created_at','updated_at'];

    protected $table = "oper_clasificador";
}
