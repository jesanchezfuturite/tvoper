<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersNotaryOffices extends Model {
	protected $connection = 'mysql6';
    protected $table = 'config_user_notary_offices';

    public function users () {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }
}