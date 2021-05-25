<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Distrito.
 *
 * @package namespace App\Entities;
 */
class Distrito extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";
    protected $fillable = [
        "id",
        "descripcion",
        "valor"
    ];
    protected $table = "distrito";

}
