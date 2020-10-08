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

        return view('portal/rolesuser',[ "roles" => $roles ]);
    }
    public function createRol(Request $request){
        $data = $request->all();
        try {
            $this->roles->create($data);
    
            return response()->json(
                [
                    "Code" => "200",
                    "Message" => "Rol creado con éxito",
                ]
            );
    
        }catch(\Exception $e) {
    
            Log::info('Error al crear rol '.$e->getMessage());
    
            return response()->json(
                [
                    "Code" => "400",
                    "Message" => "Error al crear rol",
                ]
            );
        }
    }

    public function addTramite(){
        $data = $request->all();
        $json = json_encode($data);
        try {
            $this->roles->create([
                "tramites" => $json
            ]);
    
            return response()->json(
                [
                    "Code" => "200",
                    "Message" => "Rol creado con éxito",
                ]
            );
    
        }catch(\Exception $e) {
    
            Log::info('Error al crear rol '.$e->getMessage());
    
            return response()->json(
                [
                    "Code" => "400",
                    "Message" => "Error al crear rol",
                ]
            );
        }
    }

}
