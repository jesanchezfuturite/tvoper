<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperLogBancos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_log_bancos', function (Blueprint $table) {
            $table->bigIncrements('idoper_log_bancos');
            $table->string('banco',50);
            $table->datetime('fecha')->nullable();
            $table->string('proceso',45)->nullable();
            $table->Integer('id_transaccion')->nullable();
            $table->binary('parametros')->nullable();
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
        Schema::dropIfExists('oper_log_bancos');
    }
}
