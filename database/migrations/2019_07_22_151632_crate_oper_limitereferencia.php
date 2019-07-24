<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperLimitereferencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_limitereferencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('descripcion');
            $table->longText('periodicidad');
            $table->dateTime('vencimiento');
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
        Schema::table('oper_limitereferencia', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_limitereferencia');
        });
    }
}
