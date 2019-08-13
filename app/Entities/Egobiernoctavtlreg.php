<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Egobiernoctavtlreg.
 *
 * @package namespace App\Entities;
 */
class Egobiernoctavtlreg extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql3";

    protected $table = "ctavtl_reg";

    public $timestamps = false;

    protected $fillable = [];

}
