<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersPortal.
 *
 * @package namespace App\Entities;
 */
class UsersPortal extends Model 
{
    protected $connection = "mysql6";
    protected $table ="portal.users";
    /**
     * @var array
     */
    protected $fillable = [
		"id",
		'username', 
		'email', 
		'password', 
		'role_id',
		'config_id',
		'name', 
		'mothers_surname', 
		'fathers_surname', 
		'curp', 
		'rfc', 
		'phone', 
		'status' 
	
	];



}
