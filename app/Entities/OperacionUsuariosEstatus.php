<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperacionUsuariosEstatus.
 *
 * @package namespace App\Entities;
 */
class OperacionUsuariosEstatus extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','id_usuario','estatus'];

    protected $table = "oper_usuarios_estatus";


}
