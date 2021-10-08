<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Transacciones.
 *
 * @package namespace App\Entities;
 */
class Transacciones extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $connection = "mysql";

    protected $fillable = [
        'id_transaccion_motor',
        'estatus',
        'referencia',
        'importe_transaccion',
        'fecha_transaccion',
        'id_transaccion',
        'fecha_limite_referencia',
        'entidad',
        'tipo_pago',
        'id_transaccion',
        'email_referencia',
        'email_pago',
    ];

    protected $table = "oper_transacciones";
    public $timestamps = false;

    public function entidad () {
		  return $this->hasMany("App\Entities\Entidad", "id", "entidad");
	  }    
   
    public function pago () {
		  return $this->hasMany("App\Entities\Egobiernotipopago", "TipoPago", "tipo_pago");
	  }
    public function status () {
		  return $this->hasMany("App\Entities\Egobiernostatus", "Status", "estatus");
	  }

    public function tramitesoper () {
		  return $this->hasMany("App\Entities\Tramites", "id_transaccion_motor", "id_transaccion_motor");
	  }

    

}
