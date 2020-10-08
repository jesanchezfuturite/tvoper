<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\OperacionRoleRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

class OperacionRolesController extends Controller
{
  
  protected $roles;
  protected $tramites;


  public function __construct(
    OperacionRoleRepositoryEloquent $roles,
     EgobiernotiposerviciosRepositoryEloquent $tramites
    )
    {
      $this->middleware('auth');
      $this->roles = $roles;
      $this->tramites = $tramites;

    }

    
    public function index()
    {
    
        $roles = $this->roles->get();

        // return view('',[ "roles" => $responseinfo ]);
    }
 

 

}
