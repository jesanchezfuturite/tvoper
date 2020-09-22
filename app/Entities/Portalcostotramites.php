<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalcostotramites.
 *
 * @package namespace App\Entities;
 */
class Portalcostotramites extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $connection = "mysql";

    protected $fillable = ['id','tramite_id','tipo','costo','minimo','maximo','status'];

    protected $table = "portal_costo_tramites";

}
