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
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\UrlGenerator;
use DB;
use Illuminate\Support\Facades\Log;

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
    protected $url;



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
        PortalTramitesRepositoryEloquent $solTramites,
        UrlGenerator $url

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
         $this->url = $url;

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
      $status="";
      if($name=="RegistrarSolicitudTemporal"){
        $status=80;
      }
      if($name=="RegistrarSolicitud"){
        $status=99;
      }

      if($request->has("status") && $request->status==7){
        $status=7;
      }

      if($request->has("en_carrito")){$carrito =1;}else{$carrito="";}

      if($request->has("grupo_clave")){$grupo = $request->grupo_clave;}else{$grupo="";}

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
                "grupo_clave" => $grupo,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),
                "user_id"=>$user_id,
                "status"=>$status,
                "en_carrito"=>$carrito,
                "required_docs"=>$request->required_docs

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
              "grupo_clave" => $grupo,
              "catalogo_id" => $catalogo_id,
              "info"=> json_encode($info),
              "user_id"=>$user_id,
              "status"=>$status,
              "en_carrito"=>$carrito,
              "required_docs"=>$request->required_docs
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

        }
        if($status==99){
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
                "grupo_clave" => $grupo,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),
                "user_id"=>$user_id,
                "status"=>$status,
                "en_carrito"=>$carrito,
                "required_docs"=>$request->required_docs

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
              "grupo_clave" => $grupo,
              "catalogo_id" => $catalogo_id,
              "info"=> json_encode($info),
              "user_id"=>$user_id,
              "status"=>$status,
              "en_carrito"=>$carrito,
              "required_docs"=>$request->required_docs
            ]);

            if($request->has("file")){
               foreach ($request->file as $key => $value) {
                  $data =[
                    'ticket_id'=> $ticket->id,
                    'mensaje' => $request->descripcion[$key],
                    'file'    =>  $value,
                    ];  return $tramites;
                  $this->saveFile($data);
                }


            }
          }
        }
        if($status==7){
          $estatus = $tramite->atendido_por=1 ? 2 : 1;
          if(!empty($datosrecorrer)){
            $datosrecorrer = json_decode($datosrecorrer);
            foreach($datosrecorrer as $key => $value){
              $data==1 ? $info->solicitante=$value :  $info=$value;
              $ticket = $this->ticket->updateOrCreate(["id" =>$value->id],[
                "clave" => $clave,
                "grupo_clave" => $grupo,
                "catalogo_id" => $catalogo_id,
                "info"=> json_encode($info),
                "user_id"=>$user_id,
                "status"=>$estatus,
                "en_carrito"=>$carrito,
                "required_docs"=>$request->required_docs

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
              "grupo_clave" => $grupo,
              "catalogo_id" => $catalogo_id,
              "info"=> json_encode($info),
              "user_id"=>$user_id,
              "status"=>$estatus,
              "en_carrito"=>$carrito,
              "required_docs"=>$request->required_docs
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
        Log::info('Error Guardar Solicitud Portal - Registrar solicitud: '.$e->getMessage());
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
            "id"=> $ids
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
            ->where('firmado', null)
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
                "grupo_clave"=>$dato["grupo_clave"],
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

    public function saveFile($data=null){
      if(!$data) $data = request()->all();
      $mensaje = $data["mensaje"];
      $ticket_id = $data["ticket_id"];
      $file = $data['file'];
      $extension = $file->getClientOriginalExtension();

      $ticket = $this->ticket->where("id", $ticket_id)->first();
      $notary = $this->configUserNotary->where('user_id', $ticket->user_id)->first();
      $notary_number =$this->notary->where("id", $notary->notary_office_id)->first();

      try {
        $mensajes =$this->mensajes->create([
          'ticket_id'=> $ticket_id,
          'mensaje' => $mensaje,
        ]);

        $name = "archivo_solicitud_".$mensajes->id."_".$notary_number->notary_number."_".$ticket_id.".".$extension;
        $attach = $this->url->to('/') . '/download/'.$name;

        $guardar =$this->mensajes->where("id", $mensajes->id)->update([
          'attach' => $attach,
        ]);

        \Storage::disk('local')->put($name,  \File::get($file));

      } catch(\Exception $e) {
        Log::info('Error Portal - Guardar Archivo: '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al guardar archivo",
          ]
        );
      }

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
        $array_tramites=[];
        if($solTramites){
          foreach ($ids_tramites as $key => $value) {
              $solicitudTicket = $this->ticket->where('id' , $value->id)
              ->update(['id_transaccion'=>$id_transaccion]);
              array_push($array_tramites, $value->id);
              $this->guardarCarrito($value->id, 1);
          }
        }
        $solTramitesUpdate = $this->solTramites->where("id", $id_transaccion)->update([
          'id_ticket'=>json_encode($array_tramites)
        ]);

      } catch (\Exception $e) {
          $error = $e;
          Log::info('Error Portal - Error al actualizar transacción '.$e->getMessage());
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
        $statusTicket = 1;
      }
      $recibo_referencia = $request->has("recibo_referencia") ? $request->recibo_referencia :  "";
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
          ->update([
            'status'=> $statusTicket,
            'id_tramite'=>$request->id_tramite,
            'recibo_referencia'=>$recibo_referencia
          ]);


        }

        $ids = $this->ticket->where('id_transaccion' , $request->id_transaccion)->where('status', '<>', 99)
        ->get(["id", "status"]);

        // foreach ($ids as $key => $value) {
        //   $this->guardarCarrito($value->id, 2);

        //   if($value->status<>5){
        //     $tramites_finalizados = $this->tramites_finalizados($value->id);
        //   }

        // }

        foreach ($ids as $key => $value) {
          $this->guardarCarrito($value->id, 2);         

          if(isset($value->info->camposConfigurados)){
            $array = $value->info->camposConfigurados;
             $distrito = array_search("Distrito", array_column($array, 'nombre'));
              if(!isset($distrito)){
                if($distrito->valor->clave==1){
                  $solicitudTicket = $this->ticket->where('id',$value->id)
                  ->update(['status'=>3]);
                }else{
                  $solicitudTicket = $this->ticket->where('id',$value->id)
                  ->update(['status'=>2]);
                }

              }else{
                if($value->status<>5){
                  $tramites_finalizados = $this->tramites_finalizados($value->id);
                }
      
              }

           }else{
            if($value->status<>5){
              $tramites_finalizados = $this->tramites_finalizados($value->id);
            }
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
        $statusTicket = 1;
      }
      $recibo_referencia = $request->has("recibo_referencia") ? $request->recibo_referencia :  "";

      try {
        if($request->id_transaccion){
          $solTramites= $this->solTramites->updateOrCreate(['id' => $request->id_transaccion], [
            "estatus"=> $request->status,
            "url_recibo"=> $request->url_recibo

          ]);

          $id = $solTramites->id;

        }else{
          $solTramites= $this->solTramites->updateOrCreate(['id_transaccion_motor' => $request->id_transaccion_motor], [
            "estatus"=> $request->status,
            "url_recibo"=> $request->url_recibo
          ]);
          $id = $solTramites->id;

        }

        $solicitudTicket = $this->ticket->where('id_transaccion' , $id)
        ->update([
          'status'=> $statusTicket,
          'id_tramite'=>$request->id_tramite,
          'recibo_referencia'=>$recibo_referencia

        ]);

        $ids = $this->ticket->where('id_transaccion' , $id)->where('status', '<>', 99)
        ->get(["id", "status", "info"]);

        foreach ($ids as $key => $value) {
          $this->guardarCarrito($value->id, 2);         
          $info = json_decode($value->info);
          if(isset($info->camposConfigurados)){
            log::info("if campos");
            $campos = $info->camposConfigurados;
             $key2 = array_search("Distrito", array_column($campos, 'nombre'));
              if(isset($key2)){
                 log::info("if distrito");
                 $distrito = $campos[$key2];
                if($distrito->valor->clave==1){
                  log::info("if clave");
                  $solicitudTicket = $this->ticket->where('id',$value->id)
                  ->update(['status'=>3]);
                }else{
                  log::info("else");
                  $solicitudTicket = $this->ticket->where('id',$value->id)
                  ->update(['status'=>2]);
                }

              }else{
                log::info("else del if");
                if($value->status<>5){
                  $tramites_finalizados = $this->tramites_finalizados($value->id);
                }
      
              }

          }else{
            log::info("else si no hay campos configurados");
            if($value->status<>5){
              $tramites_finalizados = $this->tramites_finalizados($value->id);
            }
          }
         
        }



      } catch (\Exception $e) {
          $error = $e;
      }
      if ($error) {
        log::info("error PortalSolicitudesTicketController@statusTramite" .$e->getMessage());
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
        $tramite_id = $this->solicitudes->where('id', $solicitudes->catalogo_id)->first();
        $tramite = $this->solTramites->where('id', $solicitudes->id_transaccion)->first();
        if($tramite->estatus==0){
          if($tramite_id->tramite_id ==399){
            $solicitudes = DB::connection('mysql6')->table("portal.solicitudes_ticket as tk")
            ->select('tk.*','not.titular_id','not.substitute_id','c.id', 'c.tramite_id','op.fecha_limite_referencia',
            'op.id_transaccion_motor','op.fecha_pago', 'op.id_transaccion', 'op.referencia',
            'tmt.id as operacion_interna', 'tmt.estatus as estatus_tramite', 'st.Descripcion'
            )
            ->leftJoin('portal.solicitudes_catalogo as c', 'tk.catalogo_id', '=', 'c.id')
            ->leftJoin('portal.solicitudes_tramite as tmt', 'tk.id_transaccion', '=', 'tmt.id')
            ->leftJoin('portal.config_user_notary_offices as config', 'tk.user_id', '=', 'config.user_id')
            ->leftJoin('portal.notary_offices as not', 'config.notary_office_id', '=', 'not.id')
            ->leftjoin('operacion.oper_transacciones as op', 'tmt.id_transaccion_motor', '=', 'op.id_transaccion_motor')
            ->leftjoin('egobierno.status as st', 'tmt.estatus', '=', 'st.Status')
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
              if(isset($suplente)){
                $notario["suplente"] =array(
                  'nombre'=> $suplente->name,
                  'apellido_paterno'=> $suplente->fathers_surname,
                  'apellido_materno'=> $suplente->mothers_surname,
                );
              }

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
                  if($info->tipoTramite=="complementaria" && isset($info->idTicketNormal)){
                      $solTicketAnterior = $this->ticket->where("id", $info->idTicketNormal)->first();
                      $expedientes =  $this->asignarClavesCatalogo($solTicketAnterior->info);
                      $campos = $expedientes->campos;
                      $camposConfigurados = $expedientes->camposConfigurados;
                      $info->campos=$campos;
                      $info->camposConfigurados=$camposConfigurados;

                  }
                  $data=array(
                    "id"=>$dato->id,
                    "clave"=>$dato->clave,
                    "catalogo_id"=>$dato->catalogo_id,
                    "user_id"=>$dato->user_id,
                    "info"=>$info,
                    "status_solicitud"=>$dato->status
                  );
                  array_push($datos, $data);
                  $tramite["solicitudes"]= $datos;


                }
                $response["operaciones"]=array(
                  "fecha_limite_referencia"=> $dato->fecha_limite_referencia,
                  "id_transaccion_motor"=> $dato->id_transaccion_motor,
                  "fecha_pago"=> $dato->fecha_pago,
                  "referencia"=> $dato->referencia,
                  "operacion_interna"=>$dato->operacion_interna,
                  "estatus_tramite"=>$dato->Descripcion

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
            ->select('tk.*','not.titular_id','not.substitute_id','c.id', 'c.tramite_id','op.fecha_limite_referencia',
            'op.id_transaccion_motor','op.fecha_pago', 'op.id_transaccion', 'op.referencia',
            'tmt.id as operacion_interna',  'st.Descripcion as estatus_tramite'
            )
            ->leftJoin('portal.solicitudes_catalogo as c', 'tk.catalogo_id', '=', 'c.id')
            ->leftJoin('portal.solicitudes_tramite as tmt', 'tk.id_transaccion', '=', 'tmt.id')
            ->leftJoin('portal.config_user_notary_offices as config', 'tk.user_id', '=', 'config.user_id')
            ->leftJoin('portal.notary_offices as not', 'config.notary_office_id', '=', 'not.id')
            ->leftjoin('operacion.oper_transacciones as op', 'tmt.id_transaccion_motor', '=', 'op.id_transaccion_motor')
            ->leftjoin('egobierno.status as st', 'tmt.estatus', '=', 'st.Status')
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
              if(isset($suplente)){
                $notario["suplente"] =array(
                  'nombre'=> $suplente->name,
                  'apellido_paterno'=> $suplente->fathers_surname,
                  'apellido_materno'=> $suplente->mothers_surname,
                );
              }
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
        log::info("error PortalSolicitudesTicketController@downloadFile" .$e->getMessage());
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
          $count = $this->ticket->where(["en_carrito" => 1, "status" => 99])->whereIn('user_id', $users)->count();
          $mensaje="Solicitudes en el carrito";

        }

        if($body["type"]=="firmado"){
          foreach($body["ids"] as $key => $value){
              $doc_firmado = $this->ticket->where('id',$value)->update(['doc_firmado'=>$body["urls"][$key]]);

          }
          $solicitudTicket = $this->ticket->whereIn('clave',$clave)->update(['por_firmar' => null, 'firmado'=>$body['status']]);
          $count = $this->ticket->where(["firmado" => 1, "status" => 2])->whereIn('user_id', $users)->count();
          $mensaje="Solicitudes firmadas";
        }

        if($body["type"]=="por_firmar"){
          $solicitudTicket = $this->ticket->whereIn('clave',$clave)->update(['por_firmar'=>$body['status']]);
          $count = $this->ticket->where(["por_firmar" => 1, "firmado" => null])->whereIn('status', [2,3])->whereIn('user_id', $users)->count();
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
    public function filtrarSolicitudes(Request $request){
        $max = Input::get('max');
        $request = $request->all();
        $flag=0;
        if(!isset($request["data"])){
          $body[] = $request;
          $flag=1;
        }else{
          $body = $request["data"];
        }
        $data=[];

        foreach($body as $key => $value){
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
            `solicitudes_ticket`.`id_tramite`,
            `solicitudes_ticket`.`recibo_referencia`,
            `solicitudes_ticket`.`required_docs`,
            `solicitudes_ticket`.`grupo_clave`
            ");
            $solicitudes = PortalSolicitudesTicket::with(["mensajes", "tramites"])
            ->select($select)
            ->leftJoin('solicitudes_catalogo', 'solicitudes_ticket.catalogo_id', '=', 'solicitudes_catalogo.id')
            ->leftJoin('solicitudes_status', 'solicitudes_ticket.status', '=', 'solicitudes_status.id')
            ->leftJoin('egobierno.tipo_servicios as servicio', 'solicitudes_catalogo.tramite_id', 'servicio.Tipo_Code');


            if(isset($value["pendiente_firma"])){
                $solicitudes->where('solicitudes_catalogo.firma', "1")
                ->whereNull("solicitudes_ticket.firmado")
                ->where("solicitudes_ticket.status", 2)
                ->whereNotNull('solicitudes_ticket.id_transaccion');
            }

            if(isset($value["firmado"])){
                $solicitudes->where('solicitudes_catalogo.firma', "1")
                ->where("solicitudes_ticket.status", 2)
                ->whereNotNull('solicitudes_ticket.id_transaccion')
                ->whereNotNull('solicitudes_ticket.firmado');
            }

            if(isset($value["tipo_solicitud"])){
                $solicitudes->where('solicitudes_catalogo.id', $value["tipo_solicitud"]);
            }
            if(isset($value["en_carrito"])){
                $solicitudes->where('solicitudes_ticket.en_carrito', 1)
                ->where('solicitudes_ticket.status', 99);
            }

            if(isset($value["id_solicitud"])){
                $solicitudes->where('solicitudes_ticket.id',  $value["id_solicitud"]);
            }
            if(isset($value["notary_id"])){
                $users = $this->configUserNotary->where('notary_office_id', $value["notary_id"])->get()->pluck(["user_id"])->toArray();
                $solicitudes->whereIn('user_id', $users);
            }

            if(isset($value["id_usuario"])){
                $relation = $this->configUserNotary->where('user_id', $value["id_usuario"])->first();
                if($relation){
                    $notary_id = $relation->notary_office_id;
                    $users = $this->configUserNotary->where('notary_office_id', $notary_id)->get()->pluck(["user_id"])->toArray();
                }else{
                    $users = [$value["id_usuario"]];
                }

                $solicitudes->whereIn('user_id', $users);
            }

            if(isset($value["estatus"])){
                if($value["estatus"]==3){
                  $solicitudes->whereIn('solicitudes_ticket.status', [3, 7, 8]);
                }else{
                  $solicitudes->where('solicitudes_ticket.status', $value["estatus"]);

                }
            }
            $solicitudes->orderBy('solicitudes_ticket.created_at', 'DESC');

            if(isset($max)){
                $solicitudes->latest()->take($max);
            }
            $solicitudes=$solicitudes->get();
            $data[$key]=$solicitudes;

        }

        $campos = [];
        $response = [];
        foreach($data as $key => $solicitud){
            foreach($solicitud as $key2 => $value){
              $value->info = json_decode($value->info);
              if(isset($value->info->campos)) $campos = array_merge($campos, array_keys((array)$value->info->campos));

            }
        }
        $campos = array_unique($campos);
        $catalogo = DB::connection('mysql6')->table('campos_catalogue')->select('id', 'descripcion','alias')->whereIn('id', $campos)->get()->toArray();
        $catalogoCampos = DB::connection('mysql6')->table('campos_catalogue')->select('id','alias')->get()->toArray();
        foreach($data as $key => $solicitud){
            foreach($solicitud as $key2 => $value){
                if(isset($value->info->campos)){
                    $campos = [];
                    foreach($value->info->campos as $key2 => $val){
                        if(is_numeric($key2)) $key2 = $catalogo[array_search($key, array_column($catalogo, 'id'))]->descripcion;
                        $campos[$key2] = $val;
                    }
                    $value->info->campos = $campos;
                }
                if(isset($value->info->camposConfigurados)){
                    $alias = array();
                    $doc=[];
                    foreach($value->info->camposConfigurados as $k => $val){
                      if($val->tipo=="file"){
                        $attach=[];
                        foreach ($value->mensajes as $m => $msje) {
                            if($msje->attach!=null){
                              $attach[$m] =$msje->attach;
                            }

                        }

                        $val->documento=$attach;
                      }
                      $al = $catalogoCampos[array_search($val->campo_id, array_column($catalogoCampos, 'id'))]->alias;
                      $alias = array('alias'=>$al);
                      $value->info->camposConfigurados[$k] = (object)array_merge((array)$val,(array)$alias);
                    }

                }

                if(isset($value->info->tipoTramite) && $value->info->tipoTramite=="complementaria" && isset($value->info->idTicketNormal)){
                    $solTicketAnterior = $this->ticket->where("id", $value->info->idTicketNormal)->first();
                    $expedientes = $this->asignarClavesCatalogo($solTicketAnterior->info);
                    $campos = $expedientes->campos;
                    $camposConfigurados = $expedientes->camposConfigurados;
                    $value->info->campos=$campos;
                    $value->info->camposConfigurados=$camposConfigurados;
                   if(isset($value->info->camposConfigurados)){

                      foreach($value->info->camposConfigurados as $k => $val){
                        $al = $catalogoCampos[array_search($val->campo_id, array_column($catalogoCampos, 'id'))]->alias;
                        $alias = array('alias'=>$al);
                        $value->info->camposConfigurados[$k] = (object)array_merge((array)$val,(array)$alias);
                      }
                    }
                }
            }
        }
        $data = $flag==1 ? $data[0] : $data;

        return $data;
    }


    public function countFiltrado(Request $request){
        $request = $request->all();
        if(!isset($request["data"])){
          $body[] = $request;
        }else{
          $body = $request["data"];
        }
        $data =[];
        foreach($body as $key => $value){

          $solicitudes = PortalSolicitudesTicket::select("*");

          if(isset($value["pendiente_firma"])){
              $solicitudes->where('solicitudes_catalogo.firma', "1")
              ->whereNull("solicitudes_ticket.firmado")
              ->whereIn("solicitudes_ticket.status", [2,3])
              ->whereNotNull('solicitudes_ticket.id_transaccion');
          }

          if(isset($value["firmado"])){
              $solicitudes->where('solicitudes_catalogo.firma', "1")
              ->whereIn("solicitudes_ticket.status", [2,3])
              ->whereNotNull('solicitudes_ticket.id_transaccion')
              ->whereNotNull('solicitudes_ticket.firmado');
          }

          if(isset($value["tipo_solicitud"])){
              $solicitudes->where('solicitudes_catalogo.id', $value["tipo_solicitud"]);
          }
          if(isset($value["en_carrito"])){
              $solicitudes->where('solicitudes_ticket.en_carrito', 1)
              ->where('solicitudes_ticket.status', 99);
          }

          if(isset($value["id_solicitud"])){
              $solicitudes->where('solicitudes_ticket.id',  $value["id_solicitud"]);
          }
          if(isset($value["notary_id"])){
              $users = $this->configUserNotary->where('notary_office_id', $value["notary_id"])->get()->pluck(["user_id"])->toArray();
              $solicitudes->whereIn('user_id', $users);
          }

          if(isset($value["id_usuario"])){
              $relation = $this->configUserNotary->where('user_id', $value["id_usuario"])->first();
              if($relation){
                  $notary_id = $relation->notary_office_id;
                  $users = $this->configUserNotary->where('notary_office_id', $notary_id)->get()->pluck(["user_id"])->toArray();

              }else{
                  $users = ["$user_id"];
              }

              $solicitudes->whereIn('user_id', $users);
          }

          if(isset($value["estatus"])){
              $solicitudes->where('solicitudes_ticket.status', $value["estatus"]);
          }
            $solicitudes = $solicitudes->count();
            $data["count"][$key]=$solicitudes;

        }


        return $data;
    }

    public function saveFiles(Request $request){
      $error=null;
      $files = $request->all();
      try {
        if(!empty($files)){
          foreach ($files as $key => $value) {
            $mensaje = $value["mensaje"];
            $ticket_id = $value["ticket_id"];
            $file = $value['file'];

            $ticket = $this->ticket->where("id", $ticket_id)->first();
            $notary = $this->configUserNotary->where('user_id', $ticket->user_id)->first();
            $notary_number =$this->notary->where("id", $notary->notary_office_id)->first();

            $mensajes =$this->mensajes->create([
              'ticket_id'=> $ticket_id,
              'mensaje'=>$mensaje
            ]);

            $new_file = str_replace('data:application/pdf;base64,', '', $file);
            $new_file = str_replace(' ', '+', $new_file);
            $new_file = base64_decode($new_file);

            $extension = explode('/', mime_content_type($file))[1];

            $name = "archivo_solicitud_".$mensajes->id."_".$notary_number->notary_number."_".$ticket_id.".".$extension;

            \Storage::disk('local')->put($name,  $new_file);

            $attach = $this->url->to('/') . '/download/'.$name;


            $guardar =$this->mensajes->where("id", $mensajes->id)->update([
              'attach' => $attach,
            ]);
          }

        }else{
          return response()->json(
            [
              "Code" => "400",
              "Message" => "Error al guardar archivo - ".  $e->getMessage(),

            ]
          );
        }
      } catch(\Exception $e) {
        $error = $e;
        Log::info('Error Guardar archivo: '.$e->getMessage());
      }

      if ($error) {
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al guardar archivo - ".  $e->getMessage(),

          ]
        );
      }else {
        return response()->json(
          [
            "response" 	=> "Archivo guardado",
            "code"		=> 200
          ]
        );
      }


    }
    public function getFileNotary($id){
      $notary = NotaryOffice::find($id);
      if($type=='sat'){
        $sat=$notary->sat_constancy_file;
        $path =\Storage::url($sat);
        return $path;

      }else{
        $notary=$notary->notary_constancy_file;
        $path =\Storage::url($notary);
        return $path;

      }

    }

    public function updateAlias()
    {
      $findallCamp=$this->campo->all();
      foreach ($findallCamp as $e) {
        $updateCamp=$this->campo->update(['alias'=>'f_' . $e->id],$e->id);
      }
    }
    public function editInfo(Request $request){

      $body = $request->data;
      try {
        foreach ($body as $key => $value) {
          if(!empty($value["info"])){
            $data=array(
              "info"=>json_encode($value["info"])
            );

          }

          if(!empty($value["clave"])){
            $data=array(
              "clave"=>$value["clave"]
            );

          }

          if(!empty($value["grupo_clave"])){
            $data=array(
              "grupo_clave"=>$value["grupo_clave"]
            );

          }

          $ticket = $this->ticket->where("id" , $value["id"])->update($data);
        }

        return response()->json(
          [
            "response" 	=> "Archivo guardado",
            "code"		=> 200
          ]
        );

      } catch (\Exception $e) {
          Log::info('Error Editar solicitud '.$e->getMessage());

          return response()->json(
            [
              "Code" => "400",
              "Message" => "Error al editar la solicitud",
            ]
          );
      }
    }


    public function getNormales($folio, $idTicket){
      try {

        $id_tramite = env("TRAMITE_5_ISR");
        $solicitud = $this->solTramites->where("id_transaccion_motor", $folio)->get();
        foreach ($solicitud as $s) {
          $id_transaccion = $s->id;
          $catalogo_id = $s->catalogo_id;
        }

        //Con el id_transaccion se buscan los registros existentes dentro de solicitudes_ticket
        $solicitudes = $this->ticket->where("id_transaccion", $id_transaccion)->where("id", $idTicket)->with(['catalogo'])->get()->toArray();



        $ids_tramites=[];
        foreach ($solicitudes as &$sol){
          foreach($sol["catalogo"]  as $s){ //aquí es el error
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
        Log::info('Get Normales :'.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al obtener información",
          ]
        );
      }
    }

    public function getFilesNotary($notary_number){
      $notary = $this->notary->where("notary_number", $notary_number)->first();
      if(!$notary){
        return response()->json(
          [
            "Code" => "400",
            "Message" => "El número de notaria no existe",
          ]
        );
      }
      $users = $this->configUserNotary->where("notary_office_id", $notary->id)->pluck("user_id")->toArray();

      $tickets = $this->ticket->whereIn("user_id", $users)->pluck("id")->toArray();
      $ids_archivos = $this->mensajes->whereIn("ticket_id", $tickets)->whereNotNull("attach")
      ->where("attach", "<>", "")->pluck("attach")->toArray();
      $files=[];
      foreach ($ids_archivos as $key => $value) {
        if (strpos($value, 'download') !== false) {
          $newvalue = explode( 'download/', $value );
            array_push($files, $newvalue[1]);

        }else{
            array_push($files, $value);
        }
      }

      // inicializar zip
      $zip = new \ZipArchive();

      // path
      $publicDir = public_path();

      // Nombre del zip
      $zipFileName = 'Documentos.zip';

      // Crear zip
      if ($zip->open(storage_path('app/'.$zipFileName), \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
          // Loop archivos
          foreach($files as $file){
            $path = storage_path('app/'.$file);
            if(file_exists($path)){
              $download_file = file_get_contents($path);
              $zip->addFromString(basename($file),$download_file);
            }
          }
          if($zip->numFiles!=0){
            $zip->close();
          }

          // close zip
      }

      // Download Zip
      $filePath = storage_path('app/'.$zipFileName);

      if(file_exists($filePath)){
        return response()->download($filePath);
      }else{
        return response()->json(
          [
            "Code" => "400",
            "Message" => "No hay archivos en esta notaria",

          ]
        );
      }
    }
    public function getTramiteRechazado($user_id){
      $primer =  PortalSolicitudesticket::where('user_id', $user_id)
      ->where("status", 3)
      ->whereNotNull("id_transaccion")
      ->groupBy('id_transaccion')->get()->pluck('id_transaccion')->toArray();

      $solicitudes = PortalSolicitudesticket::whereIn('id_transaccion',$primer)
      ->leftjoin("solicitudes_mensajes", "solicitudes_ticket.id", "=", "solicitudes_mensajes.ticket_id")->get();

     $ids = $solicitudes->pluck("id_transaccion")->toArray();
     $solicitudes = $solicitudes;
      $ids = array_unique($ids);
      $newDato=[];
      foreach($ids as $i => $id){
        $datos=[];
        foreach ($solicitudes as $d => $value) {
          if($value->id_transaccion== $id){
            if(!empty($value->info)){
              $info=$this->asignarClavesCatalogo($value->info);
              $value->info=$info;

            }
            array_push($datos, $value);
            $newDato[$i]["id_transaccion"]=$id;
            $newDato[$i]["tramites"]=$datos;
          }

        }
      }
      return $newDato;

    }

}
