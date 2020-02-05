<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Conceptsubsidies.
 *
 * @package namespace App\Entities;
 */
class Conceptsubsidies extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $connection = "mysql";

    protected $fillable = ['id','id_procedure','total_after_subsidy','currency_total','subsidy_description','no_subsidy','format','total_max_to_apply','id_budget_heading','uma_type','uma_type_after_subsidy','person_to_apply','fecha_inicio','fecha_fin','created_at','updated_at'];

    protected $table = "oper_concept_subsidies";

}
