<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UsersRepositoryEloquent;

class RolesController extends Controller
{
    //
    protected $user;

    public function __construct(
    	UsersRepositoryEloquent $user
    )
    {
    	$this->user = $user;
    }


    /**
      * asignaSolicitud(). este metodo sirve para agregar determinado tipo de solicitud a un usuario del admin
      * 
      * @param $user, $solicitud
      *
      * @return true si todo sale bien
      *
      *
      *
     */

    public function asignaSolicitud(Request $request)
    {
    	
    }



}
