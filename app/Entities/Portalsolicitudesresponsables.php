<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalsolicitudesresponsables.
 *
 * @package namespace App\Entities;
 */
class Portalsolicitudesresponsables extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = ['id','user_id','catalogo_id'];

    protected $table = "solicitudes_responsables";


}
