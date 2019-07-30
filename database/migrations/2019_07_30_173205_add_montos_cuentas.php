<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMontosCuentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_cuentasbanco', function (Blueprint $table) {
            //
            $table->decimal('monto_min')->after('status');
            $table->decimal('monto_max')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oper_cuentasbanco', function (Blueprint $table) {
            //
        });
    }
}
