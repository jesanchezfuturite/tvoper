<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServClaveSgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_clave_sg', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usuario',50);
            $table->string('Password',15);
            $table->string('dependencia',80);
            $table->string('nombre',45);
            $table->string('apellido_paterno',45);
            $table->string('apellido_materno',45);
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('serv_clave_sg');
    }
}
