<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperVistapagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         \DB::statement("CREATE 
            ALGORITHM = UNDEFINED 
            DEFINER = `externo`@`%` 
            SQL SECURITY DEFINER
        VIEW `operacion`.`oper_vistapagos` AS
            SELECT 
                LEFT(USER(), LOCATE('@', USER()) - 1) AS `usuario`,
                `operacion`.`oper_transacciones`.`entidad` AS `entidad`,
                `operacion`.`oper_transacciones`.`referencia` AS `referencia`,
                `operacion`.`oper_transacciones`.`id_transaccion_motor` AS `id_transaccion_motor`,
                `operacion`.`oper_transacciones`.`id_transaccion` AS `id_transaccion`,
                `operacion`.`oper_transacciones`.`estatus` AS `estatus`,
                `operacion`.`oper_transacciones`.`importe_transaccion` AS `Total`,
                `operacion`.`oper_metodopago`.`nombre` AS `MetododePago`,
                `operacion`.`oper_banco`.`nombre` AS `Banco`,
                `operacion`.`oper_transacciones`.`fecha_transaccion` AS `FechaTransaccion`,
                `operacion`.`oper_transacciones`.`fecha_pago` AS `FechaPago`,
                DATE_FORMAT(CONCAT(`operacion`.`oper_processedregisters`.`year`,
                                '-',
                                `operacion`.`oper_processedregisters`.`month`,
                                '-',
                                `operacion`.`oper_processedregisters`.`day`),
                        '%d-%m-%y') AS `FechaConciliacion`
            FROM
                (((`operacion`.`oper_transacciones`
                JOIN `operacion`.`oper_metodopago` ON (`operacion`.`oper_transacciones`.`metodo_pago_id` = `operacion`.`oper_metodopago`.`id`))
                LEFT JOIN `operacion`.`oper_banco` ON (`operacion`.`oper_transacciones`.`banco` = `operacion`.`oper_banco`.`id`))
                LEFT JOIN `operacion`.`oper_processedregisters` ON (`operacion`.`oper_transacciones`.`id_transaccion_motor` = `operacion`.`oper_processedregisters`.`transaccion_id`))
            WHERE
                `operacion`.`oper_transacciones`.`estatus` = 0
                    AND `operacion`.`oper_transacciones`.`entidad` IN (SELECT 
                        `operacion`.`oper_usuariobd_entidad`.`id_entidad`
                    FROM
                        `operacion`.`oper_usuariobd_entidad`
                    WHERE
                        `operacion`.`oper_usuariobd_entidad`.`usuariobd` = LEFT(USER(), LOCATE('@', USER()) - 1))
            ORDER BY `operacion`.`oper_transacciones`.`id_transaccion_motor` DESC");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oper_vistapagos');
    }
}
