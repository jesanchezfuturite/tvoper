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
        $limite2=$date." "."23:59:59";
        $array=[];
        try{  
        $find_oper = $this->oper_transaccionesdb->updateTransacciones(['estatus'=>'65'],['estatus'=>'60','fecha_limite_referencia'=>$limite]);
        $find_ref = $this->oper_transaccionesdb->where('fecha_limite_referencia','>=',$limite)->where('fecha_limite_referencia','<=',$limite2)->get();
        foreach ($find_ref as $k) {
            array_push($array,$k->referencia);
        }
        
        $this->referencepayment($array);
            Log::info("update from oper_transacciones set estatus=65 where estatus=60 and fecha_limite_referencia=".$limite);
            Log::info("Resgitros Actualizados: ".$find_oper);

        } catch( \Exception $e ){
            Log::info('Error console/updateStatus-> Method UpdateStatusTransaccion: '.$e->getMessage());
       
        }
        //log::info($limite);

    }
     private function referencepayment($array)
    {
         try{

            $json=json_encode($array);
            $link = env("REFERENCEPAYMENT_HOSTNAME");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
           curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $jsonArrayResponse = curl_exec($ch);
            curl_close($ch);
            //log::info($jsonArrayResponse);
        }
        catch(\Exception $e) {
            Log::info('Command Operaciontransacciones - referencepayment: '.$e->getMessage());
        }
    }
}
