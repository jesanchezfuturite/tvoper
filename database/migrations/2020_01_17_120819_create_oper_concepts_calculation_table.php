<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperConceptsCalculationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_concepts_calculation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_applicable_subject');
            $table->bigInteger('id_budget_heading');
            $table->string('method',80);
            $table->decimal('total',10,2);
            $table->decimal('max_price',10,2);
            $table->decimal('min_price',10,2);
            $table->boolean ('is_right');
            $table->decimal('percent',10,2);
            $table->longText('formula');
            $table->date('expiration');
            $table->boolean ('has_expiration');
            $table->boolean ('is_creditable',);
            $table->bigInteger('concept_to_apply');
            $table->longText('data');
            $table->bigInteger('id_procedure');
            $table->decimal('quantity',10,2);
            $table->string('name_concept',20);
            $table->boolean ('has_lot');
            $table->decimal('lot_equivalence',10,2);
            $table->bigInteger('currency_total');
            $table->bigInteger('currency_formula');
            $table->bigInteger('currency_max');
            $table->bigInteger('currency_min');
            $table->bigInteger('currency_lot_equivalence');
            $table->longText('subsidy_description');
            $table->string('no_subsidy',30);
            $table->boolean ('has_max');
            $table->boolean ('round_total');
            $table->boolean ('round_amount_thousand');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oper_concepts_calculation');
    }
}
