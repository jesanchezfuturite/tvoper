<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperUsuariobdEntidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_usuariobd_entidad', function (Blueprint $table) {
            $table->bigIncrements('idusuariobd_entidad');
            $table->integer('id_entidad');
            $table->string('usuariobd', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oper_usuariobd_entidad');
    }
}
