<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPrTransacciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_processedregisters', function (Blueprint $table) {
            //
            $table->json('info_transacciones')->after('fecha_ejecucion');
            $table->string('archivo_corte',100)->after('fecha_ejecucion');
            $table->integer('tipo_servicio')->after('fecha_ejecucion');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oper_processedregisters', function (Blueprint $table) {
            //
        });
    }
}
