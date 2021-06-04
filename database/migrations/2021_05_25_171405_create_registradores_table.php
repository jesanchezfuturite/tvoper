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
		Schema::create('portal.registradores', function(Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->string('instituciones_id');
            $table->string('municipios_id');
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
		Schema::drop('portal.registradores');
	}
}
