<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRegistradoresTable.
 */
class CreateRegistradoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registradores', function(Blueprint $table) {
            $table->increments('id');
            $table->increments('descripcion');
            $table->increments('instituciones_id');
            $table->increments('municipios_id');
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
		Schema::drop('registradores');
	}
}
