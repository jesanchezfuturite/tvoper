<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\PortalSolicitudesTicket;
use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalSolicitudesStatusRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;
use App\Repositories\TramitedetalleRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\PortalSolicitudesMensajesRepositoryEloquent;
use App\Repositories\PortalTramitesRepositoryEloquent;

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
    protected $campo;
    protected $mensajes;
    protected $solTramites;



    public function __construct(
        PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
        PortalSolicitudesStatusRepositoryEloquent $status,
        PortalSolicitudesTicketRepositoryEloquent $ticket,
        TramitedetalleRepositoryEloquent $tramites,
        EgobiernotiposerviciosRepositoryEloquent $tiposer,
        PortalNotaryOfficesRepositoryEloquent $notary,
        PortalConfigUserNotaryOfficeRepositoryEloquent $configUserNotary,
        PortalcampoRepositoryEloquent $campo,
        PortalSolicitudesMensajesRepositoryEloquent $mensajes,
        PortalTramitesRepositoryEloquent $solTramites
        
       )
       {
         $this->solicitudes = $solicitudes;
         $this->status = $status;
         $this->ticket = $ticket;
         $this->notary = $notary;
         $this->tiposer = $tiposer;
         $this->configUserNotary = $configUserNotary;
         $this->campo = $campo;
         $this->mensajes = $mensajes;
         $this->solTramites = $solTramites;
   
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
      $name= \Request::route()->getName();
      if($name=="RegistrarSolicitud"){
        $status=99;
      }else{
        $status=80;
      }
    
      $tramite = $this->solicitudes->where('tramite_id', $request->catalogo_id)->first();
      $catalogo_id = $tramite->id;        
      $error =null;
      $solicitantes = $request->solicitantes; 
      $clave = $request->clave;
      
      $user_id = $request->user_id;
      $solicitantes = json_decode($solicitantes);
      $info = json_decode($request->info);
      // $info = $request->info;

      $ids = [];
      try { 
        if($status==80){
          $ids_originales =$this->ticket->where('clave', $clave)->pluck('id')->toArray();
          if(!empty($solicitantes)){
            $ids_entrada = array_column($solicitantes, 'id');
            $ids_eliminar = array_diff($ids_originales, $ids_entrada);
            $ids_agregar = array_diff($ids_entrada, $ids_originales);
            $eliminar_solicitantes = $this->ticket->whereIn('id', $ids_eliminar)->delete();

            foreach($solicitantes as $key => $value){
              $info->solicitante=$value;
              // $info["solicitante"]=$value;  
              $ticket = $this->ticket->updateOrCreate(["id" =>$value->id], [
                "clave" => $clave,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),              
                "user_id"=>$user_id,
                "status"=>$status
        
              ]);        
             array_push($ids, $ticket->id);
            }
            $first_id = reset($ids);
            if($request->has("file")){
              $this->deleteFiles($clave);
              foreach ($request->file as $key => $value) {
                  $data =[
                    'ticket_id'=> $first_id,
                    'mensaje' => $request->descripcion[$key],
                    'file'    =>  $value
                    ];
                  $this->saveFile($data);       
                
  
              }
            }
          }else{
            $ticket = $this->ticket->updateOrCreate(["id" =>$request->id], [
              "clave" => $clave,
              "catalogo_id" => $catalogo_id,
              "info"=> json_encode($info),              
              "user_id"=>$user_id,
              "status"=>$status      
            ]); 
            
            if($request->has("file")){
              $this->deleteFiles($clave);
               foreach ($request->file as $key => $value) {   
                  $data =[
                    'ticket_id'=> $ticket->id,
                    'mensaje' => $request->descripcion[$key],
                    'file'    =>  $value
                    ];
                  $this->saveFile($data);       
                }
          
             
            }
          }

        }else{
          if(!empty($solicitantes)){
            $ids_originales =$this->ticket->where('clave', $clave)->pluck('id')->toArray();
            $ids_entrada = array_column($solicitantes, 'id');
            $ids_eliminar = array_diff($ids_originales, $ids_entrada);
            $ids_agregar = array_diff($ids_entrada, $ids_originales);
            $eliminar_solicitantes = $this->ticket->whereIn('id', $ids_eliminar)->delete();
            foreach($solicitantes as $key => $value){              
              $info->solicitante=$value;
              // $info["solicitantes"]=$value;  
              $ticket = $this->ticket->updateOrCreate(["id" =>$value->id],[
                "clave" => $clave,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),              
                "user_id"=>$user_id,
                "status"=>$status
        
              ]);   
        
             array_push($ids, $ticket->id);
            }
            $first_id = reset($ids);
            if($request->has("file")){
              foreach ($request->file as $key => $value) {
                $data =[
                  'ticket_id'=> $first_id,
                  'mensaje' => $request->descripcion[$key],
                  'file'    =>  $value
                  ];
                 
                  $this->saveFile($data);             
  
              }
            }
          }else{
            $ticket = $this->ticket->updateOrCreate(["id" =>$request->id], [
              "clave" => $clave,
              "catalogo_id" => $catalogo_id,
              "info"=> json_encode($info),              
              "user_id"=>$user_id,
              "status"=>$status      
            ]); 
            
            if($request->has("file")){
               foreach ($request->file as $key => $value) {   
                  $data =[
                    'ticket_id'=> $ticket->id,
                    'mensaje' => $request->descripcion[$key],
                    'file'    =>  $value,
                    ];
                  $this->saveFile($data);       
                }
          
             
            }
          }
        }  
        
      } catch (\Exception $e) {
        $error = [
            "Code" => "400",
            "Message" => "Error al guardar la solicitud"
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
          $this->ticket->where('id',$id)->where('status', 99)->update(["status"=>0]);
        }else{
          $this->ticket->where('clave',$id)->where('status', 99)->update(["status"=>0]);
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
        
        $relation = $this->configUserNotary->where('user_id', $user_id)->first(); 
        $notary_id = $relation->notary_office_id;
        $notary_offices=  $this->notary->where('id', $notary_id)->first()->toArray();

        $solicitudes = PortalSolicitudesTicket::where('user_id', $user_id)->where('status', 99)
        ->with(['catalogo' => function ($query) {
          $query->select('id', 'tramite_id');
        }])->get()->toArray();
        $ids_tramites=[];
        foreach ($solicitudes as &$sol){
          foreach($sol["catalogo"]  as $s){
            $sol["tramite_id"]=$s["tramite_id"];            
          }
        }

        $ids_tramites= array_column($solicitudes, 'tramite_id');
        
        $idstmts = array_unique($ids_tramites);
      
        
        $tramites = $this->getTramites($idstmts);
    
        $tmts=[];
        $response =[];
        foreach($tramites as $t => $tramite){
          $datos=[];
          foreach ($solicitudes as $d => $dato) { 
            if($dato["tramite_id"]== $tramite["tramite_id"]){
              if(empty($info)){
                $info=$dato["info"];
              }else{
                $info = $this->asignarClavesCatalogo($dato["info"]);
              }              
              $data=array(
                "id"=>$dato["id"],
                "clave"=>$dato["clave"],
                "catalogo_id"=>$dato["catalogo_id"],
                "user_id"=>$dato["user_id"],
                "info"=>$info,
                "status"=>$dato["status"]
              );

              array_push($datos, $data);
              $tramite["solicitudes"]= $datos;
              
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
      $ids = json_decode(json_encode($request->ids_tickets));
      $error=null;
      try {            
        foreach ($ids as $key => $value) {  
            $solicitudTicket = $this->ticket->where('id' , $value->id)
            ->update(['status'=> $request->status]);
        }
             

      } catch (\Exception $e) {
          $error = $e;
      }  
      if ($error) {
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al actualizar estatus"
          ]);
      }else { 
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Estatus actualizado",
          ]);
      }    
    
    }

    public function asignarClavesCatalogo($info){
        $informacion = json_decode($info);
        $informacion = json_decode(json_encode($informacion), true);
    
  
        if(array_key_exists("campos", $informacion)){
          $catalogo= $this->campo->select('id', 'descripcion')->get()->toArray();
          $campos = $informacion["campos"]; 
          $keys = array_column($catalogo, 'id');
          $values = array_column($catalogo, 'descripcion');
          $combine = array_combine($keys, $values);
          $catalogue = array_intersect_key($combine, $campos);
          
          $camposnuevos = array_combine($catalogue, $campos);
          unset($informacion["campos"]);
          $informacion =array_merge(array("campos" =>$camposnuevos), $informacion);
        }

       

        return json_encode($informacion); 
    }

    public function saveFile($data){
      $mensaje = $data["mensaje"];
      $ticket_id = $data["ticket_id"];    
      $file = $data['file']; 

      $extension = $file->getClientOriginalExtension();

      try {
     
        $mensajes =$this->mensajes->create([
          'ticket_id'=> $ticket_id,
          'mensaje' => $mensaje,
        ]);

        $attach = "archivo_solicitud_".$mensajes->id.".".$extension;
        $guardar =$this->mensajes->where("id", $mensajes->id)->update([
        'attach' => $attach,
        ]);

        \Storage::disk('local')->put($attach,  \File::get($file));

      } catch(\Exception $e) {
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al guardar archivo",
          ]
        ); 
      }

    }

 

    public function filtrarSolicitudes(Request $request){
   
      $solicitudes = DB::connection('mysql6')->table('solicitudes_catalogo')
      ->select("solicitudes_ticket.id", "solicitudes_catalogo.titulo","solicitudes_catalogo.tramite_id", "solicitudes_status.descripcion", "solicitudes_ticket.id_transaccion",
      "solicitudes_ticket.created_at", "solicitudes_ticket.user_id", "solicitudes_ticket.info", "solicitudes_ticket.clave")
      ->join('solicitudes_ticket', 'solicitudes_catalogo.id', '=', 'solicitudes_ticket.catalogo_id')
      ->leftJoin('solicitudes_status', 'solicitudes_ticket.status', '=', 'solicitudes_status.id');
      
      if($request->has('tipo_solicitud')){
          $solicitudes->where('solicitudes_catalogo.id', $request->tipo_solicitud);
      }
  
      if($request->has('estatus')){
        $solicitudes->where('solicitudes_ticket.status', $request->estatus);
      }
  
      if($request->has('id_solicitud')){
        $solicitudes->where('solicitudes_ticket.id',  $request->id_solicitud);
      }
      if($request->has('notary_id')){
        $users = $this->configUserNotary->where('notary_office_id', $request->notary_id)->get()->pluck(["user_id"])->toArray(); 
        $solicitudes->whereIn('user_id', $users);
      }
      if($request->has('id_usuario')){        
        $solicitudes->where('user_id', $request->id_usuario);
      }

      $solicitudes->orderBy('solicitudes_ticket.created_at', 'DESC');
    
      $solicitudes = $solicitudes->get();

      $mensajes = $this->mensajes;
      $tramites = $this->solTramites;
      $trmts=[];
      foreach ($solicitudes as $key => $value) {
        foreach ($tramites->get() as $t => $tmt){
          if($value->id_transaccion ==$tmt->id){
            array_push( $trmts, $tmt->toArray());
          }
        }

        $value->tramites= $trmts;
      }

      $datos=[];
      foreach($solicitudes as $key => &$value){
        $info = $this->asignarClavesCatalogo($value->info);
        $value->info =$info;
        foreach ($mensajes->get() as $m => $msje){
          if($value->id ==$msje->ticket_id){
            array_push( $datos, $msje->toArray());
          }
        }

        $value->mensajes= $datos;

      }

      
      
      return $solicitudes;
    }

    public function saveTransaccion(Request $request){
      $ids_tramites = json_decode(json_encode($request->ids_tramites));
      $id_transaccion=null;
      $error=null;
      $solTramites = $this->solTramites->create([
        "estatus" => $request->status    
      ]); 
      $id_transaccion=$solTramites->id;
      try {            
        if($solTramites){
          foreach ($ids_tramites as $key => $value) {  
              $solicitudTicket = $this->ticket->where('id' , $value->id)
              ->update(['id_transaccion'=>$id_transaccion]);
          }
        }        

      } catch (\Exception $e) {
          $error = $e;
      }  
      if ($error) {
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al actualizar transacción"
          ]);
      }else { 
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Solicitud transacción generada",
            "id_transaccion"=>$id_transaccion,
          ]);
      }    
     
    }
    public function saveTransaccionMotor(Request $request){      
      $error=null;
      try {
        $solTramites = $this->solTramites->where('id' , $request->id_transaccion)
        ->update([
          'id_transaccion_motor'=>$request->id_transaccion_motor,
          'json_envio'=>json_encode($request->json_envio),
          'json_recibo'=>json_encode($request->json_recibo),
          'estatus'=> $request->status

          ]);
         
        // if($solTramites){
        //   $solicitudTicket = $this->ticket->where('id_transaccion' , $request->id_transaccion)
        //   ->update(['status'=> 3]);

        
        // }      

      } catch (\Exception $e) {
        $error = $e;
      }         
      if($error){
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al guardar transaccion motor"
          ]);
      }else{
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Transacción motor actualizado"
          ]);
      }    
      
    }
    public function updateStatusTramite(Request $request){
      $error=null;
      switch ($request->status) {
        case "60":
          $statusTicket = 5;
          break;
        case "65":
          $statusTicket = 99;
          break;
        default:
        $statusTicket = 3;
      }
      
     
      // try { 
        if($request->id_transaccion){
          $solTramites = $this->solTramites->where('id' , $request->id_transaccion)
          ->update(['estatus'=> $request->status]);    

        }else{
          $solTramites = $this->solTramites->where('id_transaccion_motor' , $request->id_transaccion_motor)
          ->update(['estatus'=> $request->status]);
        }          
        $solicitudTicket = $this->ticket->where('id_transaccion' , $request->id_transaccion)
        ->update(['status'=> $statusTicket]);

        $ids = $this->ticket->where('id_transaccion' , $$request->id_transaccion)->where('estatus', '<>', 5)->get(["id"]);
       
        foreach ($ids as $key => $value) {
            $tramites_finalizados = $this->tramites_finalizados($value->id);
          
        }


      // } catch (\Exception $e) {
      //     $error = $e;
      // }  
      if ($error) {
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al actualizar estatus"
          ]);
      }else { 
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Estatus actualizado",
          ]);
      }    
    
    }
    public function getStatus(Request $request){
      if($request->id_transaccion){
        $status = $this->solTramites->where('id' , $request->id_transaccion)->get();
      }else if($request->id_transaccion_motor){
        $status = $this->solTramites->where('id_transaccion_motor' , $request->id_transaccion_motor)->get();
      }else{
        $status = $this->solTramites->get();
      }

      return $status;
    }
    public function getRegistroTramite($id){
      try {
        $solicitud =  $this->ticket->where('clave' , $id)->get();
        $solicitud = json_decode($solicitud);
        $archivos = $this->mensajes->where('ticket_id', $solicitud[0]->id)->get();
       
        $solicitud[0]->archivos = $archivos;
        
        return $solicitud;
      
      } catch (\Exception $e) {
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al obtener registro",
          ]);
      }
     
    }
    public function updateSolTramites(Request $request){      
      $error=null;
      try {
        $solTramites = $this->solTramites->where('id' , $request->id_transaccion)
        ->update([          
          'url_recibo'=> $request->url_recibo,
          ]);
          

      } catch (\Exception $e) {
        $error = $e;
      }         
      if($error){
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al actualizar"
          ]);
      }else{
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Tramite actualizado"
          ]);
      }    
      
    }


    public function getDataTramite($id){        
      try {
        $solicitudes = $this->ticket->where('id', $id)->first();
        $tramite = $this->solTramites->where('id', $solicitudes->id_transaccion)->first();
        if($tramite->estatus==0){
          if($solicitudes->catalogo_id ==10){
            $solicitudes = PortalSolicitudesTicket::where('id', $id)
            ->with(['catalogo' => function ($query) {
              $query->select('id', 'tramite_id');
            }])->get()->toArray();
            

            $ids_tramites=[];
            foreach ($solicitudes as &$sol){
              foreach($sol["catalogo"]  as $s){
                $sol["tramite_id"]=$s["tramite_id"];            
              }
            }

            $ids_tramites= array_column($solicitudes, 'tramite_id');            
            $idstmts = array_unique($ids_tramites);           
            $tramites = $this->getTramites($idstmts);
            $tmts=[];
            $response =[];
            foreach($tramites as $t => $tramite){
              $datos=[];
              foreach ($solicitudes as $d => $dato) { 
                if($dato["tramite_id"]== $tramite["tramite_id"]){
                  $info = $this->asignarClavesCatalogo($dato["info"]);
                  $data=array(
                    "id"=>$dato["id"],
                    "clave"=>$dato["clave"],
                    "catalogo_id"=>$dato["catalogo_id"],
                    "user_id"=>$dato["user_id"],
                    "info"=>json_decode($info),
                    "status"=>$dato["status"]
                  );
                  array_push($datos, $data);
                  $tramite["solicitudes"]= $datos;
                }
              }
              array_push($tmts, $tramite);
            }
            unset($tmts[0]["tramite_id"]);

            $response["tramite"] =$tmts[0];

            return $response;     
          }else{
            $tramite = $this->solTramites->where('id', $solicitudes->id_transaccion)->first();
            $solicitudes = PortalSolicitudesTicket::where('id', $id)
            ->with(['catalogo' => function ($query) {
              $query->select('id', 'tramite_id');
            }])->get()->toArray();
            
            $ids_tramites=[];
            foreach ($solicitudes as &$sol){
              foreach($sol["catalogo"]  as $s){
                $sol["tramite_id"]=$s["tramite_id"];            
              }
            }

            $ids_tramites= array_column($solicitudes, 'tramite_id');            
            $idstmts = array_unique($ids_tramites);           
            $tramites = $this->getTramites($idstmts);
            $tmts=[];
            $response=[];

            unset($tramites[0]["tramite_id"]);

            $json_envio = ($tramite->json_envio);
            $tramites[0]["json_envio"]=json_decode($json_envio);
  
            $response["tramite"] =$tramites[0];
            return $response;
          }
        }else{
          return response()->json(
            [
              "Code" => "200",
              "Message" => "Este tramite no es un Tramite Completo",
            ]
          );
        }
      

  
      }catch(\Exception $e) {
  
  
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al obtener tramite",
          ]
        );
      }
    
    }
    public function deleteFiles($clave){
        $solicitudes= $this->ticket->where("clave", $clave)->get(["id"])->toArray();
        $first_id = reset($solicitudes);

        $file =$this->mensajes->where("ticket_id", $first_id)->get(["id", "attach"])->toArray();
        
        foreach ($file as $key => $value) {
          $pathtoFile = storage_path('app/'.$value["attach"]);
          unlink($pathtoFile);

          $archivos =$this->mensajes->where("id", $value["id"])->delete();
        }

     
    }


    public function downloadFile($file)
    {
      try{
      $pathtoFile = storage_path('app/'.$file);
      return response()->download($pathtoFile);
      }catch(\Exception $e){
        log::info("error PortalSolicitudesTicketController@downloadFile");
      }
    }
    public function tramites_finalizados($id){
      $ticket = $this->ticket->where("id", $id)->first();
      $solCatalogo = $this->solicitudes->where("id", $ticket->catalogo_id)->first();
      if($solCatalogo->atendido_por==1){
        try{
        $solicitudTicket = $this->ticket->where('id',$id)
        ->update(['status'=>2]);

        $mensajes =$this->mensajes->create([
          'ticket_id'=> $id,
          'mensaje' => "Solicitud cerrada porque esta asignado al admin"
        ]);

        return json_encode(
          [
            "response" 	=> "Tramite finalizado",
            "code"		=> 200
          ]);

        } catch (\Exception $e) {
          return json_encode(
            [
              "response" 	=> "Error al actualizar - " . $e->getMessage(),
              "code"		=> 402
            ]);
        }
       
      }


  }


    
}