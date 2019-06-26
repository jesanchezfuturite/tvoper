<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CfdiEncabezados.
 *
 * @package namespace App\Entities;
 */
class CfdiEncabezados extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql2";

    protected $fillable = ["metodo_de_pago","rfc_receptor"];
    
    protected $table = "cfdi_encabezados_t";
    

}
