<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalNotaryOffices.
 *
 * @package namespace App\Entities;
 */
class PortalNotaryOffices extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";
    protected $fillable = [
		"notary_number",
		"phone",
		"fax",
		"email",
		"street",
		"number",
		"district",
		"federal_entity_id",
		"city_id",
		"zip",
		"titular_id",
		"substitute_id"
    ];
    protected $table = "notary_offices";

	
	public function titular () {
		return $this->hasOne("App\Entities\UsersPortal", "id", "titular_id");
	}

	public function substitute () {
		return $this->hasOne("App\Entities\UsersPortal", "id", "substitute_id");
	}

	public function users () {
		return $this->belongsToMany("App\Entities\UsersPortal", "App\Entities\PortalConfigUserNotaryOffice", "notary_office_id");
	}

}
