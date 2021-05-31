<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Http\Requests;
use Illuminate\Http\Request;
use SoapClient;
use GuzzleHttp\Client;
class Operaciontransacciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conciliacion:operaciont';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Concilia los movimientos que estan en oper_transacciones del nuevo modulo de operacion';

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
    protected $valid, $ad = array(), $ane = array(), $transacciones_relacionadas, $temporal, $discarted = array();

    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        TransaccionesRepositoryEloquent $tr
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
        Log::info('[Conciliacion:OperTransacciones] - Inicia el proceso para revisar las transacciones np');

        // obtener todos los registros para realizar las comparaciones
        $this->loadRegisters();

        $this->checkBalanceRegisters();

        // verificar si existen todos los movimientos de los archivos en la base de datos
        $responseTransactions = $this->checkTransactions();

        if($responseTransactions ==  true)
        {
            // verificar los montos de las operaciones
            $responseAmounts = $this->validateAmount();

            // obtener los registros que van actualizar la tabla de transacciones con estatus 0
            $reponseValidated = $this->getValidated();

            // actualizar los registros en la tabla de egobierno Transacciones
            $actualizarTransacciones = $this->udpdateTransactionsAsProcessed();    
        }else{
            Log::info('[Conciliacion:OperTransacciones] - No existen referencias del repositorio por validar');    

            /* aqui todos los registros de $temporal se actualizan con estatus */
        }
        // actualizar los errores en la tabla de process
        Log::info('[Conciliacion:OperTransacciones] - Proceso Finalizado');
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
            Log::info('[Conciliacion:OperTransacciones] @loadRegisters - Obtener registros pendientes a procesar');
            $this->registers = $this->pr->findWhere( 
                [
                    'status' => 'np', 
                    ['origen','>','1']
                ] 
            ); 
            if($this->registers->count() == 0 )
            {
               Log::info('[Conciliacion:EgobTransacciones] @loadRegisters NADA QUE PROCESAR');
               exit(); 
            }      
        }catch( \Exception $e ){
            Log::info('[Conciliacion:OperTransacciones] @loadRegisters - Error ' . $e->getMessage());
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
        Log::info('[Conciliacion:OperTransacciones] @checkBalanceRegisters - Crear arreglo temporal para busqueda');
        
        foreach($this->registers as $obj)
        {
            $this->temporal []= $obj->referencia;
        }

        // buscar en egobierno todas las transacciones que vamos a conciliar
        try
        {
            $this->transacciones_relacionadas = $this->tr->findWhereIn( 
                'referencia', 
                $this->temporal);
        }catch( \Exception $e ){
            Log::info('[Conciliacion:OperTransacciones] @checkBalanceRegisters - Error al buscar transacciones en Egobierno - ' . $e->getMessage());    
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
        Log::info('[Conciliacion:OperTransacciones] @checkTransactions - Revisar que existan los registros de los archivos de conciliacion en la Base de Datos Egobierno.Transacciones');


        if($this->transacciones_relacionadas->count() > 0)
        {
            foreach($this->transacciones_relacionadas as $tr)
            {
                $encontrados []= $tr->referencia;
            }

            // en el arreglo encontrados debo de buscar cada elemento de temporal sino existen entonces es una anomalia

            foreach($this->temporal as $tm)
            {
                if(!in_array($tm, $encontrados))
                {
                    $this->ane []        = $tm; // ANE => anomalia no existe
                    $this->discarted []  = $tm;
                }
            }

            return true;    
        }else{
            return false;
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

    private function validateAmount()
    {  
        // en $this->temporal estan todas las transacciones pendientes las voy a buscar en transacciones_relacionadas
        Log::info('[Conciliacion:OperTransacciones] @validateAmount - Revisar que existan los montos de los registros de los archivos de conciliacion coincidan con  Base de Datos Egobierno.Transacciones');
        foreach($this->transacciones_relacionadas as $tr)
        {
            $encontrados [$tr->referencia]= (float)$tr->importe_transaccion ;
        }


        // revisar los montos en registers
        foreach($this->registers as $r)
        {
            foreach($encontrados as $ref => $amount_found)
            {
                if($ref == $r->referencia)
                {
                    if($amount_found != $r->monto)
                    {
                         // esta es la anomalia de los montos ad = ANOMALIA DIFERENCIA
                        $this->ad []= $r->referencia; 

                        $this->discarted [] = $r->referencia;
                    }
                }
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
    
        Log::info('[Conciliacion:OperTransacciones] @getValidated - Obtener todos los registros que son validos en los archivos de conciliacion');
        foreach($this->registers as $r)
        {   
            if(count($this->discarted))
            {

                if(!in_array($r->referencia, $this->discarted))
                {
                    $this->valid []= $r->referencia;
                }    
            }else{

                $this->valid []= $r->referencia;
            }
        }
        return true;
    
    } 

    /**
     * Actualizar la tabla de transacciones como procesado .
     *
     * @param null
     *
     *
     * @return true
     */

    private function udpdateTransactionsAsProcessed()
    { 
        // actualizar la tabla egobierno
        Log::info('[Conciliacion:OperTransacciones] @udpdateTransactionsAsProcessed - Actualizar egobierno');


        #$egob = $this->tr->updateStatusInArray($this->valid);
        // actualizar con los registros que se procesaron correctamente
        //log::info($this->valid);
        try{

            $oper = $this->pr->updateStatusPerReferenceTo($this->valid,"p");
            $updateoper = $this->tr->updateStatusReferenceStatus60($this->valid);
            $updateoper2 = $this->tr->updateStatusReferenceStatus65($this->valid);
            //log::info($this->valid);
            $this->updateFechPago($this->valid);
            $this->referencepayment($this->valid);

        }catch( \Exception $e ){
            dd($e->getMessage());
        }
        if(count($this->ad))
        {
            // actualizar con los registros que tienen error diferencia de montos
            $oper = $this->pr->updateStatusPerReferenceTo($this->ad,"ad");   
        }

        if(count($this->ane))
        {
            // actualizar con los registros que tienen error no existen en transacciones de egobierno
            $oper = $this->pr->updateStatusPerReferenceTo($this->ane,"ane");   
        }

        
    }
    private function updateFechPago($refencias)
    {
        $findSinFechaPago=$this->tr->findTransaccionesFechaPago($refencias);
        
        //log::info("inicia consulta");
        if($findSinFechaPago<>null)
        {
            foreach ($findSinFechaPago as $k) {
                $fecha=$k->year . '-' . $k->month . '-' . $k->day;
                $optr=$this->tr->updatefechaPago($k->referencia,$fecha,$k->banco,$k->cuenta_banco);
                //log::info($fecha);
            }
        }
        //log::info("termina consulta");
    }
    private function referencepayment($referencia)
    {
         try{
            log::info("REFERENCEPAYMENT Conciliacion referencias: ".$referencia);
            foreach ($referencia as $i) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env("REFERENCEPAYMENT_HOSTNAME")."/"."$i"."?service=conciliacion");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                //curl_setopt($ch, CURLOPT_POSTFIELDS,);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec($ch);
                curl_close ($ch);
                $response =json_decode($remote_server_output);
                log::info("REFERENCEPAYMENT Conciliacion Respuesta: ".$remote_server_output);
            }
           
        }
        catch(\Exception $e) {
            Log::info('Command conciliacion:operaciont - referencepayment: '.$e->getMessage());
        }
    }  

    
}
