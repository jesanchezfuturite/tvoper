<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**** Repository ****/
use App\Repositories\BitacorawsbRepositoryEloquent;


class BitacorawsbController extends Controller
{
	protected $bitacora;

	public function __construct( BitacorawsbRepositoryEloquent $bitacora ) {

		$this->bitacora = $bitacora;
	}

	public function index() {

		return view('motorpagos/bitacorawsb');
	}

	public function consultabitacora(Request $request) {	 	

		try {

			if((int)$request->fechaInicio == 1) {

				$fechaAnt = Carbon::now()->subDays(1);
				$fechaAct = Carbon::now();
				$fechaIn = $fechaAnt->format('Y-m-d');
				$fechaFi = $fechaAct->format('Y-m-d');
	        }	        
	        elseif((int)$request->fechaInicio == 3) {

				$fechaAnt = Carbon::now()->subDays(3);
				$fechaAct = Carbon::now();
				$fechaIn = $fechaAnt->format('Y-m-d');
				$fechaFi = $fechaAct->format('Y-m-d');
	        }
	        else {
				$fechaIn = Carbon::parse($request->fechaInicio)->format('Y-m-d');
				$fechaFi = Carbon::parse($request->fechaFin)->format('Y-m-d');	        	
	        }

			$fechaIn = $fechaIn . ' 00:00:00';
			$fechaFi = $fechaFi . ' 23:59:59';

			$result = $this->bitacora->findbyDates($fechaIn,$fechaFi);

            return response()->json($result);
			
		} catch (Exception $e) {
			
			return response()->json(['error'=>true,'msg'=>$e->getMessage(),'data'=>[]]);
		}
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