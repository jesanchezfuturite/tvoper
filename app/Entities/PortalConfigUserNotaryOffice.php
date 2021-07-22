<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PortalConfigUserNotaryOffice.
 *
 * @package namespace App\Entities;
 */
class PortalConfigUserNotaryOffice extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $connection = "mysql6";
     
	protected $fillable = [
		"notary_office_id",
		"user_id"
    ];
    
    protected $table = "config_user_notary_offices";

    public function notary(){
        return $this->hasMany('App\Entities\PortalNotaryOffices', 'id', 'notary_office_id')->select(['id','notary_number','titular_id']);
    }
	

}
