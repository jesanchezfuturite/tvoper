<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


use App\Repositories\PagossolicitudRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\MetodopagoRepositoryEloquent;
use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\OperpagosapiRepositoryEloquent;



class Pagosas400 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'procesar:pagosas400';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este command envia la informacion de los pagos no procesados a una tabla para que AS400 actualice información';

    protected $transacciones;
    protected $pagosapi;
    protected $metodospago;
    protected $conciliacion;
    protected $pagossolicituddb;


    protected $list_mp;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        TransaccionesRepositoryEloquent $transacciones,
        OperpagosapiRepositoryEloquent $pagosapi,
        MetodopagoRepositoryEloquent $metodospago,
        ProcessedregistersRepositoryEloquent $conciliacion,
        PagossolicitudRepositoryEloquent $pagossolicituddb

    )
    {
        parent::__construct();

        // aqui esta la instancia de los repositorios
        $this->transacciones    = $transacciones;
        $this->pagosapi         = $pagosapi;
        $this->metodospago      = $metodospago;
        $this->conciliacion     = $conciliacion;
        $this->pagossolicituddb = $pagossolicituddb;

        $this->loadMetodosPago();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $last_register = $this->pagosapi->orderby('id_transaccion_motor','desc')->first();

        if(is_null($last_register))
        {
            // la tabla esta vacia llenamos con todos los registros, esto solo pasa la primera vez
            $this->fillTable();
        }else{
            $this->updateTable($last_register->id_transaccion_motor);
        }
    
    }


    /**
     * Actualizar la tabla, traer los pagos que no se han reportado.
     *
     * @return mixed
     */

    public function updateTable($last)
    {
        try{

            Log::info("[Pagosas400@updateTable]-Command para actualizar la tabla de pagos" );

            Log::info("[Pagosas400@updateTable]-Obtener todos los pagos ya realizados" );

            Log::info("[Pagosas400@updateTable]-obtener los que ya existen");
                 
            $registros = $this->transacciones
                ->where('estatus',0)
                ->where('id_transaccion_motor','>',$last)
                ->get();

            Log::info("[Pagosas400@updateTable]-Registros a buscar " . $registros->count() );

            if($registros->count() > 0){
                foreach($registros as $reg)
                {
                    $info = array(
                        'id_transaccion_motor'  => $reg->id_transaccion_motor,
                        'id_transaccion'        => $reg->id_transaccion,
                        'estatus'               => $reg->estatus,
                        'entidad'               => $reg->entidad,
                        'referencia'            => $reg->referencia,
                        'Total'                 => $reg->importe_transaccion,
                        'MetododePago'          => $this->list_mp[$reg->metodo_pago_id],
                        'cve_Banco'             => $reg->tipo_pago,
                        'FechaTransaccion'      => $reg->fecha_transaccion,
                        'FechaPago'             => $reg->fecha_pago,
                        'FechaConciliacion'     => $this->obtenerfechaConciliacion($reg->referencia),
                        'procesado'             => 0
                    );

                    //Log::info("[Pagosas400@updateTable]-Insertar pago" );
                    
                    if ($this->pagosapi->where('id_transaccion_motor', '=', $reg->id_transaccion_motor)->count() == 0) {

                        $this->pagosapi->create( $info );
                    
                    }    
                    

                }    
            }else{
                Log::info("[Pagosas400@updateTable]-No existen pagos sin procesar");
            }
    
        }catch(\Exception $e){
            Log::info("[Pagosas400@updateTable]-ERROR-".$e->getMessage());
            dd($e->getMessage());
        }
        Log::info("[Pagosas400@updateTable]-Proceso terminado");
    }


    /**
     * Llenar la tabla de oper_pagos_solicitud.
     *
     * @return mixed

    1,2,3,4,5,6,7,8,9,10
    *,*,*,*,-,-,*,-,-,--


     */

    public function fillTable()
    {
        try{

            Log::info("[Pagosas400@fillTable]-Esto sucede solo la primera vez que se ejecuta el command" );

            Log::info("[Pagosas400@fillTable]-Obtener todos los pagos ya realizados" );

            $registros = $this->transacciones->findWhere([ "estatus" => 0 ]);

            foreach($registros as $reg)
            {
                $info = array(
                    'id_transaccion_motor'  => $reg->id_transaccion_motor,
                    'id_transaccion'        => $reg->id_transaccion,
                    'estatus'               => $reg->estatus,
                    'entidad'               => $reg->entidad,
                    'referencia'            => $reg->referencia,
                    'Total'                 => $reg->importe_transaccion,
                    'MetododePago'          => $this->list_mp[$reg->metodo_pago_id],
                    'cve_Banco'             => $reg->tipo_pago,
                    'FechaTransaccion'      => $reg->fecha_transaccion,
                    'FechaPago'             => $reg->fecha_pago,
                    'FechaConciliacion'     => $this->obtenerfechaConciliacion($reg->referencia),
                    'procesado'             => 0
                );

                Log::info("[Pagosas400@fillTable]-Insertar pago" );
                $this->pagosapi->create( $info );

            }

            Log::info( "[Pagosas400@fillTable]-Consultar los que ya se procesaron" );

            $procesados = $this->pagossolicituddb->all();

            $up = array();
            foreach($procesados as $p)
            {
                $up []= $p->id_transaccion_motor;
            }

            Log::info( "[Pagosas400@fillTable]-Actualizar los procesados" );

            $this->pagosapi->whereIn('id_transaccion_motor',$up)->update(["procesado" => 1]);

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * loadMetodoPago. Regresa los metodos de pagos registrados en el sistema
     *
     * @param ninguna
     *
     * @return array()
     *
     */

    private function loadMetodosPago()
    {
        
        $res = array();

        $info = $this->metodospago->all();

        foreach($info as $i)
        {
            $res [$i->id]= $i->nombre;
        }
        $res [0]= "No Identificado";
        $this->list_mp = $res;
    }

    /**
     * obtenerfechaConciliacion. obtener la fecha en que se concilio un documento  
     *
     * @param entidad
     *
     * @return integer if 0 la entidad no existe
     *
     */
    private function obtenerfechaConciliacion($referencia)
    {   
        $info = $this->conciliacion->findWhere(
            [ "referencia" => $referencia ]
        );

        if($info->count() > 0){
            foreach($info as $i)
            {
                return $i->fecha_ejecucion;
            }
        }else{

            return "";
        }



    }

}
