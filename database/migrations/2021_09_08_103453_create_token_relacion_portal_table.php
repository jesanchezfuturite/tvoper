<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTokenPortalTable.
 */
class CreateTokenRelacionPortalTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portal.token_relacion_portal', function(Blueprint $table) {
            $table->increments('id');
            $table->Integer('ticket_id');
			$table->Integer('token_id');
			$table->Integer('id_transaccion')->nullable();
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
		Schema::dropIfExists('portal.token_relacion_portal');
	}
}
