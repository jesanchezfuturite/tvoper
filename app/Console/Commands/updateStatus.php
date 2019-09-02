<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use Illuminate\Support\Facades\DB;

class updateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateStatus:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estatus de las transacciones todos los dias al final del dia';
    protected $transaccionesdb;
    protected $oper_transaccionesdb;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        EgobiernotransaccionesRepositoryEloquent $transaccionesdb,
     TransaccionesRepositoryEloquent $oper_transaccionesdb)
    {
        parent::__construct();
        $this->transaccionesdb=$transaccionesdb;
        $this->oper_transaccionesdb=$oper_transaccionesdb;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->logPrueba();
        //log::info('---------------------Prueba Status--------------');
    }
    public function logPrueba()
    {
        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d');
        $limite=$date." "."00:00:00";
        //$find_oper = $this->oper_transaccionesdb->findWhere(['estatus'=>'60','fecha_limite_referencia'=>'2019-09-02 00:00:00']);
        $find_oper=;
        $countfind=$find_oper->count(); 
        log::info($countfind);
        log::info($limite);

       /*foreach ($find_oper as $i ) {
           $update_oper=$this->oper_transaccionesdb->updateTransacciones(['estatus'=>'65'],['id_transaccion_motor'=>$i->id_transaccion_motor])
       }*/
    }
}
