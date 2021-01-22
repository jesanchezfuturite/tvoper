<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Municipios.
 *
 * @package namespace App\Entities;
 */
class Municipios extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";
    protected $fillable = [
        "clave",
        "clave_estado",
        "nombre"
    ];
    protected $table = "municipios";

}
