<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

class ConciliacionController extends Controller
{
    //
    protected $files;

    public function __construct()
    {
    	$this->middleware('auth');

    	$this->files = config('conciliacion.conciliacion_conf');

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
