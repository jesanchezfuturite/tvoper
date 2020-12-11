<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;
use App\Entities\PortalSolicitudesTicket;

use App\Repositories\UsersRepositoryEloquent;
use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalSolicitudesStatusRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\PortalSolicitudesMensajesRepositoryEloquent;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;
use App\Repositories\TramitedetalleRepositoryEloquent;

use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\EgobiernopartidasRepositoryEloquent;

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
     PortalcampoRepositoryEloquent $campo
     
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

    try {

      $this->solicitudes->create([
        'tramite_id'=> $id_tramite,
        'padre_id'  =>  $padre_id,
        'titulo'    =>  $titulo,
        'atendido_por'=>  $atiende,
        'status'  =>  $status
      ]);

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

    try{

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
   
    $solicitudes = DB::connection('mysql6')->table('solicitudes_catalogo')
    ->select("solicitudes_ticket.id", "solicitudes_catalogo.titulo", "solicitudes_status.descripcion","solicitudes_ticket.created_at")
    ->leftJoin('solicitudes_ticket', 'solicitudes_catalogo.id', '=', 'solicitudes_ticket.catalogo_id')
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
    $solicitudes->where('solicitudes_ticket.status', '!=', 99)
    ->orderBy('solicitudes_ticket.created_at', 'DESC');
    $solicitudes = $solicitudes->get();
    return $solicitudes;
  }
  public function listSolicitudes(){
    $user_id = auth()->user()->id;
    $tipoSolicitud = $this->solicitudes->where("atendido_por", $user_id)->get(["titulo", "id"])->toArray();
    $status = $this->status->all()->toArray();
    return view('portal/listadosolicitud', ["tipo_solicitud" => $tipoSolicitud , "status" => $status]);

  }
  public function atenderSolicitud($id){
    $ticket = $this->ticket->where('id', $id)->first();
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

  public function guardarSolicitud(Request $request){
    $mensaje = $request->mensaje;
    $ticket_id = $request->id;
  
    if($request->has("file")){
      $file = $request->file('file'); 
      $extension = $file->getClientOriginalExtension();
      $attach = "archivo_solicitud_".$request->id.".".$extension;
      \Storage::disk('local')->put($attach,  \File::get($file));
    }else{
      $attach ="";
    }
  
    try {
      $mensajes =$this->mensajes->create([
        'ticket_id'=> $ticket_id,
        'mensaje' => $mensaje,
        'attach'    =>  $attach
      ]);

      return response()->json(
        [
          "Code" => "200",
          "Message" => "Mensaje guardado con éxito",
          "data"=>$mensajes
          
        ]
      );

    }catch(\Exception $e) {


      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al guardar mensaje",
        ]
      );
    }
  }

  public function cerrarTicket(Request $request){
      $id = $request->id;

      try{

        $solicitudTicket = $this->ticket->where('id',$id)
        ->update(['status'=>2]);

        return response()->json(
          [
          "Code" => "200",
          "Message" => "Ticket cerrado",
          ]
        );

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
         $mensajes = $this->mensajes->where('ticket_id', $id)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->toArray();
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
        $url="http://10.153.144.218/session-api/";
        $link = "http://10.153.144.218/session-api/notary-offices/file/"."$id/$type";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);                
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $route = curl_exec($ch);
        $error =curl_error($ch);
        curl_close($ch);
        $route=json_decode($route);
        return $url."/".$route->response;
        
  
    }
 
}

