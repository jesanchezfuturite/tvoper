<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Banco.
 *
 * @package namespace App\Entities;
 */
class Banco extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','nombre','url_logo','status','created_at','updated_at'];

    protected $table = "oper_banco";

    public $timestamps = false;
}
