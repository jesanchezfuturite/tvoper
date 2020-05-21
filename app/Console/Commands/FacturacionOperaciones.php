<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use App\Repositories\ProcessedregistersRepositoryEloquent;

use App\Repositories\CfdiEncabezadosRepositoryEloquent;
use App\Repositories\CfdiDetalleRepositoryEloquent;
// oper detalle tramite
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\TramitesRepositoryEloquent;
use App\Repositories\DetalletramiteRepositoryEloquent;



class FacturacionOperaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facturacion:operaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este command inserta los datos necesarios de las operaciones que se van a facturar por referencias emitidas en el nuevo WS';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    // repos
    protected $pr;
    protected $encabezados;
    protected $detalle;
    protected $transacciones;
    protected $tramite;
    protected $detalle_tramite;

    // control variables
    protected $pending; // esta es para almacenar el total de pendientes a facturar;
    protected $full_info; // aqui voy a guardar los datos para insertar en cada tabla


    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        CfdiEncabezadosRepositoryEloquent $encabezados,
        CfdiDetalleRepositoryEloquent $detalle,
        TransaccionesRepositoryEloquent $transacciones,
        TramitesRepositoryEloquent $tramite,
        DetalletramiteRepositoryEloquent $detalle_tramite
    )
    {
        parent::__construct();

        $this->pr               = $pr;
        $this->encabezados      = $encabezados;
        $this->detalle          = $detalle;
        $this->transacciones    = $transacciones;
        $this->tramite          = $tramite;
        $this->detalle_tramite  = $detalle_tramite;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Log::info("Modulo de facturacion");

        Log::info("Leer pendientes de facturar");
        $response = $this->obtenerPendientes();  

        if($response == 0){
            Log::info("No existen registros pendientes de facturar");
            exit();
        }

        Log::info("Completar datos de la transaccion");
        $response = $this->obtenerDatos();  

        if($response == 0){
            Log::info("No existen registros pendientes de facturar");
            exit();
        }

        Log::info("Escribir en las tablas de gestor CFDI");
        $response = $this->escribirFacturas();

        Log::info("Fin del proceso");


    }


    /**
     * obtenerPendietes(). Este metodo obteniene todos los registros marcados como processed, tipo repositorio y facturado = 0
     *
     * @param null
     *
     *   
     * @return mixed
     */
    private function obtenerPendientes()
    {
        $info = $this->pr->findWhere(
            [
                "facturado" => 0,
                "origen"    => 11,
                "status"   => 'p'
            ],
            [
                'referencia'
            ]
        );

        if($info->count() > 0)
        {
            $this->pending = $info;
            return 1;
        }else{
            $this->pending = false;
            return 0;
        }


    }

    /**
     * obtenerDatos(). Este metodo obteniene los datos de los registros a facturar
     *
     * @param null // lee el contenido directo del cast
     *
     *   
     * @return mixed
     */

    private function obtenerDatos()
    {
        $full = array();
        
        $request_data_transacciones = array(
            'referencia',
            'id_transaccion_motor',
            'fecha_transaccion',
            'importe_transaccion',
            'metodo_pago_id',
        );

        $request_data_detalle_tramite = array(
            'concepto',
            'importe_concepto',
            'partida',
            'id_transaccion_motor',
            'id_tramite_motor'
        );

        $request_data_tramite = array(
            'id_tramite_motor',
            'id_transaccion_motor',
            'nombre_factura',
            'apellido_paterno_factura',
            'apellido_materno_factura',
            'razon_social_factura',
            'rfc_factura',
            'curp_factura',
            'email_factura',
            'calle_factura',
            'colonia_factura',
            'numexteior_factura',
            'numinterior_factura',
            'municipio_factura',
            'codigopostal_factura',
            'numexterior_factura'
        );

        foreach($this->pending as $p)
        {   
            //obtener datos que necesito de transacciones
            $info_transacciones = $this->transacciones->findWhere( [ 'referencia' => $p->referencia ] , $request_data_transacciones );

            if($info_transacciones->count() > 0)
            {
                foreach($info_transacciones as $it)
                {
                    $tramites = array();
                    
                    //obtener info de detalle_tramite
                    $info_tramite = $this->tramite->findWhere( [ 'id_transaccion_motor' => $it->id_transaccion_motor ] , $request_data_tramite );

                    if($info_tramite->count() > 0)
                    {
                        foreach($info_tramite as $t)
                        {
                            $tramites []= array(
                                'info' => $t, 
                                'detalles' => $this->detalle_tramite->findWhere([ 'id_tramite_motor' => $t->id_tramite_motor ])
                            );
                        }  
                    }

                    $full []= array(
                        "transaccion"   => $it,
                        "tramites"      => $tramites
                    );
                }   
                
            }

        }

        $this->full_info = $full;

        return 1;
    }

    /**
     * escribirFacturas(). Este metodo inserta todos los datos para facturar y cambia el estatus en la tabla de processedregisters
     *
     * @param null
     *
     *   
     * @return mixed
     */
    private function escribirFacturas()
    {
        
        Log::info($this->full_info);

    }


}
