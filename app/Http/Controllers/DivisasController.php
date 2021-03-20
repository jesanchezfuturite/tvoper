<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Repositories\DivisasRepositoryEloquent;

class DivisasController extends Controller
{
    protected $divisas;

    public function __construct(
        DivisasRepositoryEloquent $divisas

       )
       {
         $this->divisas = $divisas;

       }
       public function getDivisas(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env("SESSION_HOSTNAME")."/session-api/divisas");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $listDivisas = curl_exec($ch);

        curl_close($ch);
        return $listDivisas;
       }
       public function saveDivisas(Request $request){
        $data = $request->all();

        $json=json_encode($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,env("SESSION_HOSTNAME")."/session-api/divisas/saveDivisas");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =$remote_server_output;

        return $response;

       }

       public function deleteDivisas(Request $request){
        $data = $request->all();

        $json=json_encode($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, env("SESSION_HOSTNAME")."/session-api/divisas/deleteDivisas");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =$remote_server_output;
        return $response;

       }
       public function getDivisasSave(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env("SESSION_HOSTNAME")."/session-api/divisas/getDivisasSave");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $getDivisas = curl_exec($ch);

        curl_close($ch);
        return $getDivisas;
       }
       public function getCambioDivisa(Request $request){
        $data = $request->all();

        $json=json_encode($data);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,env("SESSION_HOSTNAME")."/session-api/divisas/getCambioDivisa");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close ($ch);
        $response =$remote_server_output;

        return $response;

       }


    public function index(Request $request)
    {
      return view('portal/divisas', []);
    }

}
