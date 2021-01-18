<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperanomaliasesTable.
 */
class CreateOperanomaliasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oper_anomalias', function(Blueprint $table) {
            $table->increments('id');
            $table->string('referencia',50);
            $table->integer('origen');
            $table->bigInteger('transaccion_id');
            $table->string('monto');
            $table->integer('banco_id');
            $table->string('cuenta_banco',30);
            $table->string('cuenta_alias',30);
            $table->date('fecha_ejecucion');
            $table->date('fecha_pago');
			$table->integer('estatus_anomalia');
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
		Schema::drop('oper_anomalias');
	}
}
