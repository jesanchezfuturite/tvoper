<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Entidadtramite.
 *
 * @package namespace App\Entities;
 */
class Entidadtramite extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['entidad_id','tipo_servicios_id'];

    protected $table = "oper_entidadtramite";

    public $timestamps = false;

}
