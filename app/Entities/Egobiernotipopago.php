<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernotipopago.
 *
 * @package namespace App\Entities;
 */
class Egobiernotipopago extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql3";

    protected $table = "tipopago";

    public $timestamps = false;

    protected $fillable = ['Tipo_Code','Tipo_Descripcion','Origen_URL','GpoTrans_Num','id_gpm','descripcion_gpm','tiporeferencia_id','limitereferencia_id'];

}
