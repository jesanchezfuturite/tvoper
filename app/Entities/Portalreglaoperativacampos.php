<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalreglaoperativacampos.
 *
 * @package namespace App\Entities;
 */
class Portalreglaoperativacampos extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql6";

    protected $fillable = ['id_campo','constante', 'status'];

    protected $table = "regla_operativa_campos";

}
