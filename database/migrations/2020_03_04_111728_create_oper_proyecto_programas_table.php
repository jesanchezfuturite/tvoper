<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperProyectoProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_proyecto_programas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clave_fuente_financiamiento',250);
            $table->string('descripcion_fuente_financiamiento',250);
            $table->string('anio',5);
            $table->string('tipo',250);
            $table->string('clave_sector',250);
            $table->string('descripcion_sector',250);
            $table->string('secretaria',250);
            $table->string('descripcion_secretaria',250);
            $table->string('clave_clasificacion_geografica',250);
            $table->string('descripcion_clasificacion_geografica',250);
            $table->string('clave_dependencia_normativa',250);
            $table->string('descripcion_dependencia_normativa',250);
            $table->string('clave_dependencia_ejecutora',250);
            $table->string('descripcion_dependencia_ejecutora',250);
            $table->string('finalidad',250);
            $table->string('descripcion_finalidad',250);
            $table->string('clave_clasificacion_funcional',250);
            $table->string('descripcion_clasificacion_funcional',250);
            $table->string('cog',250);
            $table->string('descripcion_cog',250);
            $table->string('programa',250);
            $table->string('descripcion_programa',250);
            $table->string('subprograma',250);
            $table->string('descripcion_subprograma',250);
            $table->string('proyecto',250);
            $table->string('descripcion_proyecto',250);
            $table->string('oficio',250);
            $table->string('descripcion_oficio',250);
            $table->string('folio',250);
            $table->string('ejercicio',250);
            $table->string('partida',45);
            $table->timestamp('fecha');
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
        Schema::dropIfExists('oper_proyecto_programas');
    }
}
