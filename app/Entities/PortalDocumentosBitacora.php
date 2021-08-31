<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalDocumentosBitacora.
 *
 * @package namespace App\Entities;
 */
class PortalDocumentosBitacora extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = ['id','ticket_id','attach','descripcion','user_id'];

    protected $table = "documentos_bitacora";


}
