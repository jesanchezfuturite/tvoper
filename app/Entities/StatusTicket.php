<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersPortal.
 *
 * @package namespace App\Entities;
 */
class StatusTicket extends Model 
{
    protected $connection = "mysql6";
    protected $table ="portal.solicitudes_status";
    /**
     * @var array
     */
    protected $fillable = [
		"id",
		'descripcion' 
	
	];



}
