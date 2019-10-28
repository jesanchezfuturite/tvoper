<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pagotramite.
 *
 * @package namespace App\Entities;
 */
class Pagotramite extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','cuentasbanco_id','tramite_id','estatus','descripcion','fecha_inicio','fecha_fin','created_at','updated_at'];

    protected $table = "oper_pagotramite";
    public $timestamps = false;
}
