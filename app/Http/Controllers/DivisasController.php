<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UsersRepositoryEloquent;

class DivisasController extends Controller
{

    public function __construct()
    {
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

    public function index(Request $request)
    {
    	return view('portal/divisas', []);
    }



}
