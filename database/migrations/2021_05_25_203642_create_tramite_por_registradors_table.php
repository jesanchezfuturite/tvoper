<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTramitePorRegistradorsTable.
 */
class CreateTramitePorRegistradorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tramites_por_registradors', function(Blueprint $table) {
            $table->increments('id');
            $table->string('registrador_id');
            $table->string('tramite_id');
			$table->string('region_id');
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
		Schema::drop('tramite_por_registradors');
	}
}
