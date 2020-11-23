<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Portalnotifications.
 *
 * @package namespace App\Entities;
 */
class Portalnotifications extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";
    protected $fillable = ['id','solicitud_id','name','title','description','type_id','created_by','updated_at','created_at','until_at','closed_at','closed'];
    protected $table = "notifications";

}
