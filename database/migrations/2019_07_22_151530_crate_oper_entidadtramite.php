<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperEntidadtramite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_entidadtramite', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('entidad_id');
            $table->bigInteger('tipo_servicios_id');
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
        Schema::table('oper_entidadtramite', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_entidadtramite');
        });
    }
}
