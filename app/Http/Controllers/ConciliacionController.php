<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;

/* estos se agregan para obtener el detalle de las anomalias*/
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;

class ConciliacionController extends Controller
{
    //
    protected $files, $pr;

    protected $banco;

    protected $cuentasbanco;

    protected $egobTrans;

    protected $bank_details;

    protected $results;

    
    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        BancoRepositoryEloquent $banco,
        CuentasbancoRepositoryEloquent $cuentasbanco,
        EgobiernotransaccionesRepositoryEloquent $egobTrans
    )
    {
    	$this->middleware('auth');

    	$this->files = config('conciliacion.conciliacion_conf');

        $this->pr = $pr;

        $this->banco = $banco;

        $this->cuentasbanco = $cuentasbanco;

        $this->egobTrans = $egobTrans; 

        $this->loadBankDetails();

        Log::info(json_encode($this->bank_details));
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
    	$uF = $request->file('files');


        foreach( $uF as $uploadedFile )
        {
            // get the filename 
            $fileName = $uploadedFile->getClientOriginalName(); 

            // check if is a valid file
            if(!$this->checkValidFilename($fileName))
            {
                // Throws an error with the file invalid status file code 
                dd("El archivo tiene un nombre que no coincide con la codificacion definida bancoV_alias_fecha","o bien banco_alias_fecha",$fileName);
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

        // descartar los duplicados
        $discarded = array();
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
        /*code to delete duplicated*/
        foreach($final as $f)
        {
            $discarded [$f["cuenta"]]= $f["alias"];
        }

        $final = array();
        
        foreach($discarded as $d => $e){
            $final []= array(
                "cuenta"    => $d,
                "alias"     => $e
            );
        }
        /* end code to delete duplicated*/

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
                $bank_accounts  = $info["info"];
                
                $info_internet = array();
                $info_repositorio = array();
                $info_as400 = array();

                foreach($bank_accounts as $b)
                {   
                    $temporal = array();

                    $total_registros            = 0;
                    
                    $total_conciliados          = 0;
                    $total_no_conciliados       = 0;
                    $monto_conciliado           = 0;
                    $monto_no_conciliado        = 0;

                    $total_conciliados_repo     = 0;
                    $total_no_conciliados_repo  = 0;
                    $monto_conciliado_repo      = 0;
                    $monto_no_conciliado_repo   = 0;

                    $total_conciliados_as400    = 0;
                    $total_no_conciliados_as400 = 0;
                    $monto_conciliado_as400     = 0;
                    $monto_no_conciliado_as400  = 0;

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
                            case 2:
                            case 5:
                                // son los de AS400
                                if(strcmp($t["status"],"p") == 0)
                                {
                                    $total_conciliados_as400 ++;
                                    $monto_conciliado_as400 += $t["amount"];
                                }else{
                                    $total_no_conciliados_as400 ++;
                                    $monto_no_conciliado_as400 += $t["amount"];
                                }
                                break;
                            default:
                                break;
                        }
                    
                    }
                    $info_internet[]= array(
                        "cuenta"                            => $cuenta,
                        "cuenta_alias"                      => $alias,
                        //internet
                        "registros"                         => $total_conciliados + $total_no_conciliados,
                        "registros_conciliados"             => $total_conciliados,
                        "registros_no_conciliados"          => $total_no_conciliados,
                        "monto_conciliado"                  => number_format($monto_conciliado,2),
                        "monto_no_conciliado"               => number_format($monto_no_conciliado,2),
                    );    
                        // repositorio
                    $info_repositorio []= array(
                        "cuenta"                            => $cuenta,
                        "cuenta_alias"                      => $alias,    
                        "registros_conciliados"             => $total_conciliados_repo,
                        "registros_no_conciliados"          => $total_no_conciliados_repo,
                        "monto_conciliado"                  => number_format($monto_conciliado_repo,2),
                        "monto_no_conciliado"               => number_format($monto_no_conciliado_repo,2),
                        "registros"                         => $total_conciliados_repo +$total_no_conciliados_repo,
                    );
                        // as400
                    $info_as400 []= array(
                        "cuenta"                            => $cuenta,
                        "cuenta_alias"                      => $alias,
                        "registros_conciliados"             => $total_conciliados_as400,
                        "registros_no_conciliados"          => $total_no_conciliados_as400,
                        "monto_conciliado"                  => number_format($monto_conciliado_as400,2),
                        "monto_no_conciliado"               => number_format($monto_no_conciliado_as400,2),
                        "registros"                         => $total_conciliados_as400 +$total_no_conciliados_as400,
                    );
                }
                $final [$bd]= array(
                    "descripcion"       => $info["descripcion"],
                    "info"              => $info_internet,
                    "info_repositorio"  => $info_repositorio, 
                    "info_as400"        => $info_as400, 
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
        /* commented to use with fecha_ejecucion
        $initialDate = $date . " 00:00:00";
        $dueDate = $date . " 23:59:59";

        $between = array($initialDate,$dueDate);
        */
        try{

            //$info = $this->pr->findWhereBetween('created_at',$between);
            $info = $this->pr->findWhere( [ 'fecha_ejecucion' => $date ] );

            return $info;
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:getInfo]' . $e->getMessage());
        }

    }

    /**
     * returns a json object generate the view ... finds info of the registers in status <> to p
     *
     * @param request->f = date selected, account, alias 
     *
     * @return object per bank with registers of day 
     */ 

    public function getAnomalia(Request $request)
    {
        // get parameters

        $date = explode("/",$request->f);

        $f = $date[2] . "-" . $date[0] . "-" . $date[1];

       // $date_from = $date[2] . "-" . $date[0] . "-" . $date[1] . " 00:00:00"; commented to use fecha_ejecucion

       // $date_to = $date[2] . "-" . $date[0] . "-" . $date[1] . " 23:59:59";

        $alias = (string)$request->alias;

        $cuenta = (string)$request->cuenta;

        $fuente = $request->fuente;

        try{
            $data = $this->pr->findWhere(
                [
                    'cuenta_banco' => $cuenta,
                    'cuenta_alias' => $alias,
                    // ['created_at','>', $date_from],
                    // ['created_at','<', $date_to],
                    'fecha_ejecucion' => $f,
                    ['status','<>','p'],
                ]
            );

        }catch( \Exception $e){
           Log::info('[Conciliacion:getAnomalia] ERROR buscando anomalías... ' . $e->getMessage()); 
        }

        
        if($data->count() > 0)
        {
            $folio_id = array();
            // checar si el movimiento esta en repositorio o en internet
            if($fuente == 1)
            {
                foreach($data as $d)
                {
                    try
                    {

                        $info = $this->egobTrans->findWhere( ["idTrans" => $d->transaccion_id] );

                        if($info->count())
                        {
                            foreach($info as $i)
                            {
                                $folio_id []= array(
                                    "internet"      => $i, 
                                    "repositorio"  => $d
                                );
                            }
                        }else{
                            Log::info('[Conciliacion:getAnomalia] ERROR detalle transaccion internet ... ' );     
                            Log::info('... Transaccion ID >' . $d->transaccion_id);
                            Log::info('... ID' . $d->id);
                            $folio_id []= array(
                                    "conciliacion"  => $d
                                );
                        }

                    }catch( \Exception $e ){
                    Log::info('[Conciliacion:getAnomalia] ERROR buscando informacion en transacciones de internet ... ' . $e->getMessage());     
                    Log::info('... Transaccion ID >' . $d->transaccion_id);
                    Log::info('... ID' . $d->id);
                    }
                }    
                $results = array(
                    "response"  => 1,
                    "data"      => $folio_id
                );
            }else{
                // son todos los movimientos en el repositorio
                false;
            }
        }else{
            $results = array(
                "response"  => 0,
                "data"      => "No existen errores"
            );
        }   

        return $results;
    }

}
