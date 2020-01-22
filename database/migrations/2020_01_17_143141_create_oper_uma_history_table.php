<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperUmaHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oper_uma_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('daily',10,2);
            $table->decimal('monthly',10,2);
            $table->decimal('yearly',10,2);
            $table->year('year');
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
        Schema::dropIfExists('oper_uma_history');
    }
}
