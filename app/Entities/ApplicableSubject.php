<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ApplicableSubject.
 *
 * @package namespace App\Entities;
 */
class ApplicableSubject extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $connection = "mysql";

    protected $fillable = ['id','name','active','created_at','updated_at'];

    protected $table = "oper_applicable_subject";


}
