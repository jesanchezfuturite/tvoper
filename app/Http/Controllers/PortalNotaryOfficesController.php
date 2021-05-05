<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Repositories\PortalNotaryOfficesRepositoryEloquent;
use App\Repositories\OperacionRoleRepositoryEloquent;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use SoapClient;
use GuzzleHttp\Client;
use File;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;


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
        $this->middleware('auth');
    }
    public function createNotary(Request $request){
        $error =null;
        $notary_office=$request->notary_office;
        $files=$request->file;
        $link = env("SESSION_HOSTNAME")."/notary-offices/";

        foreach ($files as $key => $file) {
            $file = $file;
			$extension = $file->getClientOriginalExtension();
		
			$attach = "archivo_temporal_".date("U").".".$extension;
            
			\Storage::disk('local')->put($attach,  \File::get($file));
            $data[$key] = [
                'name'     => "file[]",
                'contents' => Psr7\Utils::tryFopen(storage_path('app/'.$attach), 'r'),
                'filename' => $attach
            ];

      
        }
        $data = array_merge($data, $this->flatten([ "notary_office" => $notary_office ]));
        
        try {
            $res = (new Client())->request(
                'POST',
                 $link,
                [
                    'multipart' =>$data
                ]
            );
            $response = $res->getBody();
        } catch (ClientException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd(json_decode($responseBody));
        }
        catch (ServerException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd(json_decode($responseBody));
        }
   
        return $response;
   


    }

    public function listNotary(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env("SESSION_HOSTNAME")."/notary-offices/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $listNotary = curl_exec($ch);

        curl_close($ch);
        $jsonArrayResponse = json_decode($listNotary);
        $data = $jsonArrayResponse->response->notary_offices;
        return $data;
    }


    public function getUsers($id){
        $link = env("SESSION_HOSTNAME")."/notary-offices/". "$id/users";
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
        $users = $request->user;
        $users["id"] = $user_id;
        if($request->file){
			$files= $request->file;
            foreach ($files as $key => $file) {
                $file = $file;
                $extension = $file->getClientOriginalExtension();
            
                $attach = "archivo_temporal_".date("U").".".$extension;
                
                \Storage::disk('local')->put($attach,  \File::get($file));
                $data[$key] = [
                    'name'     => "file[$key]",
                    'contents' => Psr7\Utils::tryFopen(storage_path('app/'.$attach), 'r'),
                    'filename' => $attach
                ];
    
          
            }
            $data = array_merge($data, $this->flatten([ "users" => $users ]));

		}else{
            $data = $this->flatten([ "users" => $users ]);
        }
        $link = env("SESSION_HOSTNAME")."/notary-offices/". "$notary_id/users/$user_id";

        
        try {
            $res = (new Client())->request(
                'POST',
                 $link,
                [
                    'multipart' =>$data
                ]
            );
            $response = $res->getBody();
        } catch (ClientException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd(json_decode($responseBody));
        }
        catch (ServerException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd(json_decode($responseBody));
        }
        return $response;
    }
   public function status(Request $request){
        $notary_id = $request->notary_id;
        $user_id = $request->user_id;
        $data = array(
            "status"=>$request->status
        );
        $json = json_encode($data);
        $link = env("SESSION_HOSTNAME")."/notary-offices/". "$notary_id/users_status/$user_id";
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
        // $link = env("SESSION_HOSTNAME")."/notary-offices/"."$id/users";
        $link = "http://localhost/session-api/public/notary-offices/"."$id/users";
        $users=$request->user;
        $files=$request->file;
  

        foreach ($files as $key => $file) {
            $file = $file;
			$extension = $file->getClientOriginalExtension();
		
			$attach = "archivo_temporal_".date("U").".".$extension;
            
			\Storage::disk('local')->put($attach,  \File::get($file));
            $data[$key] = [
                'name'     => "file[]",
                'contents' => Psr7\Utils::tryFopen(storage_path('app/'.$attach), 'r'),
                'filename' => $attach
            ];

      
        }
        $data = array_merge($data, $this->flatten([ "users" => $users ]));
        // dd($data);
        
        try {
            $res = (new Client())->request(
                'POST',
                 $link,
                [
                    'multipart' =>$data
                ]
            );
            $response = $res->getBody();
        } catch (ClientException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd(json_decode($responseBody));
        }
        catch (ServerException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd(json_decode($responseBody));
        }
   
        return $response;
   }
   public function getRolesPermission(){
        $url = getenv("SESSION_HOSTNAME")."/notary-offices/roles";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $listRoles = curl_exec($ch);
        if ($listRoles === false) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }
        curl_close($ch);
        $json = json_decode($listRoles);
        $data = $json->response->notary_office;
        return $data;
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
        $link = env("SESSION_HOSTNAME")."/notary-offices/notaryCommunity/"."$id";
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
        $link = env("SESSION_HOSTNAME")."/signup";

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

        $link = env("SESSION_HOSTNAME")."/notary-offices/"."$id";

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
        $link = env("SESSION_HOSTNAME")."/notary-offices/"."$id";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $notary = curl_exec($ch);
        curl_close($ch);

        return $notary;
    }

    public function searchUsername(Request $request){
        $data = $request->all();
        $url = env("SESSION_HOSTNAME")."/notary-offices/user";
        try {
        $client = new \GuzzleHttp\Client();
            $response = $client->get(
                $url,
                [
                    "query" =>$data
                ]
            );
            $results = $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\RequestException $e) {

            $results = $e->getResponse()->getBody()->getContents();
        }
        return  $results;
    }
    private function flatten($array, $prefix = "[", $suffix = "]") {
        global $i;
        $result = array();
        foreach($array as $key=>$value) {
            if(is_array($value)) {
                if($i == 0) {
                    $result = $result + $this->flatten($value, $key.$prefix, $suffix);
                }
                else {
                    foreach ($this->flatten($value, $prefix . $key . $suffix."[", $suffix) as $k => $v){
                        $result[] = $v;
                    }
                }
            }
            else {                
                if($value instanceof UploadedFile){
                    $result[] = ["name" => $prefix.$key.$suffix,
                        "filename" => $value->getClientOriginalName(),
                        "Mime-Type" => $value->getMimeType(),
                        "contents" => fopen($value->getPathname(), "r")];
                }
                else {
                    $result[] = ["name" => $prefix . $key . $suffix, "contents" => $value];
                }
            }
            $i++;
        }
        return $result;
    }

}
