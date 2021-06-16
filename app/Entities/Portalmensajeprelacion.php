<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalmensajeprelacion.
 *
 * @package namespace App\Entities;
 */
class Portalmensajeprelacion extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql6";

    protected $fillable = ['id','grupo_clave','url_prelacion','status','created_at','upodated_at'];

    protected $table = "mensaje_prelacion";

}
