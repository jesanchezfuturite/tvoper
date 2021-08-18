<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalCatalogoescuelas.
 *
 * @package namespace App\Entities;
 */
class PortalCatalogoescuelas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql6";

    protected $fillable = ['cct','nombre_escuela','clave_municipio','nombre_municipio','clave_colonia','nombre_colonia','calle','num_exterior','clave_turno','nombre_turno','mensaje','clave_nivel','nombre_nivel','clave_estatus_cct','nombre_estatus_cct'];

    protected $table = "catalogo_escuelas";

}
