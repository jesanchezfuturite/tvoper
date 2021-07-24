<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model {
    protected $connection = 'mysql6';
    protected $table = 'solicitudes_ticket as ticket';
    protected $casts = [
        'info' => 'object',
        'enajenantes' => 'object',
        'tickets' => 'array',
        'is_group' => 'boolean',
        'en_carrito' => 'boolean',
        'por_firmar' => 'boolean',
        'firmado' => 'boolean',
        'doc_firmado' => 'array'
    ];

    public function operacion () {
        return $this->hasOneThrough(Transaccion::class, OperTransaccion::class, 'id_transaccion_motor', 'id_transaccion_motor', null, 'id_transaccion_motor');
    }

    public function files () {
        return $this->hasMany(Mensajes::class, 'clave', 'clave')->whereNotNull('attach')->where('status', 1);
    }
}