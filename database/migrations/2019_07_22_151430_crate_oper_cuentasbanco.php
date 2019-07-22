<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperCuentasbanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_cuentasbanco', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('banco_id');
            $table->json('beneficiario');
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
        Schema::table('oper_cuentasbanco', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_cuentasbanco');
        });
    }
}
