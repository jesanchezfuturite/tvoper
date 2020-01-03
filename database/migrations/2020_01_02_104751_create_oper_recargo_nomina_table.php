<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperRecargoNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_recargo_nomina', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ano');
            $table->integer('mes');
            $table->decimal('vencido', 8 ,2);
            $table->decimal('requerido', 8 ,2);
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
        Schema::dropIfExists('oper_recargo_nomina');
    }
}
