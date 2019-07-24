<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Tiporeferencia.
 *
 * @package namespace App\Entities;
 */
class Tiporeferencia extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['fecha_condensada','digito_verificador','longitud','origen','dias_vigencia'];

    protected $table = "oper_tiporeferencia";

}
