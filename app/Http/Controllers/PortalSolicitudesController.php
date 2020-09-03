<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\UsersRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;

class PortalSolicitudesController extends Controller
{
  protected $users;
  protected $solicitudes;

  public function __construct(
     UsersRepositoryEloquent $users,
     PortalsolicitudescatalogoRepositoryEloquent $solicitudes
    )
    {
      $this->users = $users;
      $this->solicitudes = $solicitudes;
    }

  /**
  * Lista de solicitudes Actuales
  *
  *	@return solicitudes nombre solicitud y solicitud dependiente
  */

  public function index(){

  }

  /**
  * Crear una nueva solicitud
  *
  *	@return
  */
  public function crearSolicitud(){

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
