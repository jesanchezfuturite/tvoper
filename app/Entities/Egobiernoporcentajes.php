<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernoporcentajes.
 *
 * @package namespace App\Entities;
 */
class Egobiernoporcentajes extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql3";
     protected $fillable = ['anio','mes','vencido','federal_vencido','requerido'];

	protected $table = "porcentajes";

	public $timestamps = false;

}
