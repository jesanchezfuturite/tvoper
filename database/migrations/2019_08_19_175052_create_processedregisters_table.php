<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProcessedregistersTable.
 */
class CreateProcessedregistersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oper_processedregisters', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('transaccion_id');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->float('monto');
            $table->enum('status', ['p', 'np']);
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
		Schema::drop('processedregisters');
	}
}
