<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Familia.
 *
 * @package namespace App\Entities;
 */
class Familia extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = [
        'id',
        'nombre'
    ];

    protected $table = "oper_familia";
    

}
