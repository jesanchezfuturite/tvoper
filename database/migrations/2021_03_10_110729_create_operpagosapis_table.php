<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperpagosapisTable.
 */
class CreateOperpagosapisTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oper_pagos_api', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('transacciones_id');
			$table->integer('id_transaccion_motor');
			$table->integer('id_transaccion');
			$table->integer('estatus');
			$table->integer('entidad');
			$table->string('referencia',100);
			$table->string('Total',100);
			$table->string('MetododePago',100);
			$table->string('cve_Banco',100);
			$table->string('FechaTransaccion',100);
			$table->string('FechaPago',100);
			$table->string('FechaConciliacion',100);
			$table->integer('procesado');
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
		Schema::drop('oper_pagos_api');
	}
}
