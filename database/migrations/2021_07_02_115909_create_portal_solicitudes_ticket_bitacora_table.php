<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortalSolicitudesTicketBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal.solicitudes_ticket_bitacora', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_ticket');
            $table->Text('grupo_clave')->nullable();
            $table->bigInteger('id_estatus_atencion')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->longText('info')->nullable();
            $table->Text('mensaje')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('portal_solicitudes_ticket_bitacora');
    }
}
