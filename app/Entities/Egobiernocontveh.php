<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernocontveh.
 *
 * @package namespace App\Entities;
 */
class Egobiernocontveh extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql3";

    protected $table = "contveh";

    public $timestamps = false;
    
    protected $fillable = ['folio','idtran','placa','placaa','placan','concepto','rezago','importe','recargo','entfed','guid','referencia','partida','descripcion','anio'];

}
