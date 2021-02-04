<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TramitesDivisas.
 *
 * @package namespace App\Entities;
 */
class TramitesDivisas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'tramite_id'];

    protected $connection = "mysql6";

    protected $table = "tramites_divisas";

}
