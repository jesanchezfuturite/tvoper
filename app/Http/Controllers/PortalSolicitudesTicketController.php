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
      if($name=="RegistrarSolicitudTemporal"){
        $status=80;
      }else{
        $status=99;

      }
      if($request->has("en_carrito")){
        $carrito =1;
      }else{
        $carrito="";
      }
      // $status = $request->estatus;
    
      $tramite = $this->solicitudes->where('tramite_id', $request->catalogo_id)->first();
      $catalogo_id = $tramite->id;        
      $error =null;
      $info = json_decode($request->info);

      if($request->has("solicitantes") && !$request->has("enajenantes")){
        $datosrecorrer= $request->solicitantes; 
        $data = 1;
      }else if($request->has("enajenantes")){
        $datosrecorrer= $request->enajenantes;     
        $data = 2;
      }
      
      $clave = $request->clave;
      
      $user_id = $request->user_id;
      // $info = $request->info;

      $ids = [];
      try { 
        if($status==80){
          $ids_originales =$this->ticket->where('clave', $clave)->pluck('id')->toArray();
          if(!empty($datosrecorrer)){
            $datosrecorrer = json_decode($datosrecorrer);

            $ids_entrada = array_column($datosrecorrer, 'id');
            $ids_eliminar = array_diff($ids_originales, $ids_entrada);
            $ids_agregar = array_diff($ids_entrada, $ids_originales);
            $eliminar_datosrecorrer = $this->ticket->whereIn('id', $ids_eliminar)->delete();

            foreach($datosrecorrer as $key => $value){
              $data==1 ? $info->solicitante=$value :  $info=$value;
              $ticket = $this->ticket->updateOrCreate(["id" =>$value->id], [
                "clave" => $clave,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),              
                "user_id"=>$user_id,
                "status"=>$status,
                "en_carrito"=>$carrito
        
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
              "status"=>$status,
              "en_carrito"=>$carrito   
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
          if(!empty($datosrecorrer)){
            $datosrecorrer = json_decode($datosrecorrer);
            $ids_originales =$this->ticket->where('clave', $clave)->pluck('id')->toArray();
            $ids_entrada = array_column($datosrecorrer, 'id');
            $ids_eliminar = array_diff($ids_originales, $ids_entrada);
            $ids_agregar = array_diff($ids_entrada, $ids_originales);
            $eliminar_datosrecorrer = $this->ticket->whereIn('id', $ids_eliminar)->delete();
            foreach($datosrecorrer as $key => $value){              
              $data==1 ? $info->solicitante=$value :  $info=$value;
              $ticket = $this->ticket->updateOrCreate(["id" =>$value->id],[
                "clave" => $clave,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),              
                "user_id"=>$user_id,
                "status"=>$status,
                "en_carrito"=>$carrito
        
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
              "status"=>$status,
              "en_carrito"=>$carrito   
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
          $this->ticket->where('id',$id)->where('status', 99)->update(["en_carrito"=>NULL]);
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
      
    public function getInfo($user_id, $type=""){
      try {        
        $relation = $this->configUserNotary->where('user_id', $user_id)->first(); 
        if($relation){
          $notary_id = $relation->notary_office_id;
          $users = $this->configUserNotary->where('notary_office_id', $notary_id)->get()->pluck(["user_id"])->toArray();
            
        }else{
          $users = ["$user_id"];          
        }

        if($type=="firma"){
          $solicitudes = PortalSolicitudesTicket::whereIn('user_id', $users)
          ->where(function ($query) {
            $query->where('por_firmar', '=', 1)
            ->whereNotNull('id_transaccion');
          })         
          ->with(['catalogo' => function ($query) {
            $query->select('id', 'tramite_id')->where("firma", 1);
          }])->get()->toArray(); 
        }else{
          $solicitudes = PortalSolicitudesTicket::whereIn('user_id', $users)->where('status', 99)
          ->where(function ($query) {
            $query->where('en_carrito', '=', 1);
          })         
          ->with(['catalogo' => function ($query) {
            $query->select('id', 'tramite_id');
          }])->get()->toArray();   
     
        }

        $ids_tramites=[];
        foreach ($solicitudes as &$sol){
          foreach($sol["catalogo"]  as $s){
            $sol["tramite_id"]=$s["tramite_id"];            
          }
        }

        $ids_tramites= array_column((array)$solicitudes, 'tramite_id');
        
        $idstmts = array_unique($ids_tramites);
      
        
        $tramites = $this->getTramites($idstmts);
    
        $tmts=[];
        $response =[];
        foreach($tramites as $t => $tramite){
          $datos=[];
          foreach ($solicitudes as $d => $dato) { 
            if($dato["tramite_id"]== $tramite["tramite_id"]){
              if(empty($info)){
                $info=json_decode($dato["info"]);
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

        // $response["notary_offices"]=$notary_offices;
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
        $campos = [];
        if(isset($informacion->campos)){
          foreach($informacion->campos as $key=>$value){
            if(is_numeric($key)){
              $catalogo= $this->campo->select('descripcion')->where('id',$key)->first();
              $campos[$catalogo->descripcion] = $value;
            }else{
              $campos[$key] = $value;
            }
              
          }
          $informacion->campos = $campos;
        }
        return $informacion;
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
      $consultas = 1;
      $select = DB::raw("
        `solicitudes_ticket`.`id`,
        `servicio`.`Tipo_Descripcion` as `nombre_servicio`,

        `solicitudes_catalogo`.`titulo`,
        `solicitudes_catalogo`.`tramite_id`,
        `solicitudes_catalogo`.`firma`,
        
        IF(`solicitudes_ticket`.`status` != 99, `solicitudes_status`.`descripcion`, IF(`solicitudes_ticket`.`status` = 99, 'Pendiente de pago', NULL)) AS descripcion,
        
        `solicitudes_ticket`.`status`,
        `solicitudes_ticket`.`en_carrito`,
        `solicitudes_ticket`.`id_transaccion`,
        `solicitudes_ticket`.`created_at`,
        `solicitudes_ticket`.`user_id`,
        `solicitudes_ticket`.`info`,
        `solicitudes_ticket`.`clave`,
        `solicitudes_ticket`.`por_firmar`,
        `solicitudes_ticket`.`doc_firmado`,
        `solicitudes_ticket`.`firmado`,

        `mensajes`.`id` as `mensajes_id`,
        `mensajes`.`ticket_id` as `mensajes_ticket_id`,
        `mensajes`.`mensaje` as `mensajes_mensaje`,
        `mensajes`.`attach` as `mensajes_attach`,
        `mensajes`.`mensaje_para` as `mensajes_mensaje_para`,
        `mensajes`.`created_at` as `mensajes_created_at`,
        `mensajes`.`updated_at` as `mensajes_updated_at`,

        `tramites`.`id` as `tramites_id`,
        `tramites`.`id_transaccion_motor` as `tramites_id_transaccion_motor`,
        `tramites`.`estatus` as `tramites_estatus`,
        `tramites`.`url_recibo` as `tramites_url_recibo`,
        `tramites`.`created_at` as `tramites_created_at`,
        `tramites`.`updated_at` as `tramites_updated_at`
      ");
      $solicitudes = DB::connection('mysql6')->table('solicitudes_ticket')
      ->select($select)
      ->leftJoin('solicitudes_catalogo', 'solicitudes_ticket.catalogo_id', '=', 'solicitudes_catalogo.id')
      ->leftJoin('solicitudes_status', 'solicitudes_ticket.status', '=', 'solicitudes_status.id')
      ->leftJoin('solicitudes_tramite as tramites', 'tramites.id', 'solicitudes_ticket.id_transaccion')
      ->leftJoin('solicitudes_mensajes as mensajes', 'mensajes.ticket_id', 'solicitudes_ticket.id')
      ->leftJoin('egobierno.tipo_servicios as servicio', 'solicitudes_catalogo.tramite_id', 'servicio.Tipo_Code');
          
      if($request->has('pendiente_firma')){        
        $solicitudes->where('solicitudes_catalogo.firma', "1")
        ->whereIn("solicitudes_ticket.status", [2,3])
        ->whereNotNull('solicitudes_ticket.id_transaccion');
      }

      if($request->has('firmado')){        
        $solicitudes->where('solicitudes_catalogo.firma', "1")
        ->whereIn("solicitudes_ticket.status", [2,3])
        ->whereNotNull('solicitudes_ticket.id_transaccion')
        ->whereNotNull('solicitudes_ticket.firmado');
      }
      
      if($request->has('tipo_solicitud')){
          $solicitudes->where('solicitudes_catalogo.id', $request->tipo_solicitud);
      }
      if($request->has('en_carrito')){
        $solicitudes->where('solicitudes_ticket.en_carrito', 1)
        ->where('solicitudes_ticket.status', 99);
      }
  
      if($request->has('id_solicitud')){        
        $solicitudes->where('solicitudes_ticket.id',  $request->id_solicitud);
      }
      if($request->has('notary_id')){
        $users = $this->configUserNotary->where('notary_office_id', $request->notary_id)->get()->pluck(["user_id"])->toArray();
        $solicitudes->whereIn('user_id', $users);
      }
      
      if($request->has('id_usuario')){     
        $relation = $this->configUserNotary->where('user_id', $request->id_usuario)->first(); 
        if($relation){
          $notary_id = $relation->notary_office_id;
          $users = $this->configUserNotary->where('notary_office_id', $notary_id)->get()->pluck(["user_id"])->toArray();
            
        }else{
          $users = ["$user_id"];          
        }   
        $solicitudes->whereIn('user_id', $users);
      }
      if($request->has('estatus')){
        $solicitudes->where('solicitudes_ticket.status', $request->estatus);
      }
      $solicitudes->orderBy('solicitudes_ticket.created_at', 'DESC');
      $solicitudes = $solicitudes->get();

   
      $campos = [];
      $response = [];
      foreach($solicitudes as $key => $solicitud){
        $solicitud->info = json_decode($solicitud->info);
        if(isset($solicitud->info->campos))
          $campos = array_merge($campos, array_keys((array)$solicitud->info->campos));
      }
      $campos = array_unique($campos);
      $catalogo = DB::connection('mysql6')->table('campos_catalogue')->select('id', 'descripcion')->whereIn('id', $campos)->get()->toArray();
      foreach($solicitudes as $key => $solicitud){
        if(isset($solicitud->info->campos)){
          $campos = [];
          foreach($solicitud->info->campos as $key => $val){
            if(is_numeric($key)) $key = $catalogo[array_search($key, array_column($catalogo, 'id'))]->descripcion;
            $campos[$key] = $val;
          }
          
          $solicitud->info->campos = $campos;
        }

        $search = array_search($solicitud->id, array_column($response, 'id'));
        $mensajes = [];
        $tramites = [];
        $sol = $search !== false ? $response[$search] : [];

        foreach($solicitud as $key => $val){
          preg_match('/^(tramites|mensajes)_(.*)/', $key, $matches);   
          if(count($matches) > 0){       
            ${$matches[1]}[$matches[2]] = $val;
          }else{                        
            $sol[$key] = $val;
          }
        }
 
      
        if(count($mensajes) > 0) $sol['mensajes'][] = $mensajes;
        else $sol['mensajes'] = [];
        if(count($tramites) > 0) $sol['tramites'][] = $tramites;
        else $sol['tramites'] = [];
        if($search !== false) $response[$search] = $sol;
        else $response[] = $sol;
      }

      return $response;
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

              $this->guardarCarrito($value->id, 1);
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
      switch ($request->status) {
        case "60":
          $statusTicket = 5;
          break;
        case "70":
        case "45":
        case "15":
        case "5":
          $statusTicket = 99;
          break;
        default:
        $statusTicket = 3;
      }
      try {
        $solTramites = $this->solTramites->where('id' , $request->id_transaccion)
        ->update([
          'id_transaccion_motor'=>$request->id_transaccion_motor,
          'json_envio'=>json_encode($request->json_envio),
          'json_recibo'=>json_encode($request->json_recibo),
          'url_recibo'=>$request->url_recibo,
          'estatus'=> $request->status

          ]);
         
        if($solTramites){
          $solicitudTicket = $this->ticket->where('id_transaccion' , $request->id_transaccion)
          ->update(['status'=> $statusTicket]);

        
        }  
               
        $ids = $this->ticket->where('id_transaccion' , $request->id_transaccion)->where('status', '<>', 99)
        ->get(["id", "status"]);

        foreach ($ids as $key => $value) {
          $this->guardarCarrito($value->id, 2);

          if($value->status<>5){
            $tramites_finalizados = $this->tramites_finalizados($value->id);
          }
          
        }

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
        case "70":
        case "45":
        case "15":
        case "5":
          $statusTicket = 99;
          break;
        default:
        $statusTicket = 3;
      }
      
     
      try { 
        if($request->id_transaccion){   
          $solTramites= $this->solTramites->updateOrCreate(['id' => $request->id_transaccion], [
            "estatus"=> $request->status
          ]);

          $id = $solTramites->id;

        }else{
          $solTramites= $this->solTramites->updateOrCreate(['id_transaccion_motor' => $request->id_transaccion_motor], [
            "estatus"=> $request->status
          ]);
          $id = $solTramites->id;
            
        }  

        $solicitudTicket = $this->ticket->where('id_transaccion' , $id)
        ->update(['status'=> $statusTicket]);

        $ids = $this->ticket->where('id_transaccion' , $request->id_transaccion)->where('status', '<>', 99)
        ->get(["id", "status"]);

        foreach ($ids as $key => $value) {
          $this->guardarCarrito($value->id, 2);
          
          if($value->status<>5){
            $tramites_finalizados = $this->tramites_finalizados($value->id);
          }
          
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
        $solTramites = $this->solTramites->where('id_transaccion_motor' , $request->id_transaccion_motor)
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
            $solicitudes = DB::connection('mysql6')->table("portal.solicitudes_ticket as tk")
            ->select('tk.*','not.titular_id','not.substitute_id','c.id', 'c.tramite_id','op.fecha_limite_referencia', 'op.id_transaccion_motor','op.fecha_pago', 'op.id_transaccion', 'op.referencia')
            ->leftJoin('portal.solicitudes_catalogo as c', 'tk.catalogo_id', '=', 'c.id')
            ->leftJoin('portal.solicitudes_tramite as tmt', 'tk.id_transaccion', '=', 'tmt.id')
            ->leftJoin('portal.config_user_notary_offices as config', 'tk.user_id', '=', 'config.user_id')
            ->leftJoin('portal.notary_offices as not', 'config.notary_office_id', '=', 'not.id')
            ->leftjoin('operacion.oper_transacciones as op', 'tmt.id_transaccion_motor', '=', 'op.id_transaccion_motor')
            ->where('tk.id', $id)
            ->get()->toArray();
            
            $notario = [];
            foreach($solicitudes as $key => $value){
              $titular = DB::connection('mysql6')->table("portal.users")->where("id", $value->titular_id)->first();
              $suplente = DB::connection('mysql6')->table("portal.users")->where("id", $value->substitute_id)->first();
              
              $notario["titular"] =array(
                'nombre'=> $titular->name,
                'apellido_paterno'=> $titular->fathers_surname,
                'apellido_materno'=> $titular->mothers_surname,

              );

              $notario["suplente"] =array(
                'nombre'=> $suplente->name,
                'apellido_paterno'=> $suplente->fathers_surname,
                'apellido_materno'=> $suplente->mothers_surname,
              );
            }

            $ids_tramites=[];   

            $ids_tramites= array_column($solicitudes, 'tramite_id');            
            $idstmts = array_unique($ids_tramites);           
            $tramites = $this->getTramites($idstmts);
            $tmts=[];
            $response =[];
            foreach($tramites as $t => $tramite){
              $datos=[];
              foreach ($solicitudes as $d => $dato) {
                if($dato->tramite_id== $tramite["tramite_id"]){
                  $info = $this->asignarClavesCatalogo($dato->info);
                  $data=array(
                    "id"=>$dato->id,
                    "clave"=>$dato->clave,
                    "catalogo_id"=>$dato->catalogo_id,
                    "user_id"=>$dato->user_id,
                    "info"=>$info,
                    "status"=>$dato->status
                  );
                  array_push($datos, $data);
                  $tramite["solicitudes"]= $datos;

                 
                }
                $response["operaciones"]=array(
                  "fecha_limite_referencia"=> $dato->fecha_limite_referencia,
                  "id_transaccion_motor"=> $dato->id_transaccion_motor,
                  "fecha_pago"=> $dato->fecha_pago,
                  "referencia"=> $dato->referencia,
               
                );
              }
              array_push($tmts, $tramite);
            }
            unset($tmts[0]["tramite_id"]);

            $response["tramite"] =$tmts[0];

         
            $response["notaria"]=$notario;


            return $response;     
          }else{
            $tramite = $this->solTramites->where('id', $solicitudes->id_transaccion)->first();

            $solicitudes = DB::connection('mysql6')->table("portal.solicitudes_ticket as tk")
            ->select('not.titular_id','not.substitute_id','c.id', 'c.tramite_id','op.fecha_limite_referencia', 'op.id_transaccion_motor','op.fecha_pago', 'op.id_transaccion', 'op.referencia')
            ->leftJoin('portal.solicitudes_catalogo as c', 'tk.catalogo_id', '=', 'c.id')
            ->leftJoin('portal.solicitudes_tramite as tmt', 'tk.id_transaccion', '=', 'tmt.id')
            ->leftJoin('portal.config_user_notary_offices as config', 'tk.user_id', '=', 'config.user_id')
            ->leftJoin('portal.notary_offices as not', 'config.notary_office_id', '=', 'not.id')
            ->leftjoin('operacion.oper_transacciones as op', 'tmt.id_transaccion_motor', '=', 'op.id_transaccion_motor')
            ->where('tk.id', $id)
            ->get()->toArray();

            $notario = [];
            foreach($solicitudes as $key => $value){
              $titular = DB::connection('mysql6')->table("portal.users")->where("id", $value->titular_id)->first();
              $suplente = DB::connection('mysql6')->table("portal.users")->where("id", $value->substitute_id)->first();
              
              $notario["titular"] =array(
                'nombre'=> $titular->name,
                'apellido_paterno'=> $titular->fathers_surname,
                'apellido_materno'=> $titular->mothers_surname,

              );

              $notario["suplente"] =array(
                'nombre'=> $suplente->name,
                'apellido_paterno'=> $suplente->fathers_surname,
                'apellido_materno'=> $suplente->mothers_surname,
              );
            }
          
            $ids_tramites=[];
     
            $ids_tramites= array_column($solicitudes, 'tramite_id');            
            $idstmts = array_unique($ids_tramites);           
            $tramites = $this->getTramites($idstmts);
            $tmts=[];
            $response=[];

            unset($tramites[0]["tramite_id"]);

            $json_envio = ($tramite->json_envio);
            $tramites[0]["json_envio"]=json_decode($json_envio);
  
            $response["tramite"] =$tramites[0];
            $response["operaciones"]=$solicitudes;
            $response["notaria"]=$notario;

 

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
            "Message" => "Error al obtener tramite. -" . $e->getMessage(),
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

  public function guardarCarrito($id, $status){
      try{
      $solicitudTicket = $this->ticket->where('id',$id)
      ->update(['en_carrito'=>$status]);

      return json_encode(
        [
          "response" 	=> "Solicitud en el carrito",
          "code"		=> 200
        ]);

      } catch (\Exception $e) {
        return json_encode(
          [
            "response" 	=> "Error al guardar en carrito - " . $e->getMessage(),
            "code"		=> 402
          ]);
      }

  } 

  
  public function enCarrito(Request $request){
    $body = $request->json()->all();
    $user_id = $body["user_id"];
    $clave = $this->ticket->whereIn('id',$body['ids'])->pluck("clave")->toArray();
    $relation = $this->configUserNotary->where('user_id', $user_id)->first(); 
    if($relation){
      $notary_id = $relation->notary_office_id;
      $users = $this->configUserNotary->where('notary_office_id', $notary_id)->get()->pluck(["user_id"])->toArray();
        
    }else{
      $users = ["$user_id"];          
    }

  
    $ids = array();
    foreach($clave as $key => $v){
      $data =  $this->ticket->where('clave', $v)->pluck("id")->toArray(); 
      $ids[]=array(
        "clave"=>$v,
        "ids"=>$data
      );     
      
    }
    try{
      if($body["type"]=="en_carrito"){
        $solicitudTicket = $this->ticket->whereIn('clave',$clave)->update(['en_carrito'=>$body['status']]);
        $count = $this->ticket->where("en_carrito", 1)->whereIn('user_id', $users)->count();
        $mensaje="Solicitudes en el carrito";
        
      }

      if($body["type"]=="firmado"){
        foreach($body["ids"] as $key => $value){
            $doc_firmado = $this->ticket->where('id',$value)->update(['doc_firmado'=>$body["urls"][$key]]);

        }
        $solicitudTicket = $this->ticket->whereIn('clave',$clave)->update(['firmado'=>$body['status']]);
        $count = $this->ticket->where("firmado", 1)->whereIn('user_id', $users)->count();
        $mensaje="Solicitudes firmadas";
      }

      if($body["type"]=="por_firmar"){
        $solicitudTicket = $this->ticket->whereIn('clave',$clave)->update(['por_firmar'=>$body['status']]);
        $count = $this->ticket->where("por_firmar", 1)->whereIn('user_id', $users)->count();
        $mensaje="Solicitudes por firmar";


      }
      return json_encode([
        "response" 	=> $mensaje,
        "code"		=> 200,
        "count"=>$count,
        "ids" => $ids

      ]);
    } catch (\Exception $e) {
      return json_encode([
        "response" 	=> "Error al guardar - " . $e->getMessage(),
        "code"		=> 402
      ]);
    }

  } 
    
}