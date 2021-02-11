<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SolicitudesMotivo.
 *
 * @package namespace App\Entities;
 */
class SolicitudesMotivo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = ['id','motivo_id', 'solicitud_catalogo_id'];

    protected $table = "solicitudes_motivo";

    public function motivos(){
		return $this->hasMany('App\Entities\Motivoa', 'motivo_id', 'id');
	}

}
