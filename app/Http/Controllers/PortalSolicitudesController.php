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

use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\PortalsolicitudesresponsablesRepositoryEloquent;
use App\Repositories\PortalmensajeprelacionRepositoryEloquent;
use App\Repositories\SolicitudesMotivoRepositoryEloquent;
use App\Repositories\MotivosRepositoryEloquent;
use App\Entities\SolicitudesMotivo;


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
     MotivosRepositoryEloquent $motivos
     
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
   
    $solicitudes = DB::connection('mysql6')->table('solicitudes_catalogo')
    ->select("solicitudes_ticket.id", "solicitudes_catalogo.titulo", "solicitudes_status.descripcion","solicitudes_ticket.status","solicitudes_ticket.created_at")
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
    
    $tipoSolicitud=$this->findSol();
    $status = $this->status->all()->toArray();
    return view('portal/listadosolicitud', ["tipo_solicitud" => $tipoSolicitud , "status" => $status]);

  }
  public function findSol()
  {
    $user_id = auth()->user()->id;
    $tipoSolicitud = $this->solicitudes->findSolicitudes($user_id,null,null);
    $findSolPadres = $this->solicitudes->findSolicitudes(null,null,2);
    //log::info($findSolPadres);    
    foreach ($findSolPadres as $k) {
      if($k["status"]==2)
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
        $soliTer=$this->solicitudes->findSolicitudes(null,$k["id"],2);
        
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
    $findP=$this->ticket->findPrelacion($id);
    $findmsjPrelacion=$this->msjprelaciondb->findWhere(["solicitud_id"=>$id]);
    $prelacion=array();
    $msprelacion=array('mensaje_prelacion'=>$findmsjPrelacion->count());

      foreach ($findP as $k) {
        $prelacion=array('prelacion' =>  $k->tramite_id);
      }
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
    $informacion =array_merge( $informacion,$prelacion);
    $informacion =array_merge( $informacion,$msprelacion);
    return $informacion; 
    

  }
  

  public function guardarSolicitud(Request $request){
    $mensaje = $request->mensaje;
    $mensaje_para = $request->mensaje_para;
    $ticket_id = $request->id;
    $prelacion = $request->prelacion;
  
    if($request->has("file")){
      $file = $request->file('file'); 
      $extension = $file->getClientOriginalExtension();
      $attach = "archivo_solicitud_".$request->id.".".$extension;
      \Storage::disk('local')->put($attach,  \File::get($file));
    }else{
      $attach ="";
    }
    if($prelacion==1)
      {
        $msprelacion =$this->msjprelaciondb->create([
          'solicitud_id'=> $ticket_id
        ]);
        $attach= "documento_prelacion_".$request->id.".pdf";
        $this->savePdfprelacion($attach);
        
      }
    try {
      $mensajes =$this->mensajes->create([
        'ticket_id'=> $ticket_id,
        'mensaje' => $mensaje,
        'mensaje_para' => $mensaje_para,
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
      $id_catalogo=$request->id_catalogo;
      $catalogoH="";
      try{
        $findCatalogoHijo=$this->solicitudes->findWhere(["padre_id"=>$id_catalogo]);
        foreach ($findCatalogoHijo as $k) {
          $catalogoH=$k->id;
        }
        if($findCatalogoHijo->count()>0)
        {
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
        
        
        
        $solicitudTicket = $this->ticket->update(['status'=>2],$id);
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
        $mensajes=array();
         $findmensajes = $this->mensajes->where('ticket_id', $id)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->toArray();


        $findSolicitudes=$this->ticket->findWhere(["id"=>$id]);
        //log::info($findSolicitudes[0]["ticket_relacionado"]);
        $findMensajesPadre = $this->mensajes->where('ticket_id', $findSolicitudes[0]["ticket_relacionado"])
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->toArray();
        $mensajes=array_merge($findmensajes,$findMensajesPadre);
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

    public function getSolicitudesMotivos($solicitud_catalogo_id=""){
      try{
        $solicitudesMotivos = SolicitudesMotivo::select('solicitudes_motivo.motivo_id', 'solicitudes_motivo.solicitud_catalogo_id', 'motivos.motivo')
        ->leftjoin('motivos', 'solicitudes_motivo.motivo_id', '=', 'motivos.id');

        if($solicitud_catalogo_id){
          $solicitudesMotivos->where('solicitudes_motivo.solicitud_catalogo_id', $solicitud_catalogo_id);
        }
        $solicitudesMotivos=$solicitudesMotivos->get();
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
    private function savePdfprelacion($path)
    { 
      $path=storage_path('app/'.$path);
      $options= new Options();
      $options->set('isHtml5ParserEnabled',true);
      $options->set('isRemoteEnabled',true);
      $dompdf = new DOMPDF($options);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->set_option('dpi', '135');
      $html=View::make('documentos/prelacion',['transaccion'=>'00000000000000000'])->render();
     // log::info($html);
      $dompdf->load_html( $html);
      $dompdf->render();
      $output=$dompdf->output();
      File::put($path,$output);
    }
 
}

