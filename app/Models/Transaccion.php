<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model {
    protected $connection = 'mysql6';
    protected $table = 'solicitudes_tramite';
}