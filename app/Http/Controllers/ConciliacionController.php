<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;

class ConciliacionController extends Controller
{
    //
    protected $files, $pr;

    protected $banco;

    protected $cuentasbanco;

    protected $bank_details;

    protected $results;

    
    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        BancoRepositoryEloquent $banco,
        CuentasbancoRepositoryEloquent $cuentasbanco

    )
    {
    	$this->middleware('auth');

    	$this->files = config('conciliacion.conciliacion_conf');

        $this->pr = $pr;

        $this->banco = $banco;

        $this->cuentasbanco = $cuentasbanco;

        $this->loadBankDetails();
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
                dd($fileName);
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
    	
    	/* comentado por el cambio de nombres en los nuevos archivos
        $data = explode(".",$filename);

    	$bank_data = $data[0];

    	// check the length of the name
    	$length = strlen($bank_data);

    	$length -= 8;

    	$name = substr($bank_data,0,$length);
        */

        $name = explode("_", $filename);

        $name = $name[0];

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
        // obtener el arreglo de los bancos y cuentas 

        return view('conciliacion/results' );
    }


    /**
     * Loads bancos info loaded in operacion 
     *
     * @param null
     *
     * @return array with x => [account => , alias =>] 
     */ 

    private function loadBankDetails()
    {
        $bancos = $this->banco->all();

        $cuentasbanco = $this->cuentasbanco->all();

        foreach ($bancos as $b)
        {  
            $cuentas = $this->processBankAccounts($b->id,$cuentasbanco);

            $details = array();

            foreach($cuentas as $c)
            {
                $details []= array(
                    "cuenta"        => $c["cuenta"],
                    "cuenta_alias"  => $c["alias"],
                );
            }


            $final [$b->id]= array(
                "descripcion"   => $b->nombre,
                "info"          => $details
            );
        }

        $this->bank_details = $final;

    }


    /**
     * Returns an array with the accounts from an specific bank
     *
     * @param null
     *
     * @return array with x => [account => , alias =>] 
     */ 

    private function processBankAccounts($bank, $accounts)
    {
        $info = array();
        $final = array();
        foreach ($accounts as $a)
        {
            if($bank == $a->banco_id)
            {
                $info [$a->id]= json_decode($a->beneficiario); 
            }

        }

        foreach($info as $i => $data)
        {   

            foreach($data as $f){

                $final []= array(
                    "cuenta" => $f->cuenta,
                    "alias"  => $f->alias
                );
            }
            
        }

        return $final;

    }

    /**
     * returns a json object generate the view
     *
     * @param request->f = date selected
     *
     * @return object per bank with registers of day 
     */ 

    public function getInfo(Request $request)
    {
        // get the date
        $d = explode("/",$request->f);

        $date = $d[2] . "-" . $d[0] . "-" . $d[1];

        // get the bank
        $this->results = $this->getResultsperDate($date);

        $final = array();

        if($this->results->count() != 0)
        {

            foreach($this->bank_details as $bd => $info)
            {
                $bank_id        = $bd;
                $bank_name      = 
                $bank_accounts  = $info["info"];
                
                $info_final = array();

                foreach($bank_accounts as $b)
                {   
                    $temporal = array();

                    $total_registros = $total_conciliados = $total_no_conciliados = $monto_conciliado = $monto_no_conciliado =  $total_conciliados_repo = $total_no_conciliados_repo = $monto_conciliado_repo = $monto_no_conciliado_repo = 0;

                    $cuenta = $b["cuenta"];
                    $alias  = $b["cuenta_alias"];

                    // sub selected registers
                    foreach($this->results as $obj)
                    {
                        if(
                            $obj->banco_id     == $bank_id &&
                            $obj->cuenta_banco == $cuenta &&
                            $obj->cuenta_alias == $alias
                        )
                        {
                            $temporal []= array(
                                "status" => $obj->status,
                                "amount" => $obj->monto,
                                "origen" => $obj->origen,
                            );
                        }
                    }

                    foreach($temporal as $t)
                    {
                        switch($t["origen"])
                        {
                            case 1 :
                                // internet
                                if(strcmp($t["status"],"p") == 0)
                                {
                                    $total_conciliados ++;
                                    $monto_conciliado += $t["amount"];
                                }else{
                                    $total_no_conciliados ++;
                                    $monto_no_conciliado += $t["amount"];
                                }
                                break;
                            case 11 :
                                // repositorio
                                if(strcmp($t["status"],"p") == 0)
                                {
                                    $total_conciliados_repo ++;
                                    $monto_conciliado_repo += $t["amount"];
                                }else{
                                    $total_no_conciliados_repo ++;
                                    $monto_no_conciliado_repo += $t["amount"];
                                }
                                break;
                            default:
                                break;
                        }
                    
                    }
                    $info_final[]= array(
                        "cuenta" => $cuenta,
                        "cuenta_alias" => $alias,
                        "registros" => $total_conciliados + $total_no_conciliados,
                        "registros_conciliados" => $total_conciliados,
                        "registros_no_conciliados" => $total_no_conciliados,
                        "monto_conciliado" => $monto_conciliado,
                        "monto_no_conciliado" => $monto_no_conciliado,
                        "registros_conciliados_repo" => $total_conciliados_repo,
                        "registros_no_conciliados_repo" => $total_no_conciliados_repo,
                        "monto_conciliado_repo" => $monto_conciliado_repo,
                        "monto_no_conciliado_repo" => $monto_no_conciliado_repo,
                        "registros_repo" => $total_conciliados_repo +$total_no_conciliados_repo,
                    );
                }
                $final [$bd]= array(
                    "descripcion" => $info["descripcion"],
                    "info" => $info_final, 
                );
            }        
        }else{
            $final = 0;
        }
        
        return $final;

    }


    /**
     * returns all the registers processed in the selected date
     *
     * @param request->f = date selected
     *
     * @return all the registers in the day
     */
    private function getResultsperDate($date)
    {
        $initialDate = $date . " 00:00:00";
        $dueDate = $date . " 23:59:59";

        $between = array($initialDate,$dueDate);

        try{
            $info = $this->pr->findWhereBetween('created_at',$between);

            return $info;
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:getInfo]' . $e->getMessage());
        }

    }

}
