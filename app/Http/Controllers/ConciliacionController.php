<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;

class ConciliacionController extends Controller
{
    //
    protected $files, $pr;

    
    public function __construct(
        ProcessedregistersRepositoryEloquent $pr

    )
    {
    	$this->middleware('auth');

    	$this->files = config('conciliacion.conciliacion_conf');

        $this->pr = $pr;
    }


    /**
     * Show multiple tools to update or create cfdi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */    

    public function index()
    {

        // consultar la tabla de process para revisar si existen registros


        // generar el arreglo para enviar a la vista
        $report = $this->generateReport();

    	// valid 1 is init status 
    	return view('conciliacion/loadFile', [ "report" => $report, "valid" => 1 ]);
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
    	$uF = $request->file('files');


        foreach( $uF as $uploadedFile )
        {
            // get the filename 
            $fileName = $uploadedFile->getClientOriginalName(); 

            // check if is a valid file
            if(!$this->checkValidFilename($fileName))
            {
                // Throws an error with the file invalid status file code 
                return view('conciliacion/loadFile', [ "report" => false, "valid" => 0 ]);             
            }else{
                // save the file in the storage folder
                try
                {
                    $response = $uploadedFile->storeAs('toProcess',$fileName);
            
                }catch( \Exception $e ){
                    dd($e->getMessage());
                }
            }    
        }
    	
        # return to the view with the status file uploaded
        return view('conciliacion/loadFile', [ "report" => false, "valid" => 3 ]);
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

    	$name = substr($bank_data,0,$length);

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


    private function generateReport()
    {
        // get all registers
        $registers = $this->pr->all();

        if($registers->count() == 0)
        {
            return false;
        }

        $files_uploaded = array();
        // filter per file
        foreach($registers as $r)
        {
            if(!in_array($r->filename,$files_uploaded))
            {
                $f []= $r->filename;
            }
        }

        foreach($f as $dt)
        {
            $data_per_file = $this->getDataPerFile($dt,$registers);

            $files_uploaded [$dt]= array(
                "total_egob"         => $data_per_file["totalE"],
                "total_egobp"        => $data_per_file["totalEP"],
                "total_egobnp"       => $data_per_file["totalENP"],
                "total_egobmonto"    => $data_per_file["totalMontoE"],
                "total_motor"        => $data_per_file["totalM"],
                "total_motorp"       => 0,
                "total_motornp"      => 0,
                "total_motormonto"   => 0,
            );


        }

        return $files_uploaded;
    }

    private function getDataPerFile($file,$registers)
    {
        $countEgob = 0;
        $countElse = 0;
        $countEgobP = 0;
        $countEgobNP = 0;
        $countEgobENP = 0;
        $montoEgob = 0;

        foreach($registers as $r)
        {
            if(strcmp($file,$r->filename) == 0)
            {
                if($r->origen == 1)
                {
                    $countEgob ++;
                    if(strcmp($r->status,'p') == 0)
                    {
                        $countEgobP ++;
                        $montoEgob += $r->monto;
                    }else{
                        $countEgobNP ++;
                    }
                }else{
                    $countElse ++;
                }    
            }
            
        } 

        $response = array(
            "totalE" => $countEgob,
            "totalEP" => $countEgobP,
            "totalENP" => $countEgobENP,
            "totalMontoE" => $montoEgob,
            "totalM" => $countElse,
        );

        return $response;
    }


    /**
     * Vista principal de la herramienta de resultados de conciliacion
     *
     * @param Request $request
     *
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */ 

    public function results()
    {
        return view('conciliacion/results' );
    }

}
