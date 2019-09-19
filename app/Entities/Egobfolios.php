<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobfolios.
 *
 * @package namespace App\Entities;
 */
class Egobfolios extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql3";
    
    protected $fillable = ['Folio','idTrans','CartCantidad','CartKey1','CartKey2','CartImporte','CartTipo','CartDescripcion','CartKey3','idgestor'];

    protected $table = "folios";
	
	public $timestamps = false;

}
