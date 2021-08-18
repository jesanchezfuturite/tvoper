<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePortalcatalogoescuelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portal.catalogo_escuelas', function (Blueprint $table) {
            $table->dropColumn('calve_colonia');
            $table->integer('clave_colonia')->after('nombre_municipio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portal.catalogo_escuelas', function (Blueprint $table) {

        });
    }
}
