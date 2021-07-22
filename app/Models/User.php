<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
	protected $connection = 'mysql6';

	public function notary(){
		return $this->hasOneThrough(NotaryOffice::class, UsersNotaryOffices::class, 'user_id', 'id', '', 'notary_office_id');
	}

	public function notaryUsers () {
		return UsersNotaryOffices::where('notary_office_id', $this->notary->id)->users();
	}
}