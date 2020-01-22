<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ConceptsCalculation.
 *
 * @package namespace App\Entities;
 */
class ConceptsCalculation extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql";

    protected $fillable = ['id','id_applicable_subject','id_budget_heading','method','total','min_price','max_price','is_right','percent','formula','expiration','has_expiration','is_creditable','concept_to_apply','data','id_procedure','quantity','name_concept','has_lot','lot_equivalence','currency_total','currency_formula','currency_max','currency_min','currency_lot_equivalence','subsidy_description','no_subsidy','has_max','round_total','round_amount_thousand','created_at','updated_at'];

    protected $table = "oper_concepts_calculation";

}
