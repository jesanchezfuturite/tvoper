<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\PortalnotificationsRepositoryEloquent;

class PortalAvisosInternosController extends Controller
{
	protected $notificationsdb;
  public function __construct(PortalnotificationsRepositoryEloquent $notificationsdb)
    {
    	$this->notificationsdb = $notificationsdb;
    }

    public function index()
    {

        return view("portal/avisosinternos");
    }
    public function findNotifications()
    {
    	try{
    		$findnotif=$this->notificationsdb->findWhere(["type_id"=>"2"]);
    		return json_encode($findnotif);
    	}catch(\Exception $e) {
            Log::info('Error PortalAvisosInternosController@findnotifications '.$e->getMessage());
        }
    }
    public function createNotifications(Request $request)
    {
    	try{
    		$createNotif=$this->notificationsdb->create(["name"=>$request->name,
    			"title"=>$request->title,
    			"description"=>$request->description,
    			"type_id"=>'2']);

    		return response()->json(["Code" => "200","Message" => "Success"]);
    	}catch(\Exception $e) {
            Log::info('Error PortalAvisosInternosController@findnotifications '.$e->getMessage());
            return response()->json(["Code" => "400","Message" => "Error al Insertar"]);
        }
    }
    public function updateNotifications(Request $request)
    {
    	try{
    		$updateNotif=$this->notificationsdb->update(["name"=>$request->name,
    			"title"=>$request->title,
    			"description"=>$request->description],$request->id);

    		return response()->json(["Code" => "200","Message" => "Actualizado"]);
    	}catch(\Exception $e) {
            Log::info('Error PortalAvisosInternosController@findnotifications '.$e->getMessage());
            return response()->json(["Code" => "400","Message" => "Error al actualizar"]);
        }
    }
    public function deletedNotifications(Request $request)
    {
		try{
    		$deleteNotif=$this->notificationsdb->deleteWhere(["id"=>$request->id]);

    		return response()->json(["Code" => "200","Message" => "Eliminado"]);
    	}catch(\Exception $e) {
            Log::info('Error PortalAvisosInternosController@findnotifications '.$e->getMessage());
            return response()->json(["Code" => "400","Message" => "Error al Eliminar"]);;
        }	
    }


}
