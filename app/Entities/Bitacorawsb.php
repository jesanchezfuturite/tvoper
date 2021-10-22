<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Bitacorawsb.
 *
 * @package namespace App\Entities;
 */
class Bitacorawsb extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'oper_bitacora_wsbancos';
    protected $fillable = [];

}
