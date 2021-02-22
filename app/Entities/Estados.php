<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Estados.
 *
 * @package namespace App\Entities;
 */
class Estados extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";
    protected $fillable = [
        "clave",
        "nombre"
    ];
    protected $table = "estados";

}
