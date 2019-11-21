<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCortesolicitudsTable.
 */
class CreateCortesolicitudsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('corte_solicitud', function(Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_ejecucion');
            $table->integer('banco_id');
            $table->string('cuenta_banco',30);
            $table->string('cuenta_alias',30);
            $table->integer('status');
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
		Schema::drop('corte_solicitud');
	}
}
