<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernopartidas.
 *
 * @package namespace App\Entities;
 */
class Egobiernopartidas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql3";
    
    protected $fillable = [];

    protected $table = "partidas";

}
