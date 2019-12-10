<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Familiaentidad.
 *
 * @package namespace App\Entities;
 */
class Familiaentidad extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = [
    'id',
    'familia_id',
    'entidad_id'
    ];

    protected $table = "oper_familiaentidad";


}
