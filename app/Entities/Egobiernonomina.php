<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernonomina.
 *
 * @package namespace App\Entities;
 */
class Egobiernonomina extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql3";
    
   	protected $fillable = ['folio','idtran','munnom','cvenom','rfcalf','rfcnum','rfchomo','tipopago','mesdec','tridec','anodec','numemp','remuneracion','base','actualiza','recargos','gtoeje','sancion','compensacion'];

    protected $table = "nomina";
	
	public $timestamps = false;
    
}
