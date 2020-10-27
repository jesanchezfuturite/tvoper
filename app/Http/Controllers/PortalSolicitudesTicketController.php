<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\PortalSolicitudesTicket;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalSolicitudesStatusRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;
use DB;

class PortalSolicitudesTicketController extends Controller
{
    protected $solicitudes;
    protected $ticket;
    protected $notary;
    protected $status;  
    protected $configUserNotary;

    public function __construct(
        PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
        PortalSolicitudesStatusRepositoryEloquent $status,
        PortalSolicitudesTicketRepositoryEloquent $ticket,
        PortalNotaryOfficesRepositoryEloquent $notary,
        PortalConfigUserNotaryOfficeRepositoryEloquent $configUserNotary
        
       )
       {
         $this->solicitudes = $solicitudes;
         $this->status = $status;
         $this->ticket = $ticket;
         $this->notary = $notary;
         $this->configUserNotary = $configUserNotary;
   
       }
    


    public function registarSolicitud(Request $request){
        $error =null;
        $solicitantes = $request->solicitantes; 
        $clave = $request->clave;
        $catalogo_id = $request->catalogo_id;
        $solicitantes = to_object($solicitantes);
        try {
    
          foreach($solicitantes as $key => $value){
            $ticket = $this->ticket->create([
              "clave" => $clave,
              "catalogo_id" => $catalogo_id,
              "info"=> $value->solicitante,
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
      public function getInfo($user_id){
        try {
          $tickets = $this->ticket->where('user_id', $user_id)->where('status', 99)->get()->pluck('catalogo_id')->toArray(); 
          
          $relation = $this->configUserNotary->where('user_id', $user_id)->first(); 
          $notary_id = $relation->notary_office_id;
          $notary_offices=  $this->notary->where('id', $notary_id)->first()->toArray();

          $solicitudes = DB::connection('mysql6')->table('solicitudes_catalogo')
          ->leftjoin('solicitudes_ticket', 'solicitudes_catalogo.id', '=', 'solicitudes_ticket.catalogo_id')
          ->where('solicitudes_ticket.user_id', $user_id)->where('solicitudes_ticket.status', 99)
          ->get()->toArray();         
            
          $tramite_id = $this->solicitudes->whereIn('id', $tickets)->get(["tramite_id"])->toArray();
       
    
          $tempArr = array_unique(array_column($tramite_id, 'tramite_id'));
          $tramite_id = array_intersect_key($tramite_id, $tempArr);
               
          $tmts=[];
          $response =[];
          foreach($tramite_id as $t => $tramite){
            foreach ($solicitudes as $d => $dato) {      
              if($dato->tramite_id == $tramite["tramite_id"]){
                $data=array(
                  "id"=>$dato->id,
                  "titulo"=>$dato->titulo,
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
}
