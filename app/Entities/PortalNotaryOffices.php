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

}
