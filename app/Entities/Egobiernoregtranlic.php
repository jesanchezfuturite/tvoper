<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernoregtranlic.
 *
 * @package namespace App\Entities;
 */
class Egobiernoregtranlic extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $connection = "mysql3";
    
   protected $fillable = ['idicv','idcarrito','status','fallo','txt_fallo','imp_tra','imp_msj','imp_don','imp_ttl','concluido'];

    protected $table = "regtranlic";
	
	public $timestamps = false;

}
