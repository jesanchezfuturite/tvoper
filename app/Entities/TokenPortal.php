<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TokenPortal.
 *
 * @package namespace App\Entities;
 */
class TokenPortal extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql6";

    protected $fillable = [
        'id',
        'ticket_id',
        'id_transaccion'
    ];

    

    protected $table = "token_portal";
}
