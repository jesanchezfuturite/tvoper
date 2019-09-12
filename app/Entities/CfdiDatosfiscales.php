<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CfdiDatosfiscales.
 *
 * @package namespace App\Entities;
 */
class CfdiDatosfiscales extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql2";

    protected $table = "cfdi_datos_fiscales";

    public $timestamps = false;

    protected $fillable = [];

}
