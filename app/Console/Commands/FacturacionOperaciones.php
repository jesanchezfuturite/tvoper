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
    protected $referencias;

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

        if($response == 0){
            Log::info("No es posible insertar en las tablas de facturacion");
            exit();
        }


        Log::info("Fin del proceso");


    }


    /**
     * obtenerPendientes(). Este metodo obteniene todos los registros marcados como processed, tipo repositorio y facturado = 0
     *
     * @param null
     *
     *   
     * @return mixed
     */
    private function obtenerPendientes()
    {
        // $info = $this->pr->findWhere(
        //     [
        //         "facturado" => 0,
        //         "origen"    => 11,
        //         "status"   => 'p',
        //     ],
        //     [
        //         'referencia'
        //     ]
        // );

        // $info = $this->pr->whereIn("origen",[5,11])->where(
        //     [
        //         "facturado" => 1,
        //         "status"    => 'p',
        //         "referencia" => '050000205513555555555529481215'
        //     ]
        // );

        $info = $this->pr->select(['referencia'])->whereIn("origen",[5,11])->where(
            [
                "facturado" => 0,
                "status"    => 'p'
            ]
        )->distinct()->get();

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
                            $tramite_info = array(
                                'id_tramite_motor'          => $t->id_tramite_motor,
                                'id_transaccion_motor'      => $t->id_transaccion_motor,
                                'nombre_factura'            => $t->nombre_factura,
                                'apellido_paterno_factura'  => $t->apellido_paterno_factura,
                                'apellido_materno_factura'  => $t->apellido_materno_factura,
                                'razon_social_factura'      => $t->razon_social_factura,
                                'rfc_factura'               => $t->rfc_factura,
                                'curp_factura'              => $t->curp_factura,
                                'email_factura'             => $t->email_factura,
                                'calle_factura'             => $t->calle_factura,
                                'colonia_factura'           => $t->colonia_factura,
                                'numexteior_factura'        => $t->numexteior_factura,
                                'numinterior_factura'       => $t->numinterior_factura,
                                'municipio_factura'         => $t->municipio_factura,
                                'codigopostal_factura'      => $t->codigopostal_factura,
                                'numexterior_factura'       => $t->numexterior_factura
                            );

                            $info_detalles = $this->detalle_tramite->findWhere([ 'id_tramite_motor' => $t->id_tramite_motor ]);
                            $dt = array();
                            if($info_detalles->count())
                            {

                                foreach($info_detalles as $id)
                                {   
                                    $dt []= array(
                                        'id_detalle_tramite'    => $id->id_detalle_tramite,
                                        'concepto'              => $id->concepto,
                                        'importe_concepto'      => $id->importe_concepto,
                                        'partida'               => $id->partida,
                                        'id_transaccion_motor'  => $id->id_transaccion_motor,
                                        'id_tramite_motor'      => $id->id_tramite_motor,
                                        'importe_descuento'     => $id->importe_descuento,
                                        'id_descuento'          => $id->id_descuento
                                    );
                                }
                                
                            }
                            
                            $tramites []= array(
                                'info' => $tramite_info, 
                                'detalles' => $dt
                            );
                        }  
                    }

                    $full []= array(
                        "transaccion"   => array(
                                'referencia'            => $it->referencia,
                                'id_transaccion_motor'  => $it->id_transaccion_motor,
                                'fecha_transaccion'     => $it->fecha_transaccion,
                                'importe_transaccion'   => $it->importe_transaccion,
                                'metodo_pago_id'        => $it->metodo_pago_id, 
                            ),
                        "tramites"      => $tramites
                    );
                }   
                
            }

        }

        $this->full_info = $full;

        return 1;
    }

    /**
     * escribirFacturas(). en este metodo inserto en las tablas de gestor y marco las referencias como facturadas en processedregisters
     *
     * @param null
     *
     *   
     * @return mixed
     */
    private function escribirFacturas()
    {
        /* los registros  */
        $refs = array();

        foreach ($this->full_info as $full) 
        {
            // obtengo los registros para insertar la transaccion

            $transaccion = $full["transaccion"];

            $i_transaccion = array(
                "folio_unico"           => $transaccion['referencia'],
                "fecha_transaccion"     => $transaccion['fecha_transaccion'],
                "template_id"           => "1",
                "tipo_documento"        => "I",
                "total_transaccion"     => $transaccion['importe_transaccion'],
                "forma_de_pago"         => "PAGO EN UNA SOLA EXHIBICION",
                "descuento"             => "0.00",
                "subtotal"              => $transaccion['importe_transaccion'],
                "total"                 => $transaccion['importe_transaccion'],     
                "metodo_de_pago"        => "99",
                "numero_de_cuenta"      => "",
                "motivo_descuento"      => "ND",
                "lugar_expedicion"      => "1" ,
                "rfc_receptor"          => "",
                "fecha_registro"        => date("Y-m-d H:i:s")               
            );

            // obtener la info de tramite
            $tramites = $full["tramites"];

            // try
            // {
            //     $en = $this->encabezados->create( $i_transaccion );
            //     $refs[]= $transaccion['referencia'];

            //     foreach($tramites as $t)
            //     {
            //         // obtener los detalles
            //         $detalles = $t["detalles"];
            //         $info = $t["info"];
            //         $i_detalles = array();

            //         foreach($detalles as $d)
            //         {   
            //             $i_detalles = array(
            //                 "folio_unico"       => $transaccion['referencia'],
            //                 "cantidad"          => "1",
            //                 "unidad"            => "SERVICIO",      
            //                 "concepto"          => utf8_decode($d["concepto"]),
            //                 "precio_unitario"   => !empty((int)$d["id_descuento"]) ? ($d["importe_concepto"]*-1) : $d["importe_concepto"],
            //                 "importe"           => !empty((int)$d["id_descuento"]) ? ($d["importe_concepto"]*-1) : $d["importe_concepto"],
            //                 "partida"           => $d["partida"],
            //                 "fecha_registro"    => date("Y-m-d H:i:s"),
            //                 "num_identificacion"=> !empty((int)$d["id_descuento"]) ? $d["id_descuento"]."|"."0" : $d["id_detalle_tramite"]."|"."0",
            //                 "id_oper"           => $d["id_transaccion_motor"],
            //                 "id_mov"            => $d["id_tramite_motor"],
            //                 "st_gen"            => "0",
            //                 "st_doc"            => "0",
            //                 "info"              => json_encode($info)
            //             );

            //             try
            //             {
            //                 // insertar los registros de detalles de la transaccion
            //                 // $o = $this->detalle->insert( $i_detalles );

            //                 $has = $this->detalle->findWhere(["id_mov" => $d["id_tramite_motor"], "id_oper" => $d["id_transaccion_motor"]]);
            //                 $dcount = $has->count();
                            
            //                 if ((int)$dcount == 0) {
            //                     /* no existe */
            //                     $this->detalle->create( $i_detalles );                                
            //                 } 

            //             }catch( \Exception $e ){
            //                 Log::info("FacturacionOperaciones@escribirFacturas - ERROR al insertar detalles de la factura " . $e->getMessage());
            //             }      
            //         }                              
            //     }

            // }catch( \Exception $e ){
            //     Log::info("FacturacionOperaciones@escribirFacturas - ERROR al insertar encabezados " . $e->getMessage());
            // }
            
            foreach($tramites as $t)
            {
                // obtener los detalles
                $detalles = $t["detalles"];
                $info = $t["info"];
                $i_detalles = array();

                foreach($detalles as $d)
                {   
                    $i_detalles = array(
                        "folio_unico"       => $transaccion['referencia'],
                        "cantidad"          => "1",
                        "unidad"            => "SERVICIO",      
                        "concepto"          => utf8_decode($d["concepto"]),
                        "precio_unitario"   => !empty((int)$d["id_descuento"]) ? ($d["importe_concepto"]*-1) : $d["importe_concepto"],
                        "importe"           => !empty((int)$d["id_descuento"]) ? ($d["importe_concepto"]*-1) : $d["importe_concepto"],
                        "partida"           => $d["partida"],
                        "fecha_registro"    => date("Y-m-d H:i:s"),
                        "num_identificacion"=> !empty((int)$d["id_descuento"]) ? $d["id_descuento"]."|"."0" : $d["id_detalle_tramite"]."|"."0",
                        "id_oper"           => $d["id_transaccion_motor"],
                        "id_mov"            => $d["id_tramite_motor"],
                        "st_gen"            => "0",
                        "st_doc"            => "0",
                        "info"              => json_encode($info)
                    );

                    try
                    {
                        // insertar los registros de detalles de la transaccion                        
                        $this->detalle->create( $i_detalles );

                    }catch( \Exception $e ){
                        Log::info("FacturacionOperaciones@escribirFacturas - ERROR al insertar detalles de la factura " . $e->getMessage());
                    }      
                }                          
            }

            $refs[]= $transaccion['referencia'];
            
            try
            {
                $en = $this->encabezados->create( $i_transaccion );

            }catch( \Exception $e ){
                Log::info("FacturacionOperaciones@escribirFacturas - ERROR al insertar encabezados " . $e->getMessage());
            }
        }
        
        /* actualizar las referencias como facturadas */
        try
        {   
            foreach($refs as $r)
            {
                $pr = $this->pr->where('referencia', $r)->update(['facturado' => 1]);
            }
            
        }catch( \Exception $e ){
            Log::info("FacturacionOperaciones@escribirFacturas - ERROR al actualizar facturados " . $e->getMessage());
        }


        return 1;

    }


}
