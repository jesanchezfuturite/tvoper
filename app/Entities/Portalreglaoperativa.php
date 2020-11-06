<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalreglaoperativa.
 *
 * @package namespace App\Entities;
 */
class Portalreglaoperativa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql6";
    protected $fillable = ['nombre','definicion', 'status'];
    protected $table = "regla_operativa";

}
