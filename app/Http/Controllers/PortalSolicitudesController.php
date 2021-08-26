<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;
use App\Entities\PortalSolicitudesTicket;
use Dompdf\Dompdf;
use Dompdf\Options;
use File;
use Illuminate\Support\Facades\View;
use App\Repositories\UsersRepositoryEloquent;
use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalSolicitudesStatusRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\PortalSolicitudesMensajesRepositoryEloquent;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;
use App\Repositories\TramitedetalleRepositoryEloquent;

use App\Repositories\PortalDocumentosBitacoraRepositoryEloquent;
use Illuminate\Routing\UrlGenerator;
use App\Repositories\PortalTramitesRepositoryEloquent;

use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\PortalsolicitudesresponsablesRepositoryEloquent;
use App\Repositories\PortalmensajeprelacionRepositoryEloquent;
use App\Repositories\SolicitudesMotivoRepositoryEloquent;
use App\Repositories\MotivosRepositoryEloquent;
use App\Entities\SolicitudesMotivo;
use App\Repositories\OperacionUsuariosEstatusRepositoryEloquent;
use Luecano\NumeroALetras\NumeroALetras;
use Milon\Barcode\DNS1D;
use App\Entities\EstatusAtencion;
use App\Entities\Portalsolicitudesresponsables;
use App\Entities\Users;
use App\Entities\TicketBitacora;
use App\Entities\UsersPortal;
use App\Entities\NotificacionEstatusAtencion;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PortalSolicitudesController extends Controller
{
  protected $users;
  protected $solicitudes;
  protected $tramites;
  protected $tickets;
  protected $tiposer;
  protected $partidas;
  protected $notary;
  protected $status;
  protected $configUserNotary;
  protected $mensajes;
  protected $campo;
  protected $solicitudrespdb;
  protected $msjprelaciondb;
  protected $solicitudesMotivos;
  protected $motivos;
  protected $userEstatus;

  protected $ticketBitacoradb;

  protected $docbitacoradb;
  protected $url;
  protected $tramitesdb;


  public function __construct(
     UsersRepositoryEloquent $users,
     PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
     TramitedetalleRepositoryEloquent $tramites,
     EgobiernotiposerviciosRepositoryEloquent $tiposer,
     EgobiernopartidasRepositoryEloquent $partidas,
     PortalSolicitudesStatusRepositoryEloquent $status,
     PortalSolicitudesTicketRepositoryEloquent $ticket,
     PortalNotaryOfficesRepositoryEloquent $notary,
     PortalConfigUserNotaryOfficeRepositoryEloquent $configUserNotary,
     PortalSolicitudesMensajesRepositoryEloquent $mensajes,
     PortalcampoRepositoryEloquent $campo,
     PortalsolicitudesresponsablesRepositoryEloquent $solicitudrespdb,
     PortalmensajeprelacionRepositoryEloquent $msjprelaciondb,
     SolicitudesMotivoRepositoryEloquent $solicitudesMotivos,
     MotivosRepositoryEloquent $motivos,
     OperacionUsuariosEstatusRepositoryEloquent $userEstatus,
     TicketBitacora $ticketBitacoradb,
     PortalDocumentosBitacoraRepositoryEloquent $docbitacoradb,
     UrlGenerator $url,
     PortalTramitesRepositoryEloquent $tramitesdb

    )
    {
      // $this->middleware('auth');
      $this->users = $users;
      $this->solicitudes = $solicitudes;
      $this->tramites = $tramites;
      $this->tiposer = $tiposer;
      $this->partidas = $partidas;
      $this->status = $status;
      $this->ticket = $ticket;
      $this->notary = $notary;
      $this->configUserNotary = $configUserNotary;
      $this->mensajes = $mensajes;
      $this->campo = $campo;
      $this->solicitudrespdb = $solicitudrespdb;
      $this->msjprelaciondb = $msjprelaciondb;
      $this->solicitudesMotivos = $solicitudesMotivos;
      $this->motivos = $motivos;
      $this->userEstatus = $userEstatus;

      $this->ticketBitacoradb = $ticketBitacoradb;


      $this->docbitacoradb = $docbitacoradb;
      $this->url = $url;
      $this->tramitesdb = $tramitesdb;

    }

  /**
  * Lista de tramites Actuales
  *
  *	@return solicitudes nombre solicitud y solicitud dependiente
  */

  public function index(){

    return view('portal/solicitudes', []);

  }

  /**
  * Lista de tramites
  *
  *	@return json lista de tramites con id
  */

  public function getTramites(){

    $tramits = $this->tiposer->where('id_gpm','>=', 1)->get();

    //$tmts->tramites
    $tmts = array();
    try{

      foreach ($tramits as $t) {
        $tmts []=array(
          'id_tramite'=> $t->Tipo_Code,
          'tramite' => $t->Tipo_Descripcion,
          'partidas' => $this->getPartidasTramites($t->Tipo_Code),
        );
      }

    }catch(\Exception $e){
      Log::info('Error Portal - ver Tramites: '.$e->getMessage());
    }

    return json_encode($tmts);
  }


  /**
  * Lista de solicitudes Actuales por tramite
  *
  *	@return data nombre solicitud y solicitud dependiente
  */

  public function getSolicitudes(Request $request){

    $id_tramite = $request->id_tramite;
    $solicitud = $this->solicitudes->where('tramite_id', $id_tramite)->where('padre_id', null)->get();

    $slctds = $slctd_hija = $check = array();

    try{
      foreach ($solicitud as $s) {
        $id_sol = $s->id;

        $hija = $this->solicitudes->where('padre_id', $id_sol)->get();
        if($hija->count() > 0){
          foreach ($hija as $h) {
            $id_solh = $h->id;

            $check = $this->getChild($id_solh);

            if(empty($check)){
              $slctd_hija []= array('id_solcitud' => $h->id,
                'tramite_id'  => $h->tramite_id,
                'padre_id'  =>  $h->padre_id,
                'titulo'  =>  $h->titulo,
                'atendido_por' => $h->atendido_por,
                'status'  =>  $h->status
                );
            }else{
              $slctd_hija []= array('id_solcitud' => $h->id,
                'tramite_id'  => $h->tramite_id,
                'padre_id'  =>  $h->padre_id,
                'titulo'  =>  $h->titulo,
                'atendido_por' => $h->atendido_por,
                'status'  =>  $h->status,
                'hijas'  => $check
                );
            }
            unset($check);
          }
        }

        //dd($slctd_hija);
        $slctds []=array(
          'id_solcitud' => $s->id,
          'tramite_id'  => $s->tramite_id,
          'padre_id'  =>  $s->padre_id,
          'titulo'  =>  $s->titulo,
          'atendido_por' => $s->atendido_por,
          'status'  =>  $s->status,
          'hijas'  => $slctd_hija
        );


        $slctd_hija = array();
      }
      //dd($slctds);
    }
    catch(\Exception $e) {
      Log::info('Error Portal Solicitudes - carga de Solicitudes: '.$e->getMessage());
    }

    return json_encode($slctds);
  }

  public function getChild($id_solh){

    $slctd_hija = array();

    $hija = $this->solicitudes->where('padre_id', $id_solh)->get();
    if($hija->count() > 0){
      foreach ($hija as $h) {

        $slctd_hija []= array('id_solcitud' => $h->id,
          'tramite_id'  => $h->tramite_id,
          'padre_id'  =>  $h->padre_id,
          'titulo'  =>  $h->titulo,
          'atendido_por' => $h->atendido_por,
          'status'  =>  $h->status
          );
      }
    }
    $test= json_encode($slctd_hija);
    //dd($test);

    return $slctd_hija;
  }


  /**
  * Lista de usuarios
  *
  *	@return json id, name, email
  */

  public function getUsers(){

    $usrs = $this->users->all();

    $user = array();

    try{
      foreach ($usrs as $u) {
        $user []=array(
          'id' => $u->id,
          'nombre' => $u->name,
          'email'  => $u->email,
        );
      }

    }
    catch(\Exception $e) {
      Log::info('Error Portal Solicitudes - consulta de usuarios: '.$e->getMessage());
    }

    return json_encode($user);
  }


  /**
  * Crear una nueva solicitud
  *
  *	@return response estatus code
  */
  public function crearSolicitud(Request $request){
    $id_tramite = $request->id_tramite;
    $padre_id = $request->padre_id;
    $titulo = $request->titulo;
    $atiende = $request->user;
    $status = $request->status;
    $users=explode(",",$atiende);
    try {

      $inser=$this->solicitudes->create([
        'tramite_id'=> $id_tramite,
        'padre_id'  =>  $padre_id,
        'titulo'    =>  $titulo,
        'atendido_por'=>  $atiende,
        'status'  =>  $status
      ]);
      foreach ($users as $e) {
        $ins=$this->solicitudrespdb->create(["user_id"=>$e,"catalogo_id"=>$inser->id]);
      }
      return response()->json(
        [
          "Code" => "200",
          "Message" => "Solicitud creada con éxito",
        ]
      );

    }catch(\Exception $e) {

      Log::info('Error Agregar nueva solicitud '.$e->getMessage());

      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al crear la solicitud",
        ]
      );
    }


  }
  /**
  * Editar solicitud
  *
  *	@return
  */
  public function editarSolicitud(Request $request){
    $id_solicitud = $request->id_solcitud;
    $id_tramite = $request->id_tramite;
    $padre_id = $request->padre_id;
    $titulo = $request->titulo;
    $atiende = $request->user;
    $status = $request->status;
    $users=explode(",",$atiende);
    //log::info($users);
    try{
      $del=$this->solicitudrespdb->deleteWhere(["catalogo_id"=>$id_solicitud]);
      foreach ($users as $e) {
        $ins=$this->solicitudrespdb->create(["user_id"=>$e,"catalogo_id"=>$id_solicitud]);
      }
      $solicitud = $this->solicitudes->update(['tramite_id'=>$id_tramite, 'padre_id'=>$padre_id, 'titulo' => $titulo,
    'atendido_por'=>$atiende, 'status'=>$status], $id_solicitud);

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
  /**
  * Eliminar Solicitud
  *
  *	@return
  */
  public function delete(Request $request){

    $id_solicitud = $request->id_solcitud;

    try {
      $del=$this->solicitudrespdb->deleteWhere(["catalogo_id"=>$id_solicitud]);
      $registro = $this->solicitudes->where('id', $id_solicitud)->get();

      if($registro->count() > 0){

        foreach ($registro as $r) {

          $id_solicitud = $r->id;

          $hijo = $this->solicitudes->where('padre_id', $id_solicitud)->get();

          if($hijo->count() > 0){

            return response()->json(
              [
                "Code" => "400",
                "Message" => "Error, esta solicitud no se puede eliminar",
              ]
            );

          }else {

            $solicitud = $this->solicitudes->delete($id_solicitud);

            return response()->json(
              [
                "Code" => "200",
                "Message" => "Solicitud eliminada",
              ]
            );

          }

        }
      }

    }catch(\Exception $e) {

      Log::info('Error Eliminar Solicitud '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Erro al intentar eliminar la solicitud",
        ]
      );
    }
  }

  /**
   *
   * getPartidasTramites . Busca en la tabla de partidas los valores
   *
   * @param $id es el valor del tramite
   *
   * @return Array con los valores de la partida
   *
   */

  public function getPartidasTramites($id)
  {
    $data = array();
    try{

      $info = $this->partidas->findWhere( ["id_servicio" =>  $id] );

      if($info->count() > 0){
        foreach($info as $i)
        {
          $data []= array(
            "id_partida"  => $i->id_partida,
            "descripcion" => $i->descripcion
          );
        }
      }else{
        $data = 0;
      }

    }catch(\Exception $e){
      Log::info('Error Eliminar Solicitud '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al getPartidasTramites",
        ]
      );
    }

    return $data;

  }
  public function filtrar(Request $request){
    $user_id = auth()->user()->id;
    
    $filtro = PortalSolicitudesticket::leftjoin('solicitudes_catalogo as c', 'c.id', '=', 'solicitudes_ticket.catalogo_id')
    ->leftjoin('solicitudes_tramite as tmt', 'tmt.id', '=', 'solicitudes_ticket.id_transaccion')
    ->where('solicitudes_ticket.status', '!=', 99)
    ->whereNotNull('solicitudes_ticket.id_transaccion')
    ->whereNotNull('solicitudes_ticket.grupo_clave')
    ->select("c.atendido_por", "c.id as id_catalogo" ,"solicitudes_ticket.id", "solicitudes_ticket.grupo_clave");
    if($request->has('tipo_solicitud')){
        $filtro->where('c.id', $request->tipo_solicitud);
    }
   
    if($request->has('estatus')){
      if($request->estatus ==0){
        $filtro->where('solicitudes_ticket.status', '<>', 2);
      }else{
        $filtro->where('solicitudes_ticket.status', $request->estatus);
      }
    }

    if($request->has('id_solicitud')){
      $filtro->where('solicitudes_ticket.id_transaccion','LIKE',"%$request->id_solicitud%")
      ->orWhere('tmt.id_transaccion_motor','LIKE',"%$request->id_solicitud%")
      ->orWhere('solicitudes_ticket.grupo_clave','LIKE',"%$request->id_solicitud%");
      
    }

    if($request->has("user_id")){
      $filtro->leftjoin('solicitudes_responsables as res', "solicitudes_ticket.catalogo_id", "=", "res.catalogo_id") 
      ->join('solicitudes_ticket_bitacora as tkb', "solicitudes_ticket.id", "=", "tkb.id_ticket")
      ->where("res.user_id", $request->user_id)
      ->where("res.catalogo_id", $request->tipo_solicitud)
      ->whereNotNull('res.id_estatus_atencion');
    }
  
    $cat = $filtro->get()->pluck("id_catalogo")->toArray();  
    $ids_catalogos= array_unique($cat);

    //  $responsables = $this->solicitudrespdb->whereIn("catalogo_id", $ids_catalogos)
    // ->get()->toArray();
   

    $filter = $filtro->groupBy('solicitudes_ticket.grupo_clave')
    ->get()->pluck('grupo_clave')->toArray();
    $grupo=array_filter($filter);
    
      // $catalogo = array_intersect($ids_catalogos, $responsables);
   
  
    $solicitudes =PortalSolicitudesTicket::from('solicitudes_ticket as tk')
    ->with("bitacora")
    ->select("tk.id", "c.titulo","tk.id_transaccion",
    "status.descripcion","tk.status",
    "tk.ticket_relacionado", "tk.asignado_a",
    "tk.info", 
    "c.id as catalogo", "tmt.id_transaccion_motor",
    "tk.created_at", "op.importe_transaccion", "servicio.Tipo_Descripcion as tramite", 
    "tk.grupo_clave", "pr.url_prelacion", "c.padre_id",
    "n.notary_number","n.titular_id","n.substitute_id",
    "n.phone","n.fax","n.email", "n.street", "n.number", "n.indoor-number", "n.district", "n.federal_entity_id",
    "n.city_id", "n.zip", "n.sat_constancy_file", "n.notary_constancy_file", "usert.name as nombre_titular", 
    "usert.fathers_surname as apellido_pat_titular","usert.mothers_surname as apellido_mat_titular", 
    "usert.status as status_titular", "u.name as nombre_usuario_tramite", "u.fathers_surname as apellido_pat_tramite",
    "u.mothers_surname as apellido_mat_tramite")
    ->leftJoin('portal.solicitudes_catalogo as c', 'tk.catalogo_id', '=', 'c.id')
    ->leftJoin('portal.solicitudes_status as status', 'tk.status', '=', 'status.id')
    ->leftJoin('portal.solicitudes_tramite as tmt', 'tk.id_transaccion', '=', 'tmt.id')
    ->leftjoin('operacion.oper_transacciones as op', 'tmt.id_transaccion_motor', '=', 'op.id_transaccion_motor')
    ->leftJoin('egobierno.tipo_servicios as servicio', 'c.tramite_id', 'servicio.Tipo_Code')
    ->leftJoin('portal.mensaje_prelacion as pr', 'tk.grupo_clave', 'pr.grupo_clave')
    ->leftJoin('portal.users as u', 'tk.user_id', 'u.id')
    ->leftJoin('portal.config_user_notary_offices as config', 'config.user_id', 'tk.user_id')
    ->leftJoin('portal.notary_offices as n', 'n.id', 'config.notary_office_id')
    ->leftJoin('portal.users as usert', 'n.titular_id', 'usert.id')
    ->orderBy('tk.created_at', 'ASC')
    ->whereIn('c.id',$ids_catalogos)->get();

    $newDato=[];

    foreach($grupo as $i => $id){
      $datos=[];
      $campos_catalogo = [];
      foreach ($solicitudes as $key => $value){   
        if($value->grupo_clave== $id){   
          if(isset($value->info)){  
            $value->info = json_decode($value->info);
            if(isset($value->info->campos)){
              $campos_catalogo = array_merge($campos_catalogo, array_keys((array)$value->info->campos));        
              $campos_catalogo = array_unique($campos_catalogo);
              $catalogo = DB::connection('mysql6')->table('campos_catalogue')->select('id', 'descripcion','alias')
              ->whereIn('id', $campos_catalogo)->get()->toArray();           
     
              $campos = [];
              foreach($value->info->campos as $key2 => $val){
                  if(is_numeric($key2)){
                    $key2 = $catalogo[array_search($key2, array_column($catalogo, 'id'))]->descripcion;
                    $campos[$key2] = $val;
                  } 
                  $value->info->campos = $campos;
                  
              }    
            }
          
          }
          if(!$value->bitacora->isEmpty()){
            foreach ($value->bitacora as $bit => &$bitacora) {             
                $estatus=EstatusAtencion::find($bitacora->id_estatus_atencion);
                $bitacora->nombre = $estatus->descripcion;
                $bitacora->catalogo = $value->catalogo;

                $res = Portalsolicitudesresponsables::from("solicitudes_responsables as r")
                ->where("r.catalogo_id", $bitacora->catalogo)
                ->where("r.id_estatus_atencion", $bitacora->id_estatus_atencion)
                ->where("r.user_id", $user_id)
                ->select('r.*', DB::raw('(CASE 
                  WHEN r.user_id = '."$user_id".' THEN "1" 
                  WHEN r.user_id = "null" THEN "1" 
                  ELSE "0" 
                  END) AS permiso'))
                ->first();
                if($res!=null){
                  $bitacora->permiso=$res->permiso;
                  $bitacora->responsables = $res;
                }else{
                  $bitacora->permiso=0;
                  $bitacora->responsables =[];
                }
               

            }
          }
     
          array_push($datos, $value);
          $newDato[$i]["grupo_clave"]=$id;
          $newDato[$i]["grupo"]=$datos;
        }
      
      }
    }
     return $newDato;
  }

  public function listSolicitudes(){

    $tipoSolicitud=$this->findSol();

    $user_id = auth()->user()->id;
  
    $responsable = Portalsolicitudesresponsables::where("user_id", $user_id)
    ->where("id_estatus_atencion", 5)
    ->first();

    $usuarios_atencion = Portalsolicitudesresponsables::from("portal.solicitudes_responsables as res")
    ->select("u.name", "u.email", "u.id as id_usuario")
    ->leftjoin("operacion.users as u", "u.id", "=", "res.user_id")
    ->whereNotNull("res.id_estatus_atencion")
    ->groupBy("res.user_id")
    ->get()->toArray();


    $atencion= $responsable!=null ? "true" : "false";
        
    $status = $this->userEstatus->where("id_usuario", $user_id)->first();

    if($status==null){
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Este usuario no tiene asignado estatus." 
        ]
      );
    }

    $status = json_decode($status->estatus);

    $status = $this->status->whereIn("id", $status)->get()->toArray();
    
    return view('portal/listadosolicitud', [
      "tipo_solicitud" => $tipoSolicitud , 
      "status" => $status, 
      "user_id"=>$user_id, 
      "atencion"=>$atencion,
      "usuarios_atencion"=>$usuarios_atencion
    ]);

  }
  public function findSol()
  {
    $user_id = auth()->user()->id;
    $tipoSolicitud = $this->solicitudes->findSolicitudes($user_id,null,null);
    $findSolPadres = $this->solicitudes->findSolicitudes(null,null,null);
    //log::info($findSolPadres);
    foreach ($findSolPadres as $k) {
      if($k["status"]<>null)
      {
        $tipoSolicitudHijo= $this->solicitudes->findSolicitudes($user_id,$k["id"],null);
        //log::info($tipoSolicitudHijo);
        foreach ($tipoSolicitudHijo as $i) {
          $arrayHijo=array();
            $arrayHijo []=array('titulo'=> $k["titulo"] . " / " . $i["titulo"] ,
              'id'=> $i["id"],
              'padre_id'=> $i["padre_id"]
            );

            $tipoSolicitud=array_merge($tipoSolicitud,$arrayHijo);
            $arrayHijo=array();
        }
        $soliTer=$this->solicitudes->findSolicitudes(null,$k["id"],null);

        foreach ($soliTer as $e) {
          $arrayTer=array();
            $tipoSolicitudTer= $this->solicitudes->findSolicitudes($user_id,$e["id"],null);
            //log::info($tipoSolicitudTer);
            foreach ($tipoSolicitudTer as $t) {
              $arrayTer []=array('titulo'=> $k["titulo"] . " / " . $e["titulo"] . " / " . $t["titulo"],
                'id'=> $t["id"],
                'padre_id'=> $t["padre_id"]
              );
              $tipoSolicitud=array_merge($tipoSolicitud,$arrayTer);
              $arrayTer=array();
            }
        }
      }

    }
    return $tipoSolicitud;

  }
  public function atenderSolicitud($id){
    $ticket = $this->ticket->where('id', $id)->first();
    //$findP=$this->ticket->findPrelacion($id);
    $id_transaccion = $ticket["id_transaccion"];
    $user_id = auth()->user()->id;
    // $asignar=  $this->ticket->where('id_transaccion',$id_transaccion)->update(["asignado_a"=>$user_id]); //se pone en otro enpoint

    //$msprelacion=array('mensaje_prelacion'=>$findP[0]["mensaje_prelacion"],'tramite_prelacion'=>$findP[0]["tramite_prelacion"],'tramite_id'=>$findP[0]["tramite_id"],'tramite'=>$findP[0]["tramite"]);

    $findsolicitudCatalogoHijo=$this->solicitudes->findWhere(['padre_id'=>$ticket["catalogo_id"]]);
    $con_solicitud=array('continuar_solicitud'=>$findsolicitudCatalogoHijo->count());

    $informacion = json_decode($ticket->info);
    $informacion = json_decode(json_encode($informacion), true);
    $campos = $informacion["campos"];
    $catalogo= $this->campo->select('id', 'descripcion')->get()->toArray();
    $keys = array_column($catalogo, 'id');
    $values = array_column($catalogo, 'descripcion');
    $combine = array_combine($keys, $values);
    $catalogue = array_intersect_key($combine, $campos);

    $camposnuevos = array_combine($catalogue, $campos);
    unset($informacion["campos"]);
    $informacion =array_merge(array("campos" =>$camposnuevos), $informacion);
    //$informacion =array_merge( $informacion,$msprelacion);
    $informacion =array_merge( $informacion,$con_solicitud);
    return $informacion;
  }


  public function guardarSolicitud(Request $request){
    $fecha=Carbon::now();
    $fecha=$fecha->format('Hms');
    $mensaje = $request->mensaje;
    $mensaje_para = $request->mensaje_para;
    $ticket_id = $request->id;
    $prelacion = $request->prelacion;
    $mensajes;
   
    if($request->has("file")){
      $file = $request->file('file');
      $extension = $file->getClientOriginalExtension();
      $attach = "archivo_solicitud_".$request->id[0].".".$extension;
      \Storage::disk('local')->put($attach,  \File::get($file));
    }else{
      $attach ="";
    }
    if($prelacion==1)
      {
        $attach= "doc_prelacion_".$request->grupo_clave."_".$fecha.".pdf";
        $this->savePdfprelacion($attach,$request->data);
        $this->msjprelaciondb->deleteWhere(['grupo_clave'=>$request->grupo_clave]);
        $msprelacion =$this->msjprelaciondb->create([
          'grupo_clave'=> $request->grupo_clave,'url_prelacion'=>$attach,'status'=>'1'
        ]);
         foreach($request->id as $i)
        {
          $mensajes =$this->mensajes->create([
          'ticket_id'=> $i,
          'mensaje' => $mensaje. " , Por: ".auth()->user()->name,
          'mensaje_para' => $mensaje_para,
          'attach'    =>  $attach
          ]);
        }
       /* foreach($request->tickets_id as $i)
        {
          $this->saveTicketBitacora($i,$request->grupo_clave,$request->id_estatus_atencion,auth()->user()->id,$mensaje,1);
        }*/
        $this->cerrarCrearTicket($request->tickets_id,$request->grupo_clave,$request->id,"Pasa a Validador",$request->id_estatus_atencion);
      }
    try {  
      if($request->rechazo=="true")
      {
        $rch=0;

        foreach($request->tickets_id as $i)
        {
          $newid=$i;
          $status="";
          switch ($request->rechazo_id) {
            case '50':
              $rch=7;
              break;
            case '51':
              $rch=8;
              break;
            case '52':
              $rch=2;
              break;
            default:
              $rch=1;
              break;
          }
          
          if($rch==2){
            $mensaje="Accion: ".$request->mensaje; 
            $this->cerrarCrearTicket($request->tickets_id,$request->grupo_clave,$request->id,$mensaje,$request->id_estatus_atencion);
          }else{            
            $mensaje="Motivo de rechazo: ".$request->mensaje;
            $this->msjprelaciondb->deleteWhere(['grupo_clave'=>$request->grupo_clave]);
            $findSolTicket=$this->ticket->findWhere(["id"=>$i]);

            $newCatalogoid=$findSolTicket[0]->catalogo_id;

            /*while(true)
            {                
              $findCatalogoPadre=$this->solicitudes->findWhere(["id"=>$newCatalogoid]);
              if($findCatalogoPadre[0]->padre_id==null)
              {
                $upTicket=$this->ticket->update(["catalogo_id"=>$newCatalogoid],$i);
                break;
              }else{
                 $newCatalogoid=$findCatalogoPadre[0]->padre_id;
              }           
            }*/
            if (in_array($i, (array)$request->id))
            {
              $ins=$this->ticket->update(["status"=>$rch],$i);
              $status=$rch;
            }else{
              $status=$findSolTicket[0]->status;
            }
            $this->saveTicketBitacora($i,$request->grupo_clave,$request->id_estatus_atencion,auth()->user()->id,$mensaje,$status);
          }
          
          $mensajes =$this->mensajes->create([
          'ticket_id'=> $i,
          'mensaje' => $mensaje. " , Por: ".auth()->user()->name,
          'mensaje_para' => $mensaje_para,
          'attach'    =>  $attach
          ]);
        }
      }else{
        foreach($request->id as $i)
        {
          $mensajes =$this->mensajes->create([
          'ticket_id'=> $i,
          'mensaje' => $mensaje. " , Por: ".auth()->user()->name,
          'mensaje_para' => $mensaje_para,
          'attach'    =>  $attach
          ]);
        }
      }

      return response()->json(
        [
          "Code" => "200",
          "Message" => "Mensaje guardado con éxito"
        ]
      );

    }catch(\Exception $e) {

      log::info($e);
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al guardar mensaje",
        ]
      );
    }
  }
  public function cerrarCrearTicket($ticket_id,$grupo_clave,$id,$mensaje,$id_estatus_atencion){
    //log::info($ticket_id); 
    try{
     
        foreach($ticket_id as $i)
        {   
          $findSolTicket=$this->ticket->findWhere(["id"=>$i]);
          foreach ($findSolTicket as $e) { 
            $status=$e->status;           
            if($id_estatus_atencion=="3"){
              $status="2";
              $ins=$this->ticket->update(["status"=>"2"],$e->id);
              $this->saveTicketBitacora($i,$grupo_clave,4,auth()->user()->id,$mensaje,$status);
            }else if($id_estatus_atencion==2){
               $this->saveTicketBitacora($i,$grupo_clave,3,null,$mensaje,$status);
            }else{
               $this->saveTicketBitacora($i,$grupo_clave,$id_estatus_atencion,auth()->user()->id,$mensaje,$status);
            }  
          }          
        }
      }catch(\Exception $e){
        Log::info('Error Cerrar Ticket '.$e->getMessage());
      }
    }
  private function updateStatusTicket($id,$status)
  {
    for($x=0; $x<6;$x++)
        {
          
          $findSoli=$this->ticket->findWhere(['id'=>$id]);
          if($findSoli->count()>0)
          {
            foreach ($findSoli as $k) {
              $id=$k->ticket_relacionado;
            }
            if($id==null)
            {
              break;
            }
          }
        }
  }
  public function cerrarTicket(Request $request){
      $id = $request->id;
      $id_catalogo=$request->id_catalogo;
      $option=$request->option;
      $catalogoH="";
      try{
        if($option=="continuar")
        {
          $findTicket=$this->ticket->findWhere(['ticket_relacionado'=>$id]);
          if($findTicket->count()>0)
          {
            //$solicitudTicket = $this->ticket->update(['status'=>1],$id);
            return response()->json(["Code" => "200", "Message" => "Ticket creado",]);
          }
          $findCatalogoHijo=$this->solicitudes->findWhere(["padre_id"=>$id_catalogo]);
          foreach ($findCatalogoHijo as $k) {
            $catalogoH=$k->id;
          }

          if($findCatalogoHijo->count()>0){
            $findSolTicket=$this->ticket->findWhere(["id"=>$id]);
            foreach ($findSolTicket as $e) {
              $ins=$this->ticket->create([
                "clave"=>$e->clave,
                "catalogo_id"=>$catalogoH,
                "id_transaccion"=>$e->id_transaccion,
                "info"=>$e->info,
                "relacionado_a"=>$e->relacionado_a,
                "ticket_relacionado"=>$e->id,
                "user_id"=>$e->user_id,
                "creado_por"=>$e->creado_por,
                "asignado_a"=>$e->asignado_a,
                "status"=>1
              ]);
            }
          }
          return response()->json(["Code" => "200", "Message" => "Ticket creado",]);
        }else if($option=="cerrar"){
          $this->updateStatusTicket($id,2);
          return response()->json(["Code" => "200","Message" => "Ticket cerrado",]);
        }
      }catch(\Exception $e){

        Log::info('Error Cerrar Ticket '.$e->getMessage());

        return response()->json(
          [
          "Code" => "400",
          "Message" => "Error al cerrar ticket",
          ]
        );
      }

    }
    public function getMensajes($id){
      try{ 
        $id=json_decode($id);
        //log::info($id);
        $mensajes=array();
         $findmensajes = $this->mensajes->whereIn('ticket_id', $id)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->toArray();


        /*$findSolicitudes=$this->ticket->findWhere(["id"=>$id]);
        $findMensajesPadre=[];
        log::info($findSolicitudes[0]["ticket_relacionado"]);
        if(isset($findSolicitudes[0]["ticket_relacionado"])){
          $findMensajesPadre = $this->mensajes->where('ticket_id', $findSolicitudes[0]["ticket_relacionado"])
          ->orderBy('created_at', 'DESC')
          ->get()
          ->toArray();

        }*/
        $mensajes=$findmensajes;
       // $mensajes=array_merge($findmensajes,$findMensajesPadre);


     
      }catch(\Exception $e){

        Log::info('Error Obtener Mensajes '.$e->getMessage());

        return response()->json(
          [
          "Code" => "400",
          "Message" => "Error al obtener mensajes",
          ]
        );
      }
      return json_encode($mensajes);
    }
    public function downloadFile($file)
    {
      try{
      $pathtoFile = storage_path('app/'.$file);
      return response()->download($pathtoFile);
      }catch(\Exception $e){
        log::info("error PortalSolicitudesController@downloadFile");
      }
    }
    public function getFileRoute($id, $type){
        $url= env("SESSION_HOSTNAME");
        $link = env("SESSION_HOSTNAME")."/notary-offices/file/"."$id/$type";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $route = curl_exec($ch);
        $error =curl_error($ch);
        curl_close($ch);
        $route=json_decode($route);
        return $url."/".$route->response;


    }

    public function updateStatus(Request $request){
      try {

        $solicitudTicket = $this->ticket->where('id' , $request->id)
        ->update(['status'=> $request->status]);

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
    public function getmotivos(){
      try{
        $motivos = $this->motivos->all();
      }
      catch(\Exception $e) {
        Log::info('Error Portal Solicitudes - consulta de motivos: '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al obtener motivos"
        ]);
      }

      return json_encode($motivos);
    }

      public function createsolicitudMotivos(Request $request){
      try{
        $solicitudesMotivos= $this->solicitudesMotivos->create([
          "motivo_id"=> $request->motivo_id,
          "solicitud_catalogo_id"=> $request->solicitud_catalogo_id

        ]);

        return response()->json(
          [
            "Code" => "200",
            "Message" => "Solicitud motivo agregado"
        ]);
      }
      catch(\Exception $e) {
        Log::info('Error Portal Solicitudes - Crear/editar solicitudes motivos '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error"
          ]);
      }

    }

    public function getSolicitudesMotivos($solicitud_catalogo_id="",Request $request){
      try{
         //Log::info($request->solicitud_catalogo_id);
        $solicitudesMotivos = SolicitudesMotivo::select('solicitudes_motivo.motivo_id', 'motivos.motivo','solicitudes_motivo.solicitud_catalogo_id')
        ->leftjoin('motivos',  'motivos.id', '=','solicitudes_motivo.motivo_id')->groupBy('solicitudes_motivo.motivo_id');

        if($request->solicitud_catalogo_id){
          $solicitudesMotivos->whereIn('solicitudes_motivo.solicitud_catalogo_id', $request->solicitud_catalogo_id);
        }
        $solicitudesMotivos=$solicitudesMotivos->get();
        // Log::info($solicitudesMotivos);
      }
      catch(\Exception $e) {
        Log::info('Error Portal Solicitudes - consulta de motivos: '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al obtener motivos"
        ]);
      }

      return json_encode($solicitudesMotivos);
    }
    public function deleteSolicitudMotivo(Request $request){
      try{
        $solicitudesMotivosDelete = $this->solicitudesMotivos
        ->where("motivo_id", $request->motivo_id)
        ->where("solicitud_catalogo_id", $request->solicitud_catalogo_id)
        ->delete();
      }
      catch(\Exception $e) {
        Log::info('Error Portal Solicitudes - error eliminar: '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al eliminar solicitud motivos"
        ]);
      }
    }
    public function findFirmaTramite($tramite_id="")
    {
      try{
        $findSoli = $this->solicitudes->findWhere(["tramite_id"=>$tramite_id]);
        return json_encode($findSoli);
      }
      catch(\Exception $e) {
        Log::info('Error Portal Solicitudes - error buscar firma: '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al buscar firma"
        ]);
      }
    }
    public function updateFirmaTramite(Request $request)
    {
      try{
        $findSoli = $this->solicitudes->where('tramite_id',$request->tramite_id)->update(["firma"=>$request->firma]);
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Actualizado correctamente"
        ]);
      }
      catch(\Exception $e) {
        Log::info('Error Portal Solicitudes - error buscar firma: '.$e->getMessage());
        return response()->json(
          [
            "Code" => "400",
            "Message" => "Error al buscar firma"
        ]);
      }
    }
    private function savePdfprelacion($path,$data)
    {$request=array();
      //$data=json_decode($data);
        //log::info($data);
      foreach($data as $d => $reg)
      {
        $reg=json_decode($reg);
         //log::info((array)$reg);
         
        if($reg->fecha==null)
        {
          $fecha=Carbon::now();
          $hora=$fecha->toTimeString();
          $fecha=$fecha->format('Y/m/d');
          $folio=999999999;
          $reg = (object) array_merge((array) $reg, array('folio'=>$folio,'fecha'=>$fecha,'hora'=>$hora));
        }else{
          $fecha=Carbon::parse($reg->fecha);          
          $fecha=$fecha->format('Y/m/d');
          $hora=Carbon::now();
          $hora=$hora->toTimeString();
          $reg = (object) array_merge((array) $reg, array('fecha'=>$fecha,'hora'=>$hora));
        }
        
        
        $formatter = new NumeroALetras();
        $letras= $formatter->toMoney($reg->costo_final, 2,"PESOS","CENTAVOS");
        $importe_letra=$letras ." 00/100 M.N.";
        $reg = (object) array_merge((array) $reg, array('importe_letra'=>$importe_letra));
        $barcode=DNS1D::getBarcodePNG($reg->folio, 'C39',1,33);
        $reg = (object) array_merge((array) $reg, array('barcode'=>$barcode));
        $request []=$reg;
      }  

      //log::info(json_encode($request));


      $path=storage_path('app/'.$path);
      $options= new Options();
      $options->set('isHtml5ParserEnabled',true);
      $options->set('isRemoteEnabled',true);
      $dompdf = new DOMPDF($options);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->set_option('dpi', '135');
      $html=View::make('documentos/prelacion',['data'=>$request])->render();
     // log::info($html);
      $dompdf->load_html( $html);
      $dompdf->render();
      $output=$dompdf->output();
      File::put($path,$output);
    }
  public function viewpermisosdocumentos()
  {
    return view('portal/permisosdocumentos');
  }

  public function saveFile(Request $request)
  {
    
    try {
      //log::info($request->all());
      $fech=Carbon::now();
      $fech=$fech->format("Hms");
      $file = $request['file'];
      $extension = $file->getClientOriginalExtension();
      $nombre = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $name = $nombre . "-" . $request->ticket_id . $fech . "." . $extension;
      $attach = $this->url->to('/') . '/download/'.$name;
      $path=storage_path('app/'.$name);
      \Storage::disk('local')->put($name,  \File::get($file));
      if($request->id_mensaje!=null)
      {
        $this->mensajes->update(["status"=>"0"],$request->id_mensaje); 
      }
      $this->saveDocBitacora($request->ticket_id,$attach,"documento nuevo");
      $this->mensajes->create(["clave"=>$request->clave,"attach"=>$attach,"ticket_id"=>$request->ticket_id,"mensaje"=>"CALCULO DEL ISR CONFORME AL 126 LISR O COMPROBANTE DE LA EXENCIÓN","status"=>'1']);
      if(preg_match("/https:/", $attach)) $attach = str_replace("https", "http", $attach);
      $imageData = base64_encode(file_get_contents($attach));
      return response()->json([
        "Code" => "200",
        "Message" => "Guardado correctamente",
        "file_name_new"=>$name,
        "file_attach"=>$attach,
        "file_data"=>$imageData
      ]);
    } catch (Exception $e) {
      log::info("PortalSolicitudesController@saveFile ").$e;
      return response()->json([
        "Code" => "400",
        "Message" => "Error al guardar"
      ]);
    }
  }
  public function saveDocBitacora($ticket_id,$attch,$descripcion)
  {
    try {
      $this->docbitacoradb->create(["ticket_id"=>$ticket_id,"attach"=>$attch,"descripcion"=>$descripcion,"user_id"=>auth()->user()->id]);
    } catch (Exception $e) {
      log::info("PortalSolicitudesController@saveDocBitacora ").$e;
    }
  }
  public  function findTicketidFolio(Request $request)
  {
    try {
      $folios=array();
      $resp=array();
      $response=array();
      if($request->tipo=="fse")
      {
        $findFolios=$this->ticket->findWhere(["id_transaccion"=>$request->folio]);
        if($findFolios->count()>0){ 
          foreach ($findFolios as $f) {
            $folios []= $f->id;
          }
        }else{
          return response()->json(["Code" => "200","Message" =>[]]);
        }
      }else if($request->tipo=="folio_pago"){
        $findFolios=$this->tramitesdb->findWhere(["id_transaccion_motor"=>$request->folio]);
        if($findFolios->count()>0){
          $folios=json_decode($findFolios[0]->id_ticket);
        }else{
           return response()->json(["Code" => "200","Message" =>[]]);
        }
      }else{
        $findFolios=$this->ticket->findWhere(["id"=>$request->folio]);       
        if($findFolios->count()>0){
           $findFolios=$this->ticket->findWhere(["id_transaccion"=>$findFolios[0]->id_transaccion,"clave"=>$findFolios[0]->clave]);
          if($findFolios->count()>0){
            foreach ($findFolios as $f) {
              $folios []= $f->id;
            }
          }else{
             return response()->json(["Code" => "200","Message" =>[]]);
          }
        }
      }
      $clave_unique=array();
      $findTickets=$this->ticket->findTicket('id',$folios)->toArray();
      foreach ($findTickets as $key => $value) {
            $clave_unique []=$value["clave"];
      }
      
      $clave_unique=array_unique($clave_unique);
      foreach ($clave_unique as $k) {
        $id_transaccion_motor="";
        $id_transaccion="";
        $num_notaria="";
        $notario="";
        $FechaEscritura="";
        $Escritura="";
        $info=array();
        $grupo=array();
        $tickets_id=array();
        foreach ($findTickets as $e => $v) {
          if($k==$v["clave"])
          {
            $id_transaccion_motor=$v["id_transaccion_motor"];
            $id_transaccion=$v["id_transaccion"];
            $num_notaria=$v["notary_number"];
            $notario=$v["name_notary"] ." ". $v["ap_pat_notary"] ." ". $v["ap_mat_notary"];
            $info=json_decode($v["info"]);
            foreach ($info->camposConfigurados as $i) {
              if($i->tipo=="enajenante")
              {
                $FechaEscritura=$i->valor->enajenantes[0]->detalle->Entradas->fecha_escritura;
              }
              if($i->nombre=="Escritura")
              {
                $Escritura= $i->valor;
              }
             } 
            $grupo []=$v;
            $tickets_id []=$v["id"];
          }           
        }
        $file_data="";
        $file_extension="";
        $file_name="";
        $id_mensaje="";
        $attach="";
        $findAttach=$this->mensajes->WhereIn('ticket_id',$tickets_id)->where('attach','<>',null)->where('status',"1")->get();
        foreach ($findAttach as $key => $value) {
          $imageData='';
          
          $attach=$value["attach"];
          $file_name=explode("/",$attach);        
          $file_name=$file_name[count($file_name)-1];
          if($attach<>null)
          { 
            $id_mensaje=$value["id"];         
            $extension=explode(".",$file_name); 
            $file_extension=$extension[count($extension)-1];
            //log::info($attach);
            if(preg_match("/https:/", $attach)) $attach = str_replace("https", "http", $attach);
            $imageData = base64_encode(file_get_contents($attach));            
            $file_data=$imageData;
          }
        }

        $response []=array(
          "clave"=> $k,
          "id_transaccion_motor"=> $id_transaccion_motor,
          "id_transaccion"=> $id_transaccion,         
          "num_notaria"=> $num_notaria,         
          "notario"=> $notario,         
          "fecha_escritura"=> $FechaEscritura,         
          "escritura"=> $Escritura,         
          "tickets_id"=> $tickets_id,
          "id_mensaje"=> $id_mensaje,
          "file_data"=>$file_data,
          "file_extension"=>$file_extension,
          "file_name"=>$file_name,       
          "file_attach"=>$attach,       
          "grupo"=>$grupo
        );
      }
      return $response;

    } catch (Exception $e) {
     return response()->json(
          [
            "Code" => "400",
            "Message" =>"Error al buscar el Folio"
        ]);   
    }
  }
  public function updatePermisoSolicitud(Request $request)
  {
    //log::info($request->all());
    try {
      $folios=json_decode(json_decode($request->id ));
      //log::info($folios);
      foreach ($folios as $k) {
        $this->saveDocBitacora($k,"","Permiso ".(string)$request->required_docs);
      $response=$this->ticket->where("id",$k)->update(['required_docs'=>$request->required_docs]);

      }
      

      return response()->json(["Code" => "200", "Message" =>"Actualizado correctamente" ]); 

    } catch (Exception $e) {
     return response()->json([
            "Code" => "400",
            "Message" =>"Error al actualizar permisos"
        ]);   
    }
  }
  public function findDetalleSolicitud($idticket)
  {
    $ticket = $this->ticket->where('id', $idticket)->first();

    $informacion = json_decode($ticket->info);
    $informacion = json_decode(json_encode($informacion), true);
    $campos = $informacion["campos"];
    $catalogo= $this->campo->select('id', 'descripcion')->get()->toArray();
    $keys = array_column($catalogo, 'id');
    $values = array_column($catalogo, 'descripcion');
    $combine = array_combine($keys, $values);
    $catalogue = array_intersect_key($combine, $campos);

    $camposnuevos = array_combine($catalogue, $campos);
    unset($informacion["campos"]);
    $informacion =array_merge(array("campos" =>$camposnuevos), $informacion);

    return $informacion;
  }

  public function getInfoNotary($user){
    try {
      $users = $this->configUserNotary->where("user_id" , $user)->first();
      $notary = $this->notary->where("id", $users->notary_office_id)->first();
         return response()->json(
          [
            "Code" => "200",
            "Message" =>"Informacion de la notaria",
            "data"=> $notary
        ]);  
    } catch (Exception $e) {
     return response()->json(
          [
            "Code" => "400",
            "Message" =>"Error al encontrar notaria"
        ]);   
    }
  }

  public function asignarSolicitud($id){
      $ticket = $this->ticket->where('id', $id)->first();
      //$findP=$this->ticket->findPrelacion($id);
      $grupo = $ticket["grupo_clave"];
      $user_id = auth()->user()->id;
      try {
        $asignar=  $this->ticket->where('grupo_clave',$grupo)->update(["asignado_a"=>$user_id]);
           return response()->json(
            [
              "Code" => "200",
              "Message" =>"Solicitud asignada"
          ]);  
      } catch (Exception $e) {
        Log::info('Error Portal - asignar solicitud: '.$e->getMessage());
       return response()->json(
            [
              "Code" => "400",
              "Message" =>"Error al asignar solicitud"
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
  public   function configdocprelacion()
  {
      return json_encode(config('docprelacion'));
  }
  public   function upStatusRechazo(Request $request)
  {
    //log::info($request->all());
    try {
        $id=$request->tickets_id;
        $rch=0;
        foreach($id as $i)
        {
          $newid=$i;
          $status="";
          $mensaje="";
          switch ($request->estatus) {
            case '50':
              $rch=7;
              break;
            case '51':
              $rch=8;
              break;
            case '52':
              $rch=2;
              break;
            default:
              $rch=1;
              break;
          }
          
          if($rch==2){
            $mensaje="Accion: ".$request->mensaje; 
            $this->cerrarCrearTicket($request->tickets_id,$request->grupo_clave,$request->id,$mensaje,$request->id_estatus_atencion);
          }else{            
            $mensaje="Motivo de rechazo: ".$request->mensaje;
            $this->msjprelaciondb->deleteWhere(['grupo_clave'=>$request->grupo_clave]);
            $findSolTicket=$this->ticket->findWhere(["id"=>$i]);

            $newCatalogoid=$findSolTicket[0]->catalogo_id;

           /* while(true)
            {                
              $findCatalogoPadre=$this->solicitudes->findWhere(["id"=>$newCatalogoid]);
              if($findCatalogoPadre[0]->padre_id==null)
              {
                $upTicket=$this->ticket->update(["catalogo_id"=>$newCatalogoid],$i);
                break;
              }else{
                 $newCatalogoid=$findCatalogoPadre[0]->padre_id;
              }           
            }*/
            if (in_array($i, $request->id))
            {
              $ins=$this->ticket->update(["status"=>$rch],$i);
              $status=$rch;
            }else{
              $status=$findSolTicket[0]->status;
            }
            $this->saveTicketBitacora($i,$request->grupo_clave,$request->id_estatus_atencion,auth()->user()->id,$mensaje,$status);
          }
          //$ins=$this->ticket->whereIn("id",$request->id)->update(["status"=>$rch]);
           $mensajes =$this->mensajes->create([
            'ticket_id'=> $i,
            'mensaje' => $mensaje . " , Por: ".auth()->user()->name,
            'mensaje_para' => 1,
            'attach'    =>  ""
            ]);          
        }
        
        return response()->json(
            [
              "Code" => "200",
              "Message" =>"Actualizado correctamente"
          ]);
      } catch (\Exception $e) {
          log::info("PortalSolicitudesticket@upStatusRechazo " . $e);
         return response()->json(
            [
              "Code" => "400",
              "Message" =>"Error al asignar solicitud"
          ]);
      }  
  }
  public  function findPrelacionDoc($grupo_clave)
  {
    try{
      $url="0";
      $findprl=$this->msjprelaciondb->findWhere(['grupo_clave'=>$grupo_clave,'status'=>1]);
      foreach ($findprl as $f) {
        $url=$f->url;
      }
    }catch (\Exception $e) {
      log::info("PortalSolicitudesticket@findPrelacionDoc " . $e);
      return "0";
    }
    return $url;
  }
  public  function getEstatusAtencion()
  {
    try{
     $estatus = EstatusAtencion::get()->toArray();
     return $estatus;
    }catch (\Exception $e) {
      log::info("PortalSolicitudes@getEstatusAtencion " . $e);
      return "0";
    }
  }

  public function agregarResponsableEstatusAtencion(Request $request){
    $id_tramite = $request->catalogo_id;
    $status = $request->id_estatus_atencion;
    $atiende = $request->user;
    $users=explode(",",$atiende);
    try {

  
      foreach ($users as $e) {
        $responsables=$this->solicitudrespdb->create([
        "user_id"=>$e,
        "catalogo_id"=>$id_tramite,
        "id_estatus_atencion"=>$status
      ]);
      }
      return response()->json(
        [
          "Code" => "200",
          "Message" => "Solicitud asignada con éxito",
        ]
      );

    }catch(\Exception $e) {

      Log::info('Error Asignar solicitud '.$e->getMessage());

      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al agregar responsable a la solicitud",
        ]
      );
    }

  }

  public function editarAtenderSolicitud(Request $request){
    $tramite_id = $request->catalogo_id;
    $atiende = $request->user;
    $status = $request->id_estatus_atencion;
    $users=explode(",",$atiende);
    try{

      $del = Portalsolicitudesresponsables::where('catalogo_id', '=', $tramite_id)
            ->whereIn('id_estatus_atencion', $status)->get();

      $del->each->delete();

      foreach ($users as $e) {
        $responsable=$this->solicitudrespdb->create([
          "user_id"=>$e,
          "catalogo_id"=>$tramite_id,
          "id_estatus_atencion"=>$status
        ]);
      }


    return response()->json(
      [
        "Code" => "200",
        "Message" => "Atender solicitud actualizada",
      ]
    );

    }catch(\Exception $e){

      Log::info('Error editar atender solicitud '.$e->getMessage());

      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error editar atender solicitud ".$e->getMessage(),
        ]
      );
    }

  }
  public function getAllProcesos($id){
    try{
      $procesos = $this->getEstatusAtencion();
      $responsables = Portalsolicitudesresponsables::where('catalogo_id', '=', $id)
      ->get();
     
      foreach ($procesos as $key => &$value) {
      $users=[];

        foreach ($responsables as $r => $res) {
          if($res->id_estatus_atencion==$value["id"]){
            $user=Users::find($res->user_id);
            $users[]=array(
              'id' => $user->id,
              'nombre'  =>$user->name,
              'correo' => $user->email
            );
            $value["users"]=$users;

          }
        }
       
      }
      return $procesos;
    }
    catch(\Exception $e) {
      Log::info('Error Portal Solicitudes - Obtener procesos de solicitudes: '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al obtener procesos" .$e->getMessage()
        ]
      );
    }
  }
  public function agregarTicketBitacora(Request $request){
    $data = $request->all();
    try {
      $create = TicketBitacora::create($data);
      if($create){
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Ticket agregado a bitacora "
          ]
        );
      }
    
    } catch (\Exception $e) {
      Log::info('Error Portal Solicitudes - registro de bitacora: '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al obtener procesos" .$e->getMessage()
        ]
      );
    }
  }
  private function saveTicketBitacora($ticket_id,$grupo_clave,$id_estatus_atencion,$user_id,$mensaje,$status)
  {
    try {
      $findInfoTicket=$this->ticket->findWhere(["id"=>$ticket_id]);
      $this->ticketBitacoradb->create(["id_ticket"=>$ticket_id,"grupo_clave"=>$grupo_clave,"id_estatus_atencion"=>$id_estatus_atencion,"info"=>$findInfoTicket[0]->info,"user_id"=>$user_id,"mensaje"=>$mensaje,"status"=>$status]);
    } catch (Exception $e) {
      log::info("saveTicketBitacora: ".$e);
    }
      
  }

  public function revertirStatus(Request $request){
    $user_id = auth()->user()->id;
    $tickets = $request->id_ticket;
    $status = $request->status;
    $estatus_atencion=$request->estatus_atencion;
    $mensaje = $request->has("mensaje") ? $request->mensaje : "";

    $responsable = Portalsolicitudesresponsables::where("user_id", $user_id)
    ->where("id_estatus_atencion", 5)
    ->first();
    try {
      if($responsable!=null){       
        foreach ($tickets as $i => $id) {
            $ticket = PortalSolicitudesTicket::where('id',$id)->first();         
            $update = $ticket->update(["status"=> $status]);
            $bitacora = $this->saveTicketBitacora($id,$ticket->grupo_clave,$estatus_atencion, $user_id,$mensaje="", $status);
         

        }
        return response()->json(
          [
            "Code" => "200",
            "Message" => "Se actualizo estatus"
          ]
        );

      }else{
        return response()->json(
          [
            "Code" => "409",
            "Message" => "No tiene permisos de supervisor"
          ]
        );
      }
    } catch (\Exception $e) {
      Log::info('Error Portal Solicitudes - actualizar status: '.$e->getMessage());
      return response()->json(
        [
          "Code" => "409",
          "Message" => "Error al revertir status" .$e->getMessage()
        ]
      );
    }
    
  }

  public function viewFile($file)
    {
      try{
      $pathtoFile = storage_path('app/'.$file);
      return response()->file($pathtoFile);
      }catch(\Exception $e){
        log::info("error PortalSolicitudesController@viewFile");
      }
    }


  /**
	 *	
	 * notify. Este metodo es para la modificacion de enviar el correo 
	 *
	 * @param $id => para buscar el id en la tabla
	 *
	 * @return 99 si error 100 si todo correcto
	 *
	 */
	public function notify($id, $folio){

        $table = new NotificacionEstatusAtencion();
        $mail = new PHPMailer(true);

        $user = UsersPortal::findOrFail($id);
			  $correo= $user->email;

        $encabezado="Notificacion de Resolucion";
        $mensaje="Tu tramite fue aprobado";
        $nombre =$user->name." ".$user->fathers_surname." ".$user->mothers_surname;
         
        $message=$this->plantillaEmail($encabezado,$nombre,$folio, $mensaje);
        //log::info($correo.'  '.$nombre.' '.$folio);
        try{
            
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth =true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587'; 
            $mail->Username = 'karlacespedesgob@gmail.com';
            $mail->Password = 'cespedes2020';
            $mail->setFrom('karlacespedesgob@gmail.com', 'noreply tesoreria'); 
            $mail->Subject = 'GOBIERNO DEL ESTADO DE NUEVO LEÓN';
            $mail->MsgHTML($message);                    
            $mail->addAddress($correo, $nombre); 
            $mail->send();

            
            $table->create(
              [
                  "user"      => $correo,
                  "message"   => $message,
                  "sent"      => 1 
              ]
          );
          return  1;
        }catch(phpmailerException $e){
          \Log::info("Error email => ".$e->getMessage());
          return 99;
        }
		

	}
  private function plantillaEmail($encabezado,$nombre,$folio,$mensaje, $url="",$footer="")
  {
    $email='<!doctype html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Egobierno</title>
        <style> 
          img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%; 
          }
          body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%; 
          }
          table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%; }
            table td {
              font-family: sans-serif;
              font-size: 14px;
              vertical-align: top; 
          }
          .body {
            background-color: #f6f6f6;
            width: 100%; 
          }
          .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 780px;
            padding: 10px;
            width: 780px; 
          }
          .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 680px;
            padding: 10px; 
          }
          .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%; 
          }

          .wrapper {
            box-sizing: border-box;
            padding: 20px; 
          }

          .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
          }

          .footer {
            clear: both;
            margin-top: 10px;
            text-align: center;
            width: 100%; 
          }
          .footer td,
          .footer p,
          .footer span,
          .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center; 
          }
          h1,
          h2,
          h3,
          h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px; 
          }

          h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize; 
          }

          p,
          ul,
          ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px; 
          }
            p li,
            ul li,
            ol li {
              list-style-position: inside;
              margin-left: 5px; 
          }

          a {
            color: #3498db;
            text-decoration: underline; 
          }
          .btn {
            box-sizing: border-box;
            width: 100%; }
            .btn > tbody > tr > td {
              padding-bottom: 15px; }
            .btn table {
              width: auto; 
          }
          .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center; 
          }
          .btn a {
            background-color: #ffffff;
            border: solid 1px #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            color: #3498db;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize; 
          }
          .btn-primary table td {
            background-color: #3498db; 
          }

          .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff; 
          }
          .last {
            margin-bottom: 0; 
          }

          .first {
            margin-top: 0; 
          }

          .align-center {
            text-align: center; 
          }

          .align-right {
            text-align: right; 
          }

          .align-left {
            text-align: left; 
          }

          .clear {
            clear: both; 
          }

          .mt0 {
            margin-top: 0; 
          }

          .mb0 {
            margin-bottom: 0; 
          }

          .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0; 
          }

          .powered-by a {
            text-decoration: none; 
          }

          hr {
            border: 0;
            border-bottom: 1px solid #bebebe;
            margin: 20px 0; 
          }
          @media only screen and (max-width: 620px) {
            table[class=body] h1 {
              font-size: 28px !important;
              margin-bottom: 10px !important; 
            }
            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
              font-size: 16px !important; 
            }
            table[class=body] .wrapper,
            table[class=body] .article {
              padding: 10px !important; 
            }
            table[class=body] .content {
              padding: 0 !important; 
            }
            table[class=body] .container {
              padding: 0 !important;
              width: 100% !important; 
            }
            table[class=body] .main {
              border-left-width: 0 !important;
              border-radius: 0 !important;
              border-right-width: 0 !important; 
            }
            table[class=body] .btn table {
              width: 100% !important; 
            }
            table[class=body] .btn a {
              width: 100% !important; 
            }
            table[class=body] .img-responsive {
              height: auto !important;
              max-width: 100% !important;
              width: auto !important; 
            }
          }
          @media all {
            .ExternalClass {
              width: 100%; 
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
              line-height: 100%; 
            }
            .apple-link a {
              color: inherit !important;
              font-family: inherit !important;
              font-size: inherit !important;
              font-weight: inherit !important;
              line-height: inherit !important;
              text-decoration: none !important; 
            }
            #MessageViewBody a {
              color: inherit;
              text-decoration: none;
              font-size: inherit;
              font-family: inherit;
              font-weight: inherit;
              line-height: inherit;
            }
            .btn-primary table td:hover {
              background-color: #34495e !important; 
            }
            .btn-primary a:hover {
              background-color: #34495e !important;
              border-color: #34495e !important; 
            } 
          }
        </style>
      </head>
      <body class="">  
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
          <tr>
            <td>&nbsp;</td>
            <td class="container">
              <div class="content">
                <table role="presentation" class="main">
                  <tr>
                    <td class="wrapper">
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>
                          <center><h2><strong>'.$encabezado.'</strong></h2></center> 
                          <center><h3>'.$nombre.'</h3></center> 
                          <div style="text-align:right;"> <p>'.$folio.'</p></div>
                          <hr style="color:#000;">             
                            <br>
                            <p>Datos: </p>
                            <p>'.$mensaje.' </p> 
                            <br>
                            <!--<p></p>-->
                            <br>
                            <br>
                            
                            <br> <br>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                              <tbody>
                                <tr>
                                  <td align="left">
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                      <tbody >
                                        <tr> </td>
                                        <!-- <td whidth="100%" align="center"> <a href="" target="_blank">Ver Recibo</a> </td>-->
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </div></td><td>&nbsp;</td></tr>
            </table>
          </body>
    </html>
  ';
  return $email;
  }


  public function plantilla()
  {
    $folio=3158;
    $encabezado="Expediente aprobado en IRCNL";
    $mensaje="Tu trámite con número de folio $folio fue aprobado por el
    registrador asignado. Por favor, recoge tu expediente con el trámite
    terminado en el Módulo de Entrega de Documentos dentro de 2
    días hábiles. Si tienes dudas sobre el uso de esta plataforma
    puedes llamar a Informatel 070.";
    $nombre="Karla Cespedes";
   
      $email='<!doctype html><html><head><meta name="viewport" content="width=device-width" /><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Egobierno</title><style> 
    img {
      border: none;
      -ms-interpolation-mode: bicubic;
      max-width: 100%; 
    }
    body {
      background-color: #f6f6f6;
      font-family: sans-serif;
      -webkit-font-smoothing: antialiased;
      font-size: 14px;
      line-height: 1.4;
      margin: 0;
      padding: 0;
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%; 
    }
    table {
      border-collapse: separate;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      width: 100%; }
      table td {
        font-family: sans-serif;
        font-size: 14px;
        vertical-align: top; 
    }
    .body {
      background-color: #f6f6f6;
      width: 100%; 
    }
    .container {
      display: block;
      margin: 0 auto !important;
      /* makes it centered */
      max-width: 780px;
      padding: 10px;
      width: 780px; 
    }
    .content {
      box-sizing: border-box;
      display: block;
      margin: 0 auto;
      max-width: 680px;
      padding: 10px; 
    }
    .main {
      background: #ffffff;
      border-radius: 3px;
      width: 100%; 
    }

    .wrapper {
      box-sizing: border-box;
      padding: 20px; 
    }

    .content-block {
      padding-bottom: 10px;
      padding-top: 10px;
    }

    .footer {
      clear: both;
      margin-top: 10px;
      text-align: center;
      width: 100%; 
    }
      .footer td,
      .footer p,
      .footer span,
      .footer a {
        color: #999999;
        font-size: 12px;
        text-align: center; 
    }
    h1,
    h2,
    h3,
    h4 {
      color: #000000;
      font-family: sans-serif;
      font-weight: 400;
      line-height: 1.4;
      margin: 0;
      margin-bottom: 30px; 
    }

    h1 {
      font-size: 35px;
      font-weight: 300;
      text-align: center;
      text-transform: capitalize; 
    }

    p,
    ul,
    ol {
      font-family: sans-serif;
      font-size: 14px;
      font-weight: normal;
      margin: 0;
      margin-bottom: 15px; 
    }
      p li,
      ul li,
      ol li {
        list-style-position: inside;
        margin-left: 5px; 
    }

    a {
      color: #3498db;
      text-decoration: underline; 
    }
    .btn {
      box-sizing: border-box;
      width: 100%; }
      .btn > tbody > tr > td {
        padding-bottom: 15px; }
      .btn table {
        width: auto; 
    }
      .btn table td {
        background-color: #ffffff;
        border-radius: 5px;
        text-align: center; 
    }
      .btn a {
        background-color: #ffffff;
        border: solid 1px #3498db;
        border-radius: 5px;
        box-sizing: border-box;
        color: #3498db;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        margin: 0;
        padding: 12px 25px;
        text-decoration: none;
        text-transform: capitalize; 
    }
    .btn-primary table td {
      background-color: #3498db; 
    }

    .btn-primary a {
      background-color: #3498db;
      border-color: #3498db;
      color: #ffffff; 
    }
    .last {
      margin-bottom: 0; 
    }

    .first {
      margin-top: 0; 
    }

    .align-center {
      text-align: center; 
    }

    .align-right {
      text-align: right; 
    }

    .align-left {
      text-align: left; 
    }

    .clear {
      clear: both; 
    }

    .mt0 {
      margin-top: 0; 
    }

    .mb0 {
      margin-bottom: 0; 
    }

    .preheader {
      color: transparent;
      display: none;
      height: 0;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
      mso-hide: all;
      visibility: hidden;
      width: 0; 
    }

    .powered-by a {
      text-decoration: none; 
    }

    hr {
      border: 0;
      border-bottom: 1px solid #bebebe;
      margin: 20px 0; 
    }
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important; 
      }
      table[class=body] p,
      table[class=body] ul,
      table[class=body] ol,
      table[class=body] td,
      table[class=body] span,
      table[class=body] a {
        font-size: 16px !important; 
      }
      table[class=body] .wrapper,
      table[class=body] .article {
        padding: 10px !important; 
      }
      table[class=body] .content {
        padding: 0 !important; 
      }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important; 
      }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important; 
      }
      table[class=body] .btn table {
        width: 100% !important; 
      }
      table[class=body] .btn a {
        width: 100% !important; 
      }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important; 
      }
    }
    @media all {
      .ExternalClass {
        width: 100%; 
      }
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
        line-height: 100%; 
      }
      .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important; 
      }
      #MessageViewBody a {
        color: inherit;
        text-decoration: none;
        font-size: inherit;
        font-family: inherit;
        font-weight: inherit;
        line-height: inherit;
      }
      .btn-primary table td:hover {
        background-color: #34495e !important; 
      }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important; 
      } 
    }
  </style>
  </head>
  <body class="">  
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
      <td>&nbsp;</td>
      <td class="container">
        <div class="content">
          <table role="presentation" class="main">
            <tr>
              <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>
                     <center><h2><strong>'.$encabezado.'</strong></h2></center> 
                     <h3>Estimado(a) '.$nombre.'</h3>                                 
                      <br>
                      <p>'.$mensaje.' </p> 
                      <br>
                      <!--<p></p>-->
                      <br>
                      <br>
                      
                       <br> <br>
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                        <tbody>
                          <tr>
                            <td align="left">
                              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tbody >
                                  <tr> </td>
                                   <!-- <td whidth="100%" align="center"> <a href="" target="_blank">Ver Recibo</a> </td>-->
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
         <!-- <div class="footer">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
              <tr><td class="content-block"><span class="apple-link">Emial Prueba</span></td></tr><tr> </tr>
            </table>
          </div>-->
        </div></td><td>&nbsp;</td></tr></table></body></html>
  ';
  return $email;
  }
  
}
