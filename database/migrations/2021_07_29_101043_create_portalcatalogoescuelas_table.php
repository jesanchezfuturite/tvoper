<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortalcatalogoescuelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal.catalogo_escuelas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cct');
            $table->text('nombre_escuela');
            $table->integer('clave_municipio');
            $table->text('nombre_municipio');
            $table->integer('calve_colonia');
            $table->text('nombre_colonia');
            $table->text('calle');
            $table->integer('num_exterior');
            $table->integer('clave_turno');
            $table->text('nombre_turno');
            $table->text('mensaje');
            $table->integer('clave_nivel');
            $table->text('nombre_nivel');
            $table->integer('clave_estatus_cct');
            $table->text('nombre_estatus_cct');
            $table->timestamps();
            $table->index('cct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portal.catalogo_escuelas');
    }
}
