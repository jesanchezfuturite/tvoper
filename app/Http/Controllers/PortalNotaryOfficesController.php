<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\OperacionRoleRepositoryEloquent;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use SoapClient;
use GuzzleHttp\Client;

/**
 * Class PortalNotaryOfficesController.
 *
 * @package namespace App\Http\Controllers;
 */
class PortalNotaryOfficesController extends Controller
{
    /**
     * @var PortalNotaryOfficesRepository
     */
    protected $notary;
    protected $roles;

    /*
     * PortalNotaryOfficesController constructor.
     *
     */
    public function __construct(PortalNotaryOfficesRepositoryEloquent $notary,  OperacionRoleRepositoryEloquent $roles)
    {
        $this->notary = $notary;
        $this->roles = $roles;
    }
    public function createNotary(Request $request){
        $error =null;
        $data = $request->all();       
           
        $json=json_encode($data);

        $repuesta;
        $datos;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://10.153.144.218/session-api/notary-offices/");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =json_decode($remote_server_output);
    
        return json_encode($response);
         

    }

    public function listNotary(){
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL,"http://10.153.144.218/session-api/notary-offices/"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $listNotary = curl_exec($ch);

        curl_close($ch);        
        $jsonArrayResponse = json_decode($listNotary);
        $data = $jsonArrayResponse->response->notary_offices;
        return $data;
    }
 

    public function getUsers($id){
        $link ="http://10.153.144.218/session-api/notary-offices/". "$id/users";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        $listUsers = curl_exec($ch);
        curl_close($ch);
        
        $jsonArrayResponse = json_decode($listUsers);
        $data = $jsonArrayResponse->response->notary_office_users;
        return $data;
    }
 
    public function editUsersNotary(Request $request){
        $notary_id = $request->notary_id;
        $user_id = $request->user_id;
        $data = $request->user;
        $data["id"] = $user_id;
        $json=json_encode($data);
        $link ="http://10.153.144.218/session-api/notary-offices/". "$notary_id/users/$user_id";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);     
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);        

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $jsonArrayResponse = curl_exec($ch);
        curl_close($ch);
        
        $response = json_decode($jsonArrayResponse);
        
        return json_encode($response);
    }
   public function status(Request $request){
        $notary_id = $request->notary_id;
        $user_id = $request->user_id;
        $data = array(
            "id"=>$user_id,
            "status"=>$request->status
        );
        $json = json_encode($data);
        $link ="http://10.153.144.218/session-api/notary-offices/". "$notary_id/users/$user_id";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);     
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);        

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        

        $jsonArrayResponse = curl_exec($ch);
        curl_close ($ch);
        $response = $jsonArrayResponse;        
        
        return $response;
   }
   public function createUsersNotary(Request $request){
        $id = $request->notary_id;
        $link ="http://10.153.144.218/session-api/notary-offices/"."$id/users";
        $users=$request->users;
   
        $json = array("users"=>$users);
      
        $json = json_encode($json);
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =$remote_server_output;  
        return $response;
   }
   public function getRolesPermission(){
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL,"http://10.153.144.218/session-api/notary-offices/roles");        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        $listRoles = curl_exec($ch);
        curl_close($ch);
        
        return $listRoles;
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

    public function index()
    {
        $roles = $this->getRoles();
        $rolesPermission = $this->getRolesPermission();
        $responseinfo = array();        

        return view('portal/adminnotario',[
            "roles"=>$roles, 
            "rolesPermission"=>$rolesPermission
            ]);
    }
    public function listNotaryCommunity($id){
        $link = "http://10.153.144.218/session-api/notary-offices/notaryCommunity/"."$id";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        $listNotaryCommunity = curl_exec($ch);
        curl_close($ch);
        
        $jsonArrayResponse = json_decode($listNotaryCommunity);
        $data = $jsonArrayResponse->response->notary_offices;
        return $data; 
    }
    
    public function viewUsers()
    {
        return view('portal/configuracionusuarios');
    }
     public function createUsers(Request $request){
        $user = $request->user;
        $link ="http://10.153.144.218/session-api/signup";
      
        $json = json_encode($user);
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =$remote_server_output;  
        log::info($response);
        return $response;
   }
    public function updateNotary(Request $request){
        $id = $request->id;
        $data = $request->all();           
        $json=json_encode($data);

        $link = "http://10.153.144.218/session-api/notary-offices/"."$id";
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =json_decode($remote_server_output);

        return json_encode($response);
     

    }

    public function getNotary($id){
        $link ="http://10.153.144.218/session-api/notary-offices/"."$id";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        $notary = curl_exec($ch);
        curl_close($ch);
        
        return $notary;
    }

    public function searchUsername(Request $request){
        $data = $request->all();
        $url ="http://10.153.144.218/session-api/notary-offices/user";


        $client = new \GuzzleHttp\Client();

	    	$response = $client->get(
	    		$url,
	    		[
	    			"query" =>$data
	    		]	
	    	);

	    	$results = $response->getBody();

		
			return  $results;
    }


}
