<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Icvremotodetalle.
 *
 * @package namespace App\Entities;
 */
class Icvremotodetalle extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "oracle";
    
    protected $fillable = [];

    protected $table = "detalle";
	
	public $timestamps = false;

}
