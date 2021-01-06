<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperPagosupdateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_pagosupdate_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fecha_pago')->index();
            $table->string('referencia',30)->index();
            $table->bigInteger('id_transaccion')->index();
            $table->string('banco_desc',20);
            $table->string('plataforma',20);
            $table->decimal('monto',10,2);
            $table->longText('data');
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
        Schema::dropIfExists('oper_pagosupdate_log');
    }
}
