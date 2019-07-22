<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperMetodopago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_metodopago', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('banco_id');
            $table->longText('nombre');
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
        Schema::table('oper_metodopago', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_metodopago');
        });
    }
}
