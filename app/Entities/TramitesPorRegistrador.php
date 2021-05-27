<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TramitePorRegistrador.
 *
 * @package namespace App\Entities;
 */
class TramitesPorRegistrador extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = [
        'id',
        'registrador_id'
        'tramite_id',
        'region_id'
    ]

    protected $table = "tramites_por_registrador";

}
