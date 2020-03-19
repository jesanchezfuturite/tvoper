<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerDetalleAportacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_detalle_aportacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_transaccion');
            $table->bigInteger('folio');
            $table->string('nombre_proyecto',250);
            $table->string('folio_sie',150);
            $table->bigInteger('id_programa');
            $table->string('nombre_programa',250);
            $table->bigInteger('ejercicio_fiscal');
            $table->bigInteger('modalidad');
            $table->string('contrato',150);
            $table->string('numero_factura',60);
            $table->bigInteger('estimacion_pagada');
            $table->bigInteger('partida');
            $table->date('fecha_retencion');
            $table->decimal('monto_retencion',15,2);
            $table->string('razon_social_contratado',250);
            $table->string('dependencia_normativa',250);
            $table->string('dependencia_ejecutora',250);
            $table->string('proyecto',250);
            $table->string('desc_proyecto',250);
            $table->string('programa',250);
            $table->string('desc_programa',250);
            $table->string('subprograma',250);
            $table->string('desc_subprograma',250);
            $table->string('oficio',250);
            $table->string('desc_oficio',250);
            $table->string('desc_clasificacion_geografica',250);
            $table->string('desc_dependencia_normativa',250);
            $table->string('desc_dependencia_ejecutora',250);
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
        Schema::dropIfExists('serv_detalle_aportacion');
    }
}
