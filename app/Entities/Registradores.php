<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Registradores.
 *
 * @package namespace App\Entities;
 */
class Registradores extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = [
        'descripcion',
        'instituciones_id',
        'municipios_id'
    ];

    protected $table = "registradores";

}
