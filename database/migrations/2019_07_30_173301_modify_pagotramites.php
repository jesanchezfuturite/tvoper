<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPagotramites extends Migration
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
            $table->dropColumn('catalogotramite_id');
            $table->dropColumn('monto_maximo');
            $table->dropColumn('monto_minimo');
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
        });
    }
}
