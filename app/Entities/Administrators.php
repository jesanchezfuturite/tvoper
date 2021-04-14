<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Administrators.
 *
 * @package namespace App\Entities;
 */
class Administrators extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'oper_administrators';
    protected $fillable = ['name', 'is_admin', 'extra', 'menu','creado_por'];

}
