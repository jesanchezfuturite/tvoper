<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServDetalleServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_detalle_servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idTrans');
            $table->bigInteger('Folio');
            $table->string('rfc',13);
            $table->string('curp',18);
            $table->string('calle',25);
            $table->string('no_ext',6);
            $table->string('no_int',6);
            $table->string('colonia',30);
            $table->string('minicipio_delegacion',30);
            $table->string('cp',5);
            $table->decimal('monto',13,2);
            $table->string('partida',15);
            $table->string('estado_pais',60);
            $table->string('consepto',320);
            $table->string('nombre_razonS',120);
            $table->string('desc_partida',80);
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
        Schema::dropIfExists('serv_detalle_servicios');
    }
}
