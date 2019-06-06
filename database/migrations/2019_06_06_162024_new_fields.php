<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oper_administrators', function (Blueprint $table) {
            //
            $table->longtext('menu')->after('name');
            $table->longtext('extra')->after('name');
            $table->integer('is_admin')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oper_administrators', function (Blueprint $table) {
            //
            $table->dropColumn('menu');
            $table->dropColumn('extra');
            $table->dropColumn('is_admin');
        });
    }
}
