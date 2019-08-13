<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Conciliacionanomalia.
 *
 * @package namespace App\Entities;
 */
class Conciliacionanomalia extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql4";

    protected $table = "anomalia";

    public $timestamps = false;

    protected $fillable = [];

}
