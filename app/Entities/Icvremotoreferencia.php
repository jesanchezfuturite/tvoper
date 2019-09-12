<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Icvremotoreferencia.
 *
 * @package namespace App\Entities;
 */
class Icvremotoreferencia extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "oracle";
    
    protected $fillable = [];

    protected $table = "encabezado";
	
	public $timestamps = false;

}
