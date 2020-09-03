<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\UsersRepositoryEloquent;

class PortalSolicitudesController extends Controller
{
  protected $users;

  public function __construct(
     UsersRepositoryEloquent $users
    )
    {
      $this->users = $users;
    }

  /**
  * Lista de solicitudes Actuales
  *
  *	@return solicitudes nombre solicitud y solicitud dependiente
  */

  public function index(){
    
  }

}
