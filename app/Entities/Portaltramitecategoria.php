<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portaltramitecategoria.
 *
 * @package namespace App\Entities;
 */
class Portaltramitecategoria extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descripcion', 'status_id'];

    protected $connection = "mysql6";

    protected $table = "tramites_categorias";

}
