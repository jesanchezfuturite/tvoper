<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperTiporeferencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_tiporeferencia', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('fecha_condensada',100);
            $table->integer('digito_verificador');
            $table->integer('longitud');
            $table->integer('origen');
            $table->integer('dias_vigencia');
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
        Schema::table('oper_tiporeferencia', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_tiporeferencia');
        });
    }
}
