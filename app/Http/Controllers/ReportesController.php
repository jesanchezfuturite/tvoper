<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UsersPortal;
use DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\NotaryExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class ReportesController extends Controller

{
    public function listadoUsuariosPortal(){

        $roles=DB::table("portal.catalog_user_roles as r")
        ->where('r.description', 'not like', "%Ciudadano%")
        ->where('r.description', 'not like', "%Compañia%")
        ->where('r.description', 'not like', "%Funcionario%")
        ->get();
        return view('reportes/usuarios', ["roles"=>$roles]);
    }

    public function findUsuarios(Request $request)
    {
        $status = $request->status;
        $notaria = $request->notaria;
        $role = $request->role;
    	try{
    		$users = UsersPortal::from("portal.users as u")
            ->leftjoin("portal.config_user_notary_offices as config", "u.id", "=", "user_id")
            ->leftjoin("portal.notary_offices as not", "config.notary_office_id", "=", "not.id")
            ->leftjoin("portal.catalog_user_roles as r", "r.id", "=", "u.role_id")
            ->select( "u.id as id_usuario", "u.role_id", "u.config_id", 
                 "u.name", "u.mothers_surname", "u.username","u.email",
                 "u.fathers_surname", "u.curp", "u.rfc", "u.phone","u.status",
                "r.description as role", "not.notary_number", "not.id as id_notary_offices"
            )->where('r.description', 'not like', "%Ciudadano%")
            ->where('r.description', 'not like', "%Compañia%")
            ->where('r.description', 'not like', "%Funcionario%");
            

            if($status!="null"){
               $users->where("u.status", $status); 
            }
            if($notaria!=""){
                $users->where("not.notary_number", $notaria); 
            }
            if($role!=0){
                $users->where("u.role_id", $role); 
            }
            $users->orderBy("u.id", "DESC");            
            $users= $users->get();
            return json_encode($users);

        }catch(\Exception $e) {
            Log::info('Error  '.$e->getMessage());
            return response()->json(
				[
					"Code" => "400",
					"Message" => "Error al obtener usuarios ".$e->getMessage(),
				]
			);
        }
    }

    public function excelUsuarios(Request $request){
       try {
        $ids = json_decode($request->ids);
       return Excel::download(new UsersExport($ids), 'usuarios.xlsx');
       } catch(\Exception $e) {
            Log::info('Error  '.$e->getMessage());
            return response()->json(
                [
                    "Code" => "400",
                    "Message" => "Error al generar excel ".$e->getMessage(),
                ]
            );
       }
    }

    public function excelNotaria(Request $request){
        try {
         $ids = json_decode($request->ids_notaria);
        return Excel::download(new NotaryExport($ids), 'notaria.xlsx');
        } catch(\Exception $e) {
             Log::info('Error  '.$e->getMessage());
             return response()->json(
                 [
                     "Code" => "400",
                     "Message" => "Error al generar excel ".$e->getMessage(),
                 ]
             );
        }
    }

    public function downloadFile($file)
    {
      try{
        $url = env("SESSION_HOSTNAME")."/storage/app/".$file;  
        $filename = $file;
        $temporal = tempnam(sys_get_temp_dir(), $filename);
        copy($url, $temporal);
        return response()->download($temporal, $filename)->deleteFileAfterSend(true);

      }catch(\Exception $e){
        log::info("error ReporteController@downloadFile ".$e->getMessage());
      }
    }
}
