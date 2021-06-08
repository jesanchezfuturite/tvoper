<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperacionUsuariosEstatusTable.
 */
class CreateOperacionUsuariosEstatusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oper_usuarios_estatus', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('id_usuario');
            $table->string('estatus',255);
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
		Schema::drop('oper_usuarios_estatus');
	}
}
