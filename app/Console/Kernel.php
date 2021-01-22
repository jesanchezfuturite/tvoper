<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\Conciliacion::class,
        Commands\Egobtransacciones::class,
        Commands\updateStatus::class,
        Commands\CorteSendEmail::class,
        Commands\SendEmails::class,
        Commands\FacturacionOperaciones::class,
        Commands\Estados::class,
        Commands\Municipios::class


    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* carga las tablas con los procesos de archivos */
        $schedule->command('conciliacion:processFiles')
                ->everyFiveMinutes();

        /* revisa que no existan anomalías en el proceso de conciliacion */
        $schedule->command('conciliacion:egobt')
                 ->everyFiveMinutes();

        /* revisa que no existan anomalías en el proceso de conciliacion */
        $schedule->command('conciliacion:operaciont')
                 ->everyFiveMinutes();

        /* este proceso manda a facturacion lo conciliado */
        $schedule->command('facturacion:operaciones')
               ->hourly();

        /*cambia el estatus de la transaccion todos los dias a las 03:00:00 hrs*/
        $schedule->command('updateStatus:status')
                //->everyMinute();
               ->dailyAt('03:00');

        /*  Genera el Archivo para corte y envia por correo  */
        $schedule->command('CorteSendEmail:SendEmail')
               ->everyFiveMinutes();
                /*->dailyAt('15:26');*/
        $schedule->command('SendEmails:EmailGrid')
               ->everyFiveMinutes();
               /*->dailyAt('15:26');*/

        /*Actualiza la tabla de estados cada semana*/ 
        $schedule->command('get:Estados')
        ->weekly();
        
        /*Actualiza la tabla de municipios cada semana*/ 
        $schedule->command('obtener:Municipios')
        ->weekly();

    }   

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
