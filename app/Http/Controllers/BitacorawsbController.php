<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\BitacoraExport;

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

	public function excelBitacora(Request $request) {

		try {
			$data = json_decode($request->response);		
			return Excel::download( new BitacoraExport($data) , 'bitacora.xlsx' );
		} catch (Exception $e) {
			Log::info('Error  '.$e->getMessage());
            return response()->json(
                [
                    "Code" => "400",
                    "Message" => "Error al generar excel ".$e->getMessage(),
                ]
            );
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