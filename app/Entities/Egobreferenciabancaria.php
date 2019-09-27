<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobreferenciabancaria.
 *
 * @package namespace App\Entities;
 */
class Egobreferenciabancaria extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $connection = "mysql3";
    
    protected $fillable = ['idTrans','Linea','FechaLimite','BancoPago','FechaCanc'];

    protected $table = "referenciabancaria";
	
	public $timestamps = false;

}
