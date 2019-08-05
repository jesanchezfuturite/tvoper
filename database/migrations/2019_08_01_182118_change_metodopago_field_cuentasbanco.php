<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMetodopagoFieldCuentasbanco extends Migration
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
            $table->dropColumn('metodopago');
            $table->integer('metodopago_id')->after('banco_id');

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
        });
    }
}
