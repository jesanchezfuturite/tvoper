<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Usuariodbentidad.
 *
 * @package namespace App\Entities;
 */
class Usuariodbentidad extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['idusuariobd_entidad','id_entidad','usuariobd'];

    protected $table = "oper_usuariobd_entidad";

}
