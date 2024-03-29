<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Entidad.
 *
 * @package namespace App\Entities;
 */
class Entidad extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','nombre','clave','created_at','updated_at'];

    protected $table = "oper_entidad";

    public $timestamps = false;

    public function familia () {
		return $this->belongsToMany("App\Entities\Familia", "App\Entities\Familiaentidad", "entidad_id");
	}
}
