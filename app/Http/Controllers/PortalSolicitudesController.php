<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\UsersRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\TramitedetalleRepositoryEloquent;

class PortalSolicitudesController extends Controller
{
  protected $users;
  protected $solicitudes;
  protected $tramites;

  public function __construct(
     UsersRepositoryEloquent $users,
     PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
     TramitedetalleRepositoryEloquent $tramites
    )
    {
      $this->users = $users;
      $this->solicitudes = $solicitudes;
      $this->tramites = $tramites;
    }

  /**
  * Lista de solicitudes Actuales
  *
  *	@return solicitudes nombre solicitud y solicitud dependiente
  */

  public function index(){
    $tramits = $this->tramites->all();

    $solicitud = $this->solicitudes->all();

    //$dataUsers = $this->users->all();

    //$slctds ->solicitudes $tmts->tramites
    $tmts = $slctds = array();
    try{

      foreach ($tramits as $t) {
        $tmts []=array(
          'id_tramite'=> $t->id_detalle_tramite,
          'tramite' => $t->concepto,
        );
      }

      foreach ($solicitud as $s) {
        $slctds []=array(
          'id_solcitud' => $s->id,
          'tramite_id'  => $s->tramite_id,
          'padre_id'  =>  $s->padre_id,
          'titulo'  =>  $s->titulo,
          'status'  =>  $s->status
        );
      }

    }catch(\Exception $e){
      Log::info('Error Portal - ver Tramites: '.$e->getMessage());
    }

    $data = array(
      'tramites' => $tmts,
      'solicitudes'=> $slctds,
    );

    return view('portal/solicitudes', $data);

  }

  /**
  * Crear una nueva solicitud
  *
  *	@return
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

    }
    catch(\Exception $e) {

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
  public function editarSolicitud(){

  }
  /**
  * Eliminar Solicitud
  *
  *	@return
  */
  public function Delete(){

  }

}