<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\PortalSolicitudesTicket;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalSolicitudesStatusRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;
use App\Repositories\TramitedetalleRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use DB;

class PortalSolicitudesTicketController extends Controller
{
    protected $solicitudes;
    protected $ticket;
    protected $notary;
    protected $status;  
    protected $configUserNotary;
    protected $tramites;
    protected $tiposer;

    public function __construct(
        PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
        PortalSolicitudesStatusRepositoryEloquent $status,
        PortalSolicitudesTicketRepositoryEloquent $ticket,
        TramitedetalleRepositoryEloquent $tramites,
        EgobiernotiposerviciosRepositoryEloquent $tiposer,
        PortalNotaryOfficesRepositoryEloquent $notary,
        PortalConfigUserNotaryOfficeRepositoryEloquent $configUserNotary
        
       )
       {
         $this->solicitudes = $solicitudes;
         $this->status = $status;
         $this->ticket = $ticket;
         $this->notary = $notary;
         $this->tiposer = $tiposer;
         $this->configUserNotary = $configUserNotary;
   
       }
    

    public function getTramites($trmts){
        $tramits = $this->tiposer->whereIn('Tipo_Code', $trmts)->get();

        $tmts = array();
        try{

            foreach ($tramits as $t) {
                $tmts []=array(
                    'tramite_id'=> $t->Tipo_Code,
                    'tramite' => $t->Tipo_Descripcion,
                );
            }

        }catch(\Exception $e){
            Log::info('Error Portal - ver Tramites: '.$e->getMessage());
        }

        return $tmts;
    }
    public function registrarSolicitud(Request $request){
        $error =null;
        $solicitantes = $request->solicitantes; 
        $clave = $request->clave;
        $catalogo_id = $request->catalogo_id;
        $user_id = $request->user_id;
        $solicitantes = to_object($solicitantes);
        $info = $request->info;
        try {    
          foreach($solicitantes as $key => $value){
            $info["solicitante"]=$value;
            $ticket = $this->ticket->create([
              "clave" => $clave,
              "catalogo_id" => $catalogo_id,
              "info"=> json_encode($info),              
              "user_id"=>$user_id,
              "status"=>99
      
            ]);
            
          }
        } catch (\Exception $e) {
          $error = [
              "Code" => "400",
              "Message" => "Error al guardar la solicitud",
          ];
      
        }
        if($error) return response()->json($error);
        return response()->json(
            [
              "Code" => "200",
              "Message" => "Solicitud registrada",
            ]
          );
      }
      public function eliminarSolicitud(Request $request, $id){
        $valor = $request->tipo;
    
        try {
          if($valor=="u"){
            $this->ticket->where('id',$id)->where('status', 99)->delete();
          }else{
            $this->ticket->where('clave',$id)->where('status', 99)->delete();
          }
          return response()->json(
            [
              "Code" => "200",
              "Message" => "Solicitud eliminada",
            ]
          );
    
        } catch (\Exception $e) {
          return response()->json(
            [
              "Code" => "400",
              "Message" => "Error al eliminar solicitud",
            ]
          );
        }
      }
      public function check_diff_multi($array1, $array2){
        $result = array();
        foreach($array1 as $key => $val) {
             if(isset($array2[$key])){
               if(is_array($val) && $array2[$key]){
                   $result[$key] = $this->check_diff_multi($val, $array2[$key]);
               }
           } else {
               $result[$key] = $val;
           }
        }
    
        return $result;
    }
      public function getInfo($user_id){
        try {
          $tickets = $this->ticket->where('user_id', $user_id)->where('status', 99)->get()->pluck('catalogo_id')->toArray(); 
          
          $relation = $this->configUserNotary->where('user_id', $user_id)->first(); 
          $notary_id = $relation->notary_office_id;
          $notary_offices=  $this->notary->where('id', $notary_id)->first()->toArray();

          $solicitudesCatalogo = DB::connection('mysql6')->table('solicitudes_catalogo')
          ->leftjoin('solicitudes_ticket', 'solicitudes_catalogo.id', '=', 'solicitudes_ticket.catalogo_id')
          ->where('solicitudes_ticket.user_id', $user_id)->where('solicitudes_ticket.status', 99)
          ->get()->toArray();         
          $tramite_id = $this->solicitudes->whereIn('id', $tickets)->get()->pluck('tramite_id')->toArray();
            
          $tempArr = array_unique($tramite_id);
          $array2 = $this->getTramites($tempArr);
       
               
          $tmts=[];
          $response =[];
          foreach($array2 as $t => $tramite){
            foreach ($solicitudesCatalogo as $d => $dato) {      
              if($dato->tramite_id == $tramite["tramite_id"]){
                $data=array(
                  "id"=>$dato->id,
                  "clave"=>$dato->clave,
                  "catalogo_id"=>$dato->catalogo_id,
                  "user_id"=>$dato->user_id,
                  "info"=>$dato->info,
                  "status"=>$dato->status
                );
                
                array_push($tramite, $data);
               
              }
            
            }
                array_push($tmts, $tramite);
    
          }
          $response["notary_offices"]=$notary_offices;
          $response["tramites"] =$tmts;
    
          return $response;
          
    
        } catch (\Exception $e) {
          return response()->json(
            [
              "Code" => "400",
              "Message" => "Error al obtener información",
            ]
          );
        }
      }
    
      public function detalleTramite($clave){
        try {
          $tickets = $this->ticket->where('clave', $clave)->get()->toArray();
          return response()->json(
            [
              "Code" => "200",
              "resultado" => $tickets
            ]
          );
          
        } catch (\Exception $e) {
          return response()->json(
            [
              "Code" => "400",
              "Message" => "Error al obtener detalle",
            ]
          );
        }
      }
      public function updateTramite(Request $request){
          $id_transaccion = $request->id_transaccion;
          $id = $request->id;
          
        try{

            $solicitudTicket = $this->ticket->where('id',$request->id)
            ->update(['id_transaccion'=>$id_transaccion,'status'=> 1]);
      
          return response()->json(
            [
              "Code" => "200",
              "Message" => "Solicitud actualizada",
            ]
          );
      
          }catch(\Exception $e){
      
            Log::info('Error Editar solicitud '.$e->getMessage());
      
            return response()->json(
              [
                "Code" => "400",
                "Message" => "Error al editar la solicitud",
              ]
            );
          }
      
      }
    
}
