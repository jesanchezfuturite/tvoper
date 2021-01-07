<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransaccionesRepository;
use App\Entities\Transacciones;
use App\Validators\TransaccionesValidator;
use Illuminate\Support\Facades\Log;

/**
 * Class TransaccionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TransaccionesRepositoryEloquent extends BaseRepository implements TransaccionesRepository
{
    protected $db='egobierno';
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transacciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function updateTransacciones($estatus,$id_transaccion_motor)
    {
        try{

            return Transacciones::where( $id_transaccion_motor )->update($estatus);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@updateTransacciones] Error ' . $e->getMessage());
        }       

    }
    public function consultaTransacciones($fechaIn,$fechaF)
    {
        try{
        $data = Transacciones::whereBetween('fecha_transaccion',[$fechaIn,$fechaF])
        ->leftjoin('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->leftjoin('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->leftjoin('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->leftjoin('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
        ->leftjoin($this->db . '.tipo_servicios',$this->db . '.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio')
        ->leftjoin($this->db . '.tipopago',$this->db . '.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        ->leftjoin($this->db . '.status',$this->db . '.status.Status','=','oper_transacciones.estatus')     
        ->select($this->db . '.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad',$this->db . '.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion',$this->db . '.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite',$this->db . '.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia','oper_transacciones.referencia','oper_transacciones.id_transaccion_motor','oper_processedregisters.id')
        ->groupBy('oper_transacciones.id_transaccion_motor')
        ->get();
        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaTransacciones] Error ' . $e->getMessage());
        }      
    }
    public function consultaTransaccionesWhere($fechaIn,$fechaF,$rfc)
    {
        try{        
        $data = Transacciones::whereBetween('fecha_transaccion',[$fechaIn,$fechaF])
        ->leftjoin($this->db . '.status',$this->db . '.status.Status','=','oper_transacciones.estatus')
        ->leftjoin('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->leftjoin('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->leftjoin('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->leftjoin('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->leftjoin($this->db . '.tipo_servicios',$this->db . '.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio') 
        ->leftjoin($this->db . '.tipopago',$this->db . '.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
        ->where($rfc)     
        ->select($this->db . '.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad',$this->db . '.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion',$this->db . '.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite',$this->db . '.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia','oper_transacciones.referencia','oper_transacciones.id_transaccion_motor','oper_processedregisters.id')
        ->groupBy('oper_transacciones.id_transaccion_motor')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaTransaccionesWhere] Error ' . $e->getMessage());
        }      
    }
    public function consultaFolioTransacciones($folio,$fechaIn,$fechaF)
    {
        try{        
        $data = Transacciones::where('oper_transacciones.id_transaccion_motor',$folio)
        ->leftjoin($this->db . '.status',$this->db . '.status.Status','=','oper_transacciones.estatus')
        ->leftjoin('oper_entidad','oper_entidad.id','=','oper_transacciones.entidad')
        ->leftjoin('oper_familiaentidad','oper_familiaentidad.entidad_id','=','oper_entidad.id')
        ->leftjoin('oper_familia','oper_familia.id','=','oper_familiaentidad.familia_id')
        ->leftjoin('oper_tramites','oper_tramites.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
        ->leftjoin($this->db . '.tipo_servicios',$this->db . '.tipo_servicios.Tipo_Code','=','oper_tramites.id_tipo_servicio') 
        ->leftjoin($this->db . '.tipopago',$this->db . '.tipopago.TipoPago','=','oper_transacciones.tipo_pago')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
         //->where('oper_transacciones.fecha_transaccion','>=',$fechaIn)           
        //->where('oper_transacciones.fecha_transaccion','<=',$fechaFin)        
        ->select($this->db . '.status.Descripcion as status','oper_transacciones.id_transaccion as idTrans','oper_entidad.nombre as entidad',$this->db . '.tipo_servicios.Tipo_Descripcion as tiposervicio','oper_tramites.nombre','oper_tramites.apellido_paterno','oper_tramites.apellido_materno','oper_transacciones.fecha_transaccion','oper_transacciones.banco as BancoSeleccion',$this->db . '.tipopago.Descripcion as tipopago','oper_transacciones.importe_transaccion as TotalTramite',$this->db . '.tipo_servicios.Tipo_Code as tiposervicio_id','oper_transacciones.estatus as estatus_id','oper_tramites.rfc as rfc','oper_familia.nombre as familia','oper_transacciones.referencia','oper_transacciones.id_transaccion_motor','oper_processedregisters.id')
        ->groupBy('oper_transacciones.id_transaccion_motor')
        ->get();

        return $data;
       
        }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@consultaFolioTransacciones] Error ' . $e->getMessage());
        }      
    }
    public function updateEnvioCorreo($estatus,$id_transaccion_motor)
    {
        try{

            return Transacciones::where( $id_transaccion_motor )->update($estatus);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@updateEnvioCorreo] Error ' . $e->getMessage());
        }       

    }
    public function ConsultaCorreo($estatus)
    {
        try{

            return Transacciones::where($estatus)->take(100);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@ConsultaCorreo] Error ' . $e->getMessage());
        }       

    }
    public function updateTransStatus($estatus)
    {
        try{

            return Transacciones::where( $referencia )->update($estatus);    
        
         }catch( \Exception $e){
            Log::info('[TransaccionesRepositoryEloquent@updateTransacciones] Error ' . $e->getMessage());
        }       

    }
    public function updateStatusReferenceStatus60($info)
    {
        try
        {
            $data = Transacciones::whereIn('referencia', $info)->where('estatus','=','60')->update( ['estatus' => '0']);

        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@updateStatusReferenceStatus60]  ERROR al actualizar las transacciones como procesadas");
            return false;
        }
    }
    public function updateStatusReferenceStatus65($info)
    {
        try
        {
            $data = Transacciones::whereIn('referencia', $info)->where('estatus','=','65')->update( ['estatus' => '0']);

        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@updateStatusReferenceStatus65]  ERROR al actualizar las transacciones como procesadas");
            return false;
        }
    }
    public function updatefechaPago($id,$fecha,$banco,$cuenta)
    {
        try
        {
            $data = Transacciones::where('referencia','=', $id)->update(['fecha_pago' => $fecha,'banco'=>$banco,'cuenta_deposito'=>$cuenta]);

        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@updateStatusReferenceStatus65]  ERROR al actualizar las transacciones como procesadas");
            return false;
        }
    }
    public function findTransaccionesFechaPago($info)
    {
        try
        {
            $data = Transacciones::whereIn('oper_transacciones.referencia', $info)
            ->select('oper_transacciones.referencia','oper_processedregisters.day','oper_processedregisters.month','oper_processedregisters.year','oper_banco.nombre as banco','oper_processedregisters.cuenta_banco')
            ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','oper_transacciones.referencia')
            ->leftjoin('oper_banco','oper_banco.id','oper_processedregisters.banco_id')
            ->where('oper_transacciones.fecha_pago','=',null)
            ->get();

            return $data;
        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@findTransaccionesFechaPago]  ERROR al buscar las transacciones" . $e );
            return false;
        }
    }
     public function findTransaccionesNoConciliadas($fechaIn,$fechaF)
    {
        
           $data = Transacciones::whereBetween('fecha_pago',[$fechaIn,$fechaF])
        ->select('oper_transacciones.id_transaccion_motor as folio','oper_transacciones.referencia','oper_transacciones.banco','oper_transacciones.importe_transaccion as monto','egobierno.status.Descripcion as status','oper_transacciones.fecha_pago')
        ->leftjoin('egobierno.status','egobierno.status.Status','=','oper_transacciones.estatus')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
        ->where('oper_transacciones.estatus','=','0')  
        ->Where('oper_processedregisters.referencia','=',null)
        ->groupBy('oper_transacciones.id_transaccion_motor')
        ->get();
          return $data;
       
    }
    public function findTransaccionesPagado($user)
    {
        
        $data = Transacciones::where('oper_transacciones.estatus','0')
        ->select('oper_usuariobd_entidad.usuariobd AS usuario',
            'oper_transacciones.entidad AS entidad',
            'oper_transacciones.referencia AS referencia',
            'oper_transacciones.id_transaccion_motor AS id_transaccion_motor',
            'oper_transacciones.id_transaccion AS id_transaccion',
            'oper_transacciones.estatus AS estatus',
            'oper_transacciones.importe_transaccion  AS Total',
            'oper_metodopago.nombre AS MetododePago',
            'oper_transacciones.tipo_pago AS cve_Banco',
            'oper_transacciones.banco AS Banco',
            'oper_transacciones.fecha_transaccion AS FechaTransaccion',
            'oper_transacciones.fecha_pago AS FechaPago',
            'oper_processedregisters.fecha_ejecucion AS FechaConciliacion')
        ->leftjoin('oper_metodopago','oper_metodopago.id','=','oper_transacciones.metodo_pago_id')
        //->leftjoin('oper_banco','oper_banco.id','=','oper_transacciones.banco')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
        ->leftjoin('oper_usuariobd_entidad','oper_usuariobd_entidad.id_entidad','=','oper_transacciones.entidad')
         ->leftjoin('oper_pagos_solicitud','oper_pagos_solicitud.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
         ->where('oper_usuariobd_entidad.usuariobd' ,'=', $user)  
        //->whereIn('oper_transacciones.entidad' ,$entidad)  
        ->Where('oper_pagos_solicitud.id_transaccion_motor','=',null)
        ->orderBy('oper_transacciones.id_transaccion_motor', 'DESC')
        ->get();
          return $data;
       
    }
     public function verifTransaccionesPagado($user,$id_transaccion_motor)
    {
        try{
            $data = Transacciones::where('oper_transacciones.estatus','0')
            ->select('oper_transacciones.id_transaccion_motor AS id_transaccion_motor',
                'oper_pagos_solicitud.id_transaccion_motor as existe')       
            ->leftjoin('oper_usuariobd_entidad','oper_usuariobd_entidad.id_entidad','=','oper_transacciones.entidad')
            ->leftjoin('oper_pagos_solicitud','oper_pagos_solicitud.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
            ->where('oper_usuariobd_entidad.usuariobd' ,'=', $user)  
            ->where('oper_transacciones.id_transaccion_motor' ,$id_transaccion_motor)  
            //->Where('oper_pagos_solicitud.id_transaccion_motor','=',null)
            ->orderBy('oper_transacciones.id_transaccion_motor', 'DESC')
            ->get();
            return $data;
        }catch( \Exception $e ){
            Log::info("[TransaccionesRepositoryEloquent@verifTransaccionesPagado]  ERROR al buscar transaccione");
            return false;
        }       
    }
    public function findTransaccionesFolio($user,$variable1,$variable2)
    {
        
        $data = Transacciones::where('oper_transacciones.estatus','0')
        ->select('oper_usuariobd_entidad.usuariobd AS usuario',
            'oper_transacciones.entidad AS entidad',
            'oper_transacciones.referencia AS referencia',
            'oper_transacciones.id_transaccion_motor AS id_transaccion_motor',
            'oper_transacciones.id_transaccion AS id_transaccion',
            'oper_transacciones.estatus AS estatus',
            'oper_transacciones.importe_transaccion  AS Total',
            'oper_metodopago.nombre AS MetododePago',
            'oper_transacciones.tipo_pago AS cve_Banco',
            'oper_transacciones.banco AS Banco',
            'oper_transacciones.fecha_transaccion AS FechaTransaccion',
            'oper_transacciones.fecha_pago AS FechaPago',
            'oper_processedregisters.fecha_ejecucion AS FechaConciliacion')
        ->leftjoin('oper_metodopago','oper_metodopago.id','=','oper_transacciones.metodo_pago_id')
        //->leftjoin('oper_banco','oper_banco.id','=','oper_transacciones.banco')
        ->leftjoin('oper_processedregisters','oper_processedregisters.referencia','=','oper_transacciones.referencia')
        ->leftjoin('oper_usuariobd_entidad','oper_usuariobd_entidad.id_entidad','=','oper_transacciones.entidad')
         ->leftjoin('oper_pagos_solicitud','oper_pagos_solicitud.id_transaccion_motor','=','oper_transacciones.id_transaccion_motor')
         ->where('oper_usuariobd_entidad.usuariobd' ,'=', $user)  
         ->whereIn($variable1,$variable2) 
        //->whereIn('oper_transacciones.entidad' ,$entidad)  
        //->Where('oper_pagos_solicitud.id_transaccion_motor','=',null)
        ->orderBy('oper_transacciones.id_transaccion_motor', 'DESC')
        ->get();
          return $data;
       
    }

    
    
}
