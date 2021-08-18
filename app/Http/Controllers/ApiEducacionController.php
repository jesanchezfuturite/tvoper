<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;

use App\Repositories\PortalCatalogoescuelasRepositoryEloquent;


class ApiEducacionController extends Controller
{
	protected $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ); 

    protected $catalogo;  

	public function __construct(PortalCatalogoescuelasRepositoryEloquent $catalogo)
	{
        $this->catalogo = $catalogo;
	}

	/**
     * Retorna un json con las coincidencias de
     * la escuela basados en el nombre y nivel
     *
     * @param escuela
     * @param nivel
     *
     *
     * @return json
     */

	public function buscarEscuela(Request $request)
	{

		$lvlesc = $request->nivel;

        if(!in_array($lvlesc, [11,12,13]))
            return response()->json(['err'=>true,'msg'=>'Nivel de escuela desconocido','data'=>''],400,$this->header,JSON_UNESCAPED_UNICODE);

		try {
			
			$info = $this->catalogo->findWhere(['clave_nivel' => $lvlesc]);
            
            return empty($info) ? response()->json(['err'=>true,'msg'=>'No se encontro coincidencia de escuela','data'=>''],204,$this->header,JSON_UNESCAPED_UNICODE) : response()->json(['err'=>false,'msg'=>'','data'=>$info],200,$this->header,JSON_UNESCAPED_UNICODE);            

		} catch (\Exception $e) {
			Log::info("Error Api EDU @ buscarEscuela ".$e->getMessage());
            return response()->json(['err'=>true,'msg'=>'Error desconocido, por el momento no puede realizarse la consulta de escuela','data'=>''],400,$this->header,JSON_UNESCAPED_UNICODE);
		}
	}

    /**
     * Retorna un json con las coincidencias de
     * la escuela basados en el nombre y nivel
     *
     * @param recibo
     * @param curp
     * @param nombre
     * @param apaellido paterno
     * @param apaellido materno
     * @param Año (termino de estudios)
     * @param mail
     * @param telefono
     * @param cct (codigo de escuela)
     * @param folio de control
     * @param nivel de estudios (11,12 o 13)
     * @param accion (0 = INSERT, 2 = CONSULTA)
     *
     *
     * @return json
     */

    public function certificadoEstudios(Request $request)
    {
        $recibo = $request->recibo;
        $curp = strtoupper($request->curp);
        $nombre = strtoupper($request->nombre);
        $apaterno = strtoupper($request->apaterno);
        $amaterno = strtoupper($request->amaterno);
        $anio = $request->anio;
        $mail = $request->mail;
        $telefono = substr(trim($request->telefono),0,10);
        $cct = strtoupper($request->cct);
        $folio = $request->foliocontrol;
        $nivel = (!in_array($request->nivel, [11,12,13])) ? 0 : $request->nivel;
        $accion = (!in_array($request->accion, [0,2])) ? 9 : $request->accion;

        $url = env("URL_CER_EDU") . $recibo . "/" . $curp . "/" . $apaterno . "/" . $amaterno . "/" . $nombre . "/" . $anio . "/" . $mail . "/" . $telefono . "/" . $cct . "/" . $folio . "/" . $nivel . "/" . $accion ;
        
        try {

            $client = new \GuzzleHttp\Client();

            $response = $client->get(
                $url,
                [
                    'headers' => [
                        'Accept' => 'application/json',  
                    ]
                ]
            );

            $results = $response->getBody();

            $results = json_decode($results);

            $data = empty($results->results) ? [] : $results->results;

            return empty($data) ? response()->json(['err'=>true,'msg'=>'No se encontro coincidencia de escuela','data'=>''],204,$this->header,JSON_UNESCAPED_UNICODE) : response()->json(['err'=>false,'msg'=>'','data'=>$data],200,$this->header,JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            Log::info("Error Api EDU @ certificadoEstudios ".$e->getMessage());
            return response()->json(['err'=>true,'msg'=>'Error desconocido, accesos a certificados no esta disponible','data'=>''],400,$this->header,JSON_UNESCAPED_UNICODE);
        }
    }


}