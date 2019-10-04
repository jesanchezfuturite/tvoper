<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CorteArchivos.
 *
 * @package namespace App\Entities;
 */
class CorteArchivos extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $connection = "mysql";

    protected $fillable = ['id','json_archivos','created_at','updated_at'];

    protected $table = "oper_corte_archivos";
   // public $timestamps = false;

}
