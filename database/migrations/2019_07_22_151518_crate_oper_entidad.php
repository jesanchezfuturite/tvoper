<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperEntidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_entidad', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->longText('nombre');
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
        Schema::table('oper_entidad', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_entidad');
        });
    }
}
