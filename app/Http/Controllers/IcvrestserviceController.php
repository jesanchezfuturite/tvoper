<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\IcvremotoreferenciaRepositoryEloquent;

class IcvrestserviceController extends Controller
{
    //
    protected $icv;

    public function __construct(
        IcvremotoreferenciaRepositoryEloquent $icv
    )
    {

        $this->icv = $icv;

    }

    /**
     * Este metodo recibe una cadena y valida si contiene numeros y letras y si la longitud esta entre 7 y 8 caracteres
     *
	 *
	 *
	 */

    public function icvconsultaplaca(Request $request)
    {

    	if(
    		preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $request->info)
    		&& ( strlen($request->info) == 7 || strlen($request->info) == 8 )
    	)
		{
			// buscar en ICV la placa solicitada
			try {
				
    			$placa = $request->info;

    			$data = $this->icv->findWhere( ['PLACA' => $placa." "] );

    			if($data->count() > 1)
    			{
    				$message = "Existe más de un registro en ICV";
    				$response ["E01"]= $message ;
    				Log::info('[WS-icvconsultaplaca] - E01 - ' . $placa);
  					return response()->json($response);
    			}elseif($data->count() == 1){
    				$message = "No existe información de la placa";
    				//$response ["E01"]= $message ;
    				Log::info('[WS-icvconsultaplaca] - Placa - ' . $placa);
    				dd($data);
    			}else{
    				$message = "No existe información de la placa";
    				$response ["E02"]= $message;
    				Log::info('[WS-icvconsultaplaca] - E02 - ' . $placa);
  					return response()->json($response);
    			}
    			

			} catch ( \Exception $e) {
				$response ["FE-R"]= "Error al intentar obtener información de ICV";
				return response()->json($response,200,['Content-Type' => "json", 'charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);			
			}			


		}else{
			$response ["E01"]= "No es una placa valida";
  			return response()->json($response);
		}


    	dd($data);

    }


}
