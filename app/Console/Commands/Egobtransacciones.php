<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;

class Egobtransacciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conciliacion:egobt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    // declaro la variable para el repositorio
    protected $pr, $tr; 

    // npregisters
    protected $registers;

    // arrays to process 
    protected $valid, $ad, $ane, $transacciones_relacionadas, $temporal, $discarted;

    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        EgobiernotransaccionesRepositoryEloquent $tr
    )
    {
        parent::__construct();
        // instancia del repositorio para guardar los valores de los archivos
        $this->pr = $pr;
        // inicio el repositorio de transacciones en egobierno
        $this->tr = $tr;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        // 
        Log::info('[Conciliacion:EgobTransacciones] - Inicia el proceso para revisar las transacciones np');

        $this->loadRegisters();

        $this->checkBalanceRegisters();

        // verificar si existen todos los movimientos de los archivos en la base de datos
        $responseTransactions = $this->checkTransactions();
        
        // verificar los montos de las operaciones
        $responseAmounts = $this->validateAmount();

        // obtener los registros que van actualizar la tabla de transacciones con estatus 0
        $reponseValidated = $this->getValidated();

        Log::info('[Conciliacion:EgobTransacciones] - Proceso Finalizado');
    }

    /**
     * Buscar las transacciones que tengan status np.
     *
     * @param null
     *
     *
     * @return create a global array with the info transaccion_id, monto
     */

    private function loadRegisters()
    {
        try{
            Log::info('[Conciliacion:EgobTransacciones] @loadRegisters - Obtener registros pendientes a procesar');
            $this->registers = $this->pr->findWhere( ['status' => 'np', 'origen' => 1] );    
        }catch( \Exception $e ){
            Log::info('[Conciliacion:EgobTransacciones] @loadRegisters - Error ' . $e->getMessage());
        }  

    }

    /**
     * Revisar los montos de las transacciones y que existan en egobierno.transacciones .
     *
     * @param null
     *
     *
     * @return create arrays with errors and success transactions
     */

    private function checkBalanceRegisters()
    {
        // cargar en el arreglo temporal
        Log::info('[Conciliacion:EgobTransacciones] @checkBalanceRegisters - Crear arreglo temporal para busqueda');
        
        foreach($this->registers as $obj)
        {
            $this->temporal []= $obj->transaccion_id;
        }

        // buscar en egobierno todas las transacciones que vamos a conciliar
        try
        {
            $this->transacciones_relacionadas = $this->tr->findWhereIn( 
                'idTrans', 
                $this->temporal, 
                [ 'idTrans', 'TotalTramite', 'CostoMensajeria', 'Status' ] 
            );
        }catch( \Exception $e ){
            Log::info('[Conciliacion:EgobTransacciones] @checkBalanceRegisters - Error al buscar transacciones en Egobierno - ' . $e->getMessage());    
        }

    }



    /**
     * Checar si existe la transaccion .
     *
     * @param null
     *
     *
     * @return create arrays with errors and success transactions
     */

    private function checkTransactions()
    {
        // en $this->temporal estan todas las transacciones pendientes las voy a buscar en transacciones_relacionadas
        // cargar en el arreglo temporal
        Log::info('[Conciliacion:EgobTransacciones] @checkTransactions - Revisar que existan los registros de los archivos de conciliacion en la Base de Datos Egobierno.Transacciones');
        foreach($this->transacciones_relacionadas as $tr)
        {
            $encontrados []= $tr->idTrans;
        }

        // en el arreglo encontrados debo de buscar cada elemento de temporal sino existen entonces es una anomalia

        foreach($this->temporal as $tm)
        {
            if(!in_array($tm, $encontrados))
            {
                $this->ad []        = $tm;
                $this->discarted [] = $tm;
            }
        }

        return true;
    }

    /**
     * Checar si existe la transaccion .
     *
     * @param null
     *
     *
     * @return create arrays with errors and success transactions
     */

    private function validateAmount()
    {  
        // en $this->temporal estan todas las transacciones pendientes las voy a buscar en transacciones_relacionadas
        Log::info('[Conciliacion:EgobTransacciones] @validateAmount - Revisar que existan los montos de los registros de los archivos de conciliacion coincidan con  Base de Datos Egobierno.Transacciones');
        foreach($this->transacciones_relacionadas as $tr)
        {
            $encontrados [$tr->idTrans]= (float)$tr->TotalTramite + (float)$tr->CostoMensajeria;
        }

        // revisar los montos en registers
        foreach($this->registers as $r)
        {
            if( $encontrados[$r->transaccion_id] != $r->amount )
            {
                // esta es la anomalia de los montos
                $this->ane [$r->transaccion_id]= array( 
                        "message"           => "Montos diferentes", 
                        "monto_egobierno"   =>  $encontrados[$r->transaccion_id],
                        "monto_archivos"    =>  $r->amount; 
                ); 
                $this->discarted [] = $r->transaccion_id;
            }

        }

        return true;

    }

    /**
     * Crear el arreglo para hacer el update de la tabla de transacciones .
     *
     * @param null
     *
     *
     * @return create arrays with errors and success transactions
     */

    private function getValidated()
    { 
        Log::info('[Conciliacion:EgobTransacciones] @getValidated - Obtener todos los registros que son validos en los archivos de conciliacion');
        foreach($this->registers as $r)
        {
            if(!in_array($r->transaccion_id, $discarted))
            {
                $this->valid []= $r->transaccion_id;
            }
        }

        return true;
    } 
}
