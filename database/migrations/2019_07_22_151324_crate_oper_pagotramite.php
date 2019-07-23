<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperPagotramite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_pagotramite', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('metodo_id');
            $table->bigInteger('tramite_id');
            $table->bigInteger('status_id');
            $table->bigInteger('catalogotramite_id');
            $table->longText('descripcion');
            $table->decimal('monto_minimo', 8 ,2);
            $table->decimal('monto_maximo', 8 ,2);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
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
        Schema::table('oper_pagotramite', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_pagotramite');
        });
    }
}
