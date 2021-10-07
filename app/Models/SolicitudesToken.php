<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudesToken extends Model {
	protected $connection = 'mysql6';
	protected $table = 'token_relacion_portal';
}