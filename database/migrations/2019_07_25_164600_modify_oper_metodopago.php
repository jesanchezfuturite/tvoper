<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyOperMetodopago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_metodopago', function (Blueprint $table) {
            //
            $table->dropColumn('banco_id');
            $table->bigInteger('cuentasbanco_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oper_metodopago', function (Blueprint $table) {
            //
            $table->dropColumn('cuentasbanco_id');
        });
    }
}
