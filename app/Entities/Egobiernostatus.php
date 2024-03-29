<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernostatus.
 *
 * @package namespace App\Entities;
 */
class Egobiernostatus extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql3";
    
    protected $fillable = ['Status','Descripcion'];

    protected $table = "status";
	
	public $timestamps = false;

}
