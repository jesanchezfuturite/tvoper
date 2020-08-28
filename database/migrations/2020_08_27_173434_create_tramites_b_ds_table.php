<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTramitesBDsTable.
 */
class CreateTramitesBDsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tramites_b_ds', function(Blueprint $table) {
            $table->increments('id');
						$table->string('descripcion', 250);
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
		Schema::drop('tramites_b_ds');
	}
}
