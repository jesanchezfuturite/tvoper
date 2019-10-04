<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteOperVistapago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         \DB::statement("DROP VIEW [IF EXISTS] oper_vistapago;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oper_vistapago');
    }
}
