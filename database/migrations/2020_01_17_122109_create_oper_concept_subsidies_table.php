<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperConceptSubsidiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_concept_subsidies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_procedure');
            $table->decimal('total_after_subsidy',10,6);
            $table->bigInteger('currency_total');
            $table->longText('subsidy_description');
            $table->string('no_subsidy',30);
            $table->binary('format');
            $table->decimal('total_max_to_apply',10,6);
            $table->bigInteger('id_budget_heading');
            $table->string('uma_type',15);
            $table->string('uma_type_after_subsidy',15);
            $table->string('person_to_apply',100);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
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
        Schema::dropIfExists('oper_concept_subsidies');
    }
}
