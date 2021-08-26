<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryOffice extends Model {
	protected $connection = 'mysql6';

	public function users () {
		return $this->hasManyThrough(User::class, UsersNotaryOffices::class, 'user_id', 'id', 'id', 'user_id');
	}
}