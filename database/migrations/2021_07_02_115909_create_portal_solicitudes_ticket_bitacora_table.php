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
            $table->Text('grupo_clave');
            $table->bigInteger('id_status_seguimiento');
            $table->bigInteger('user_id');
            $table->Text('mensaje')->nullable();
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
        Schema::dropIfExists('portal_solicitudes_ticket_bitacora');
    }
}
