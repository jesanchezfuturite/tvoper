<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Umahistory.
 *
 * @package namespace App\Entities;
 */
class Umahistory extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $connection = "mysql";

    protected $fillable = ['id','daily','monthly','yearly','year','fecha_inicio','fecha_fin','created_at','updated_at'];

    protected $table = "oper_uma_history";

}
