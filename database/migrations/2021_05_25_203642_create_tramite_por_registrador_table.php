<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTramitePorRegistradorTable.
 */
class CreateTramitePorRegistradorTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.tramites_por_registrador', function(Blueprint $table) {
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
		Schema::drop('portal.tramites_por_registrador');
	}
}
