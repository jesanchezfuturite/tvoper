<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Users.
 *
 * @package namespace App\Entities;
 */
class Users extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    protected $fillable = ['name','email','status','email_verified_at','password','remember_token' , 'idComunidad', 'portal_registrador_id'];

}
