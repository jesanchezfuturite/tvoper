<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**** Repository ****/
use App\Repositories\PagosupdatelogRepositoryEloquent;


class MasterlogController extends Controller
{
	protected $masterlog;

	public function __construct( PagosupdatelogRepositoryEloquent $masterlog ) {

		$this->log = $masterlog;
	}

	public function index() {

		return view('motorpagos/masterlog');
	}

	public function consultamasterlog(Request $request) {	 	

		try {

			$fechaIn=Carbon::parse($request->fechaInicio)->format('Y-m-d');
        	$fechaFi=Carbon::parse($request->fechaFin)->format('Y-m-d');
        	$fechaIn= $fechaIn . ' 00:00:00';
        	$fechaFi=$fechaFi . ' 23:59:59';

			$result = $this->log->findbyDates($fechaIn,$fechaFi);

            return response()->json($result);
			
		} catch (Exception $e) {
			
		}

		return response()->json($request);
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