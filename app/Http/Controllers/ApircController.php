<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;



class ApircController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $user;
    protected $pass;
    protected $url;
    protected $token;

    protected $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );


    public function __construct()
    {

        $this->url = env("URL_REGISTRO_CIVIL");
        $this->user = env("USR_REGISTRO_CIVIL");
        $this->pass = env("PSS_REGISTRO_CIVIL");

        // inicializamos el api de insumos
        try
        {
            $this->client = new \GuzzleHttp\Client();

            $response = $this->client->post(
                $this->url . "/GobiernoNuevoLeon-war/webresources/Autenticacion/validar_credencial",
                [
                    'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
                    'body'    => '{"nombre_usuario":"'.$this->user.'","pass":"'.$this->pass.'"}'
                ]
            );

            $results = $response->getBody();

            $results = json_decode($results);

            $this->token = $results->token;

        }catch (\Exception $e){
            dd($e->getMessage());
        }

    }


    /**
     * Regresa los datos de un acta de nacimiento
     *
     * @param expediente
     *
     *
     * @return void
     */

    public function buscarIndividuo(Request $request)
    {   

        $nombre     = strtoupper($request->nombre);
        $apaterno   = strtoupper($request->apaterno);
        $amaterno   = strtoupper($request->amaterno);
        $fechanac   = $request->fechanac;

        $params = array (
            "NOMBRE" => $nombre,
            "APELLIDO_PATERNO" => $apaterno, 
            "APELLIDO_MATERNO" => $amaterno,
            "FECHA_NACI" => $fechanac,
            "CURP" => ""
        );

        $url = $this->url . "/GobiernoNuevoLeon-war/webresources/RegistroCivil/buscar_individuo";

        // inicializamos el api de insumos
        try
        {
            $this->client = new \GuzzleHttp\Client();

            $response = $this->client->post(
                $url,
                [
                    'headers' => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',  
                        'Authorization' => 'Bearer ' . $this->token,
                    ],
                    'body'    => json_encode($params)
                ]
            );

            $results = $response->getBody();

            $results = json_decode($results);

            $r = empty($results->data) ? [] : $results->data[0];

            return response()->json($r);
            

        }catch (\Exception $e){
            Log::info("Error Api RC @ buscarIndividuo ".$e->getMessage());
            Log::info($request);
        }
    }


    /**
     * Regresa los datos de un acta de nacimiento
     *
     * @param expediente
     *
     *
     * @return void
     */

    public function buscarActaNac(Request $request)
    {   

        $nombre = strtoupper($request->nombre);
        $apaterno = strtoupper($request->apaterno);
        $amaterno = strtoupper($request->amaterno);
        $fechanac = $request->fechanac;

        $params = array (
            "NOMBRE" => $nombre,
            "APELLIDO_PATERNO" => $apaterno, 
            "APELLIDO_MATERNO" => $amaterno,
            "FECHA_NACI" => $fechanac,
            "CURP" => ""
        );

        $url = $this->url . "/GobiernoNuevoLeon-war/webresources/RegistroCivil/buscar_acta_de_nacimiento";

        // inicializamos el api de insumos
        try
        {
            $this->client = new \GuzzleHttp\Client();

            $response = $this->client->post(
                $url,
                [
                    'headers' => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',  
                        'Authorization' => 'Bearer ' . $this->token,
                    ],
                    'body'    => json_encode($params)
                ]
            );

            $results = $response->getBody();

            $results = json_decode($results);

            return empty($results->data) ? response()->json([],204,$this->header,JSON_UNESCAPED_UNICODE) : response()->json($results->data,200,$this->header,JSON_UNESCAPED_UNICODE);        

        }catch (\Exception $e){
            Log::info("Error Api RC @ buscarActaNac ".$e->getMessage());
            return response()->json([],400,$this->header,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Regresa los datos de un acta de nacimiento
     *
     * @param expediente
     *
     *
     * @return void
     */

    public function buscarActaDef(Request $request)
    {   

        $nombre = strtoupper($request->ndef);
        $apaterno = strtoupper($request->apdef);
        $amaterno = strtoupper($request->amdef);
        $fechadef = $request->fedef;

        $params = array (
            "NOMBRE" => $nombre,
            "APELLIDO_PATERNO" => $apaterno, 
            "APELLIDO_MATERNO" => $amaterno,
            "FECHA_DEFUNCION" => $fechadef
        );

        $url = $this->url . "/WS_RegistroCivil_2020/restful/actas/buscar_defuncion1";

        // inicializamos el api de insumos
        try
        {
            $this->client = new \GuzzleHttp\Client();

            $response = $this->client->post(
                $url,
                [
                    'headers' => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',  
                        'Authorization' => 'Bearer ' . $this->token,
                    ],
                    'body'    => json_encode($params)
                ]
            );
            
            $results = json_decode($response->getBody());
            
            return empty($results->result) ? response()->json([],204,$this->header,JSON_UNESCAPED_UNICODE) : response()->json($results->result,200,$this->header,JSON_UNESCAPED_UNICODE);        

        }catch (\Exception $e){
            Log::info("Error Api RC @ buscarActDef ".$e->getMessage());
            return response()->json([],400,$this->header,JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * Regresa los datos de un acta de nacimiento
     *
     * @param expediente
     *
     *
     * @return void
     */

    public function buscarActaMat(Request $request)
    {   
        $nom_con1 = strtoupper($request->nc1);
        $apa_con1 = strtoupper($request->apc1);
        $ama_con1 = strtoupper($request->amc1);
        $nom_con2 = strtoupper($request->nc2);
        $apa_con2 = strtoupper($request->apc2);
        $ama_con2 = strtoupper($request->amc2);
        $fechareg = $request->fechareg;

        $params = array (
            "conyugue1_Nombre"=> $nom_con1,
            "conyugue1_PrimerApellido"=> $apa_con1,
            "conyugue1_SegundoApellido"=> $ama_con1,
            "conyugue2_Nombre"=> $nom_con2,
            "conyugue2_PrimerApellido"=> $apa_con2,
            "conyugue2_SegundoApellido"=> $ama_con2,
            "fecha_registro"=> $fechareg
        );

        $url = $this->url . "/WS_RegistroCivil_2020/restful/actas/buscar_matrimonio1";

        // inicializamos el api de insumos
        try
        {
            $this->client = new \GuzzleHttp\Client();

            $response = $this->client->post(
                $url,
                [
                    'headers' => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',  
                        'Authorization' => 'Bearer ' . $this->token,
                    ],
                    'body'    => json_encode($params)
                ]
            );

            $results = $response->getBody();

            $results = json_decode($results);
            
            return empty($results->result) ? response()->json([],204,$this->header,JSON_UNESCAPED_UNICODE) : response()->json($results->result,200,$this->header,JSON_UNESCAPED_UNICODE);            

        }catch (\Exception $e){
            Log::info("Error Api RC @ buscarActMat ".$e->getMessage());
             return response()->json([],400,$this->header,JSON_UNESCAPED_UNICODE);
        }
    }

}