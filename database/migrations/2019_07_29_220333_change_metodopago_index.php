<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMetodopagoIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_pagotramite', function (Blueprint $table) {
            //
            $table->dropColumn('metodo_id');
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
        Schema::table('oper_pagotramite', function (Blueprint $table) {
            //
            $table->dropColumn('cuentasbanco_id');
        });
    }
}
