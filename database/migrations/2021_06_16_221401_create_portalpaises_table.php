<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortalpaisesTable.
 */
class CreatePortalpaisesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.paises', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('catalog_key');
            $table->string('entidad_federativa',90);
            $table->string('abreviatura',2);
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
		Schema::drop('portal.paises');
	}
}
