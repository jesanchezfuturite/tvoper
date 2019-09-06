<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use Illuminate\Database\Eloquent\Model;

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
        $this->UpdateStatusTransaccion();
        //log::info('---------------------Prueba Status--------------');
    }
    public function UpdateStatusTransaccion()
    {
        $fechaActual=Carbon::now()->subDay(1);
        $date=$fechaActual->format('Y-m-d');
        $limite=$date." "."00:00:00";
        try{  
        $find_oper = $this->oper_transaccionesdb->updateTransacciones(['estatus'=>'65'],['estatus'=>'60','fecha_limite_referencia'=>$limite]);

        Log::info("update from oper_transacciones set estatus=65 where estatus=60 and fecha_limite_referencia=".$limite);Log::info("Resgitros Actualizados: ".$find_oper);
        } catch( \Exception $e ){
            Log::info('Error console/updateStatus-> Method UpdateStatusTransaccion: '.$e->getMessage());
       
        }
        //log::info($limite);

    }
}
