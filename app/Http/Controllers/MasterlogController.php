<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**** Repository ****/



class ConsulatasactualizacionesController extends Controller
{

	public function __construct() {


	}

	public function consultalogws(Request $request)
	{

		try {

			$data = json_encode($request->data);

			if(empty($data)){
				$json_response = $this->messagerror();
			}
			else {

			}
			
		} catch (Exception $e) {
			
		}

		return response()->json($json_response);
	}

	private function messagerror()
    {
        $error=array();
        $error=array(
                    "Code" => 400,
                    "Message" => 'fields required' );
        return $error;
    }

}