<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperFoliosEntidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_folios_entidad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_transaccion_motor');
            $table->integer('entidad');
            $table->string('id_transaccion',50);
            $table->string('referencia',50);
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
        Schema::dropIfExists('oper_folios_entidad');
    }
}
