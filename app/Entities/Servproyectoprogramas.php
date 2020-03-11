<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Servproyectoprogramas.
 *
 * @package namespace App\Entities;
 */
class Servproyectoprogramas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = ['id','clave_fuente_financiamiento','descripcion_fuente_financiamiento','anio','tipo','clave_sector','descripcion_sector','secretaria','descripcion_secretaria','clave_clasificacion_geografica','descripcion_clasificacion_geografica','clave_dependencia_normativa','descripcion_dependencia_normativa','clave_dependencia_ejecutora','descripcion_dependencia_ejecutora','finalidad','descripcion_finalidad','clave_clasificacion_funcional','descripcion_clasificacion_funcional','cog','descripcion_cog','programa','descripcion_programa','subprograma','descripcion_subprograma','proyecto','descripcion_proyecto','oficio','descripcion_oficio','folio','ejercicio','partida','fecha','created_at','updated_at'];

    protected $table = "serv_proyecto_programas";

}
