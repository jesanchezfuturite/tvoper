<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOperBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_banco', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->longText('nombre');
            $table->longText('url_logo');
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
        Schema::table('oper_banco', function (Blueprint $table) {
            //
            Schema::dropIfExists('oper_banco');
        });
    }
}
