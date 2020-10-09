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
    //   $this->middleware('auth');
      $this->roles = $roles;
      $this->tramites = $tramites;

    }

    
    public function index()
    {
        $tramites = $this->listTramites();
        $roles = $this->getRoles(); 
        return view('portal/rolesuser',[ "roles" => $roles, "tramites" => $tramites ]);
    }
    public function listTramites(){

        $tramits = $this->tramites->where('id_gpm','>=', 1)->get();
    
        $tmts = array();
        try{
    
          foreach ($tramits as $t) {
            $tmts []=array(
              'id_tramite'=> $t->Tipo_Code,
              'tramite' => $t->Tipo_Descripcion
            );
          }
    
        }catch(\Exception $e){
          Log::info('Error Portal - ver Tramites: '.$e->getMessage());
        }
    
        return json_encode($tmts);
    }
    public function getRoles(){     
        try{
            $roles = $this->roles->get(["id", "descripcion"])->toArray();

        }
        catch(\Exception $e) {
            Log::info('Error Portal Roles - consulta de roles: '.$e->getMessage());
        }

        return $roles;

    }
    public function createRol(Request $request){
        $descripcion = $request->descripcion;
        try {
            $this->roles->create([
                "descripcion" => $descripcion
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

    public function addTramite(Request $request){
        $rol_id = $request->rol_id;
        $json = json_encode($request->tramites);

        
        try {
            $rol = $this->roles->where('id', $rol_id)->update([
                "tramites"=>$json
            ]);
           
    
            return response()->json(
                [
                    "Code" => "200",
                    "Message" => "Tramites agregados con éxito",
                ]
            );
    
        }catch(\Exception $e) {
    
            Log::info('Error al agregar tramites '.$e->getMessage());
    
            return response()->json(
                [
                    "Code" => "400",
                    "Message" => "Error al agregar tramites",
                ]
            );
        }
    }

   
    public function getTramites($id){
        $roles = $this->roles->where('id', $id)->first()->tramites;
                
        $ids =json_decode($roles);

        try{
                    
            $tramites = $this->tramites->whereIn('Tipo_Code', $ids)->get();
        }catch(\Exception $e){
            Log::info('Error Portal Roles - consulta de tramites: '.$e->getMessage());
        }      

        return json_encode($tramites);
    }
   
    public function editRoles(Request $request){
        try {
            $this->roles->where('id',$request->id)->update(
                ["descripcion"=>$request->descripcion]
            );

            return response()->json(["Code" => "200","Message" => "El rol ha sido editado"]);

		} catch (\Exception $e) {
			Log::info('Editar Roles - editar campo: '.$e->getMessage());

			return response()->json(["Code" => "400","Message" => "Error al editar rol"]);
		}
    }
    public function eliminarRol(Request $request){        
        try {
			$this->roles->where('id',$request->id)->update(["status"=>0]);

			return response()->json(["Code" => "200","Message" => "Campo eliminado"]);

		} catch (\Exception $e) {
			Log::info('Error Roles - eliminar campo: '.$e->getMessage());

			return response()->json(["Code" => "400","Message" => "Error al eliminar el campo"]);
		}

    }

}
