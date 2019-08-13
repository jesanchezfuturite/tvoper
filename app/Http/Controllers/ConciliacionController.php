<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

class ConciliacionController extends Controller
{
    //
	protected $files = array (
		"afirmeGobMx" 			=>	
			array(
				"extension"		=> "txt",
				"lineExample"	=> "27/06/201900000000005100010000000000121412560624146225",
				"positions"		=> array
					(
					"month"		=> [3,2],
					"day" 		=> [0,2],
					"year"		=> [6,4],
					"amount"	=> [10,2],
					"id"		=> [0,2]
					),
				"startFrom"		=> 0
			), 
		"afirmeVentanilla" 		=>
			array(
				"extension"	=> "txt",
				"lineExample"	=> "D0000391137808110010000000000121393260624181257                                                                                          2019062800000000016280001V0000000101121305MXP201906281507080000000000000000000000000000000000000000",
				"positions"		=> array
					(
					"month"		=> [141,2],
					"day" 		=> [143,2],
					"year"		=> [137,4],
					"amount"	=> [145,15],
					"id"		=> [29,8]
					),
				"startFrom"		=> 1
			),
			/*
			para american express se separa todo en un arreglo con explode
			el valor del arreglo positions esta en relacion a los datos en lineExample
			*/
		"american"				=>
			array(
				"extension"	=> "csv",
				"lineExample"	=> "AMEXGWS,12141757,27/06/2019 11:01,American Express,Captura,338.00,Aprobadas,376689xxxxx2009,MANUEL GARCIA GARZA,207799,0,660,Internet,No evaluado,No se requiere,Coincidencia parcial,Coincidencia,19062768696",
				"positions"		=> array
					(
					"month"		=> 2,
					"day" 		=> 2,
					"year"		=> 2,
					"amount"	=> 5,
					"id"		=> 1
					),
				"startFrom"		=> 1
			),
		"banamex"				=>
			array(
				"extension"	=> "txt",
			),
		"banamexVentanilla"		=>
			array(
				"extension"	=> "txt",
			),
		"bancomer"				=>
			array(
				"extension"	=> "txt",
			),
		"bancomerVentanilla"	=>
			array(
				"extension"	=> "txt",
			),
		"banorteCheque"			=>
			array(
				"extension"	=> "txt",
			),
		"banorteNominas"		=>
			array(
				"extension"	=> "txt",
			),
		"banregioVentanilla"	=>
			array(
				"extension"	=> "txt",
			),
		"bazteca"				=>
			array(
				"extension"	=> "txt",
			),
		"hsbc"					=> 
			array(
				"extension"	=> "txt",
			),
		"santanderVentanilla"	=> 
			array(
				"extension"	=> "txt",
			),
		"scotiabankVentanilla"	=>
			array(
				"extension"	=> "txt",
			),
		"telecomm"				=>
			array(
				"extension"	=> "txt",
			),
	);


    public function __construct()
    {
    	$this->middleware('auth');
    }


    /**
     * Show multiple tools to update or create cfdi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */    

    public function index()
    {
    	// valid 1 is init status 
    	return view('conciliacion/loadFile', [ "valid" => 1 ]);
    }


    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param Request $request
     *
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */ 

    public function uploadFile(Request $request)
    {

    	// identify the name of the file 
    	$uploadedFile = $request->file('file');

    	// get the filename 
    	$fileName = $uploadedFile->getClientOriginalName();	

    	// check if is a valid file
    	if(!$this->checkValidFilename($fileName))
    	{
			// Throws an error with the file invalid status file code 
			return view('conciliacion/loadFile', [ "valid" => 0 ]);   			
    	}else{
    		// save the file in the storage folder
	    	try
	    	{
	    		$response = $uploadedFile->storeAs('toProcess',$fileName);
	  	
	    	}catch( \Exception $e ){
	    		dd($e->getMessage());
	    	}
	    	# return to the view with the status file uploaded
	    	return view('conciliacion/loadFile', [ "valid" => 3 ]);
    	}

    }

    /**
     * Receives the file and saves the info in a temporary table.
     *
     * @param $filename it is the filename upload in the form 
     *
     *
     * @return true if exist in the files array / else false
     */ 
    private function checkValidFilename($filename)
    {
    	
    	$data = explode(".",$filename);

    	$bank_data = $data[0];

    	// check the length of the name
    	$length = strlen($bank_data);

    	$length -= 8;

    	$name = substr($bank_data,0, $length);

    	$validNames = $this->files;

    	$valid = false;

    	foreach($validNames as $v => $d)
    	{
    		if(strcmp($v,$name) == 0)
    		{
    			$valid = true;
    			return $valid;
    		}
    	}

    	return $valid;

    }
}
