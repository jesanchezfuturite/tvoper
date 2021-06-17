<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePortalvialidadesTable.
 */
class CreatePortalvialidadesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.vialidades', function(Blueprint $table) {
            $table->increments('id');
            $table->integer("fixed_id");
            $table->string("descripcion",100);
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
		Schema::drop('portal.vialidades');
	}
}
