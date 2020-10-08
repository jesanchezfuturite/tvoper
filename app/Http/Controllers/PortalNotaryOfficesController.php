<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use SoapClient;

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

    /*
     * PortalNotaryOfficesController constructor.
     *
     */
    public function __construct(PortalNotaryOfficesRepositoryEloquent $notary)
    {
        $this->notary = $notary;
    }
    public function createNotary(Request $request){
        $error =null;
        $data = $request->all();       
           
        $json=json_encode($data);

        $repuesta;
        $datos;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://session-api-stage.herokuapp.com/notary-offices/");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =json_decode($remote_server_output);
       
        if ($response->data=="error"){
            return json_encode($response);
        }
       
       
        $notarys = $this->listNotary();
        $responseinfo = array();

        foreach($notarys as $n)
        {
            $responseinfo []= array(
                "id"=>$n->id,
                "notary_number" => $n->notary_number  
            );
        }
        $response->list_users = $responseinfo;
        return json_encode($response);
         

    }

    public function listNotary(){
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL,"https://session-api-stage.herokuapp.com/notary-offices/");        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        $listNotary = curl_exec($ch);
        curl_close($ch);
        
        $jsonArrayResponse = json_decode($listNotary);
        $data = $jsonArrayResponse->response->notary_offices;
        return $data;
    }

    public function getUsers($id){
        $link ="https://session-api-stage.herokuapp.com/notary-offices/". "$id/users";
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
        $link ="https://session-api-stage.herokuapp.com/notary-offices/". "$notary_id/users/$user_id";
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $link);     
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);        

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $jsonArrayResponse = curl_exec($ch);
        curl_close($ch);
        
        $response = $jsonArrayResponse;
        
        return $response;
    }
   public function status(Request $request){
        $notary_id = $request->notary_id;
        $user_id = $request->user_id;
        $data = array(
            "id"=>$user_id,
            "status"=>$request->status
        );
        $json = json_encode($data);
        $link ="https://session-api-stage.herokuapp.com/notary-offices/". "$notary_id/users/$user_id";
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
        $link ="https://session-api-stage.herokuapp.com/notary-offices/"."$id/users";
        $users[]=$request->users;
        $users = array("users"=>$users);
        $json = array("notary_office"=>$users);

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

    public function index()
    {
        $notarys = $this->listNotary();
        $responseinfo = array();

        foreach($notarys as $n)
        {
            $responseinfo []= array(
                "id"=>$n->id,
                "notary_number" => $n->notary_number  
            );
        }

        return view('portal/adminnotario',[ "notary" => $responseinfo ]);
    }
 

}