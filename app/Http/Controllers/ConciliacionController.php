<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\EgobiernodiasferiadosRepositoryEloquent;

/* estos se agregan para obtener el detalle de las anomalias*/
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;

class ConciliacionController extends Controller
{
    //
    protected $files, $pr;

    protected $banco;

    protected $cuentasbanco;

    protected $egobTrans;
    ///add
    protected $operTrans;

    protected $bank_details;

    protected $results;
    
    protected $noInfo;

    protected $duplicados;
    
    protected $difStatus;

    protected $diaFeriadodb;

    
    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        BancoRepositoryEloquent $banco,
        CuentasbancoRepositoryEloquent $cuentasbanco,
        EgobiernotransaccionesRepositoryEloquent $egobTrans,
        TransaccionesRepositoryEloquent $operTrans,
        EgobiernodiasferiadosRepositoryEloquent $diaFeriadodb
    )
    {
    	$this->middleware('auth');

    	$this->files = config('conciliacion.conciliacion_conf');

        $this->pr = $pr;

        $this->banco = $banco;

        $this->cuentasbanco = $cuentasbanco;

        $this->egobTrans = $egobTrans; 

        $this->operTrans = $operTrans; 

        $this->diaFeriadodb = $diaFeriadodb;

        $this->loadBankDetails();

        //Log::info(json_encode($this->bank_details));
    }


    /**
     * Show multiple tools to update or create cfdi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */    

    public function index()
    {

        $files = $this->getFilesandStatus();
    	// valid 1 is init status 
    	return view('conciliacion/loadFile', [ "valid" => 1, "files" => $files ]);
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
        $files = $this->getFilesandStatus();

        return view('conciliacion/loadFile', [ "report" => false, "valid" => 3, "files" => $files ]);
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
        $this->noInfo=$this->getResultNoConciliado($date);
        $this->difStatus=$this->getResultDifStatus($date);
        $this->duplicados=$this->getResultDusplicados($date);
        //log::info($this->difStatus);
        $final = array();
        $result = array();

        if($this->results->count() != 0)
        {

            foreach($this->bank_details as $bd => $info)
            {
                $bank_id        = $bd;
                $bank_accounts  = $info["info"];
                $info_internet = array();
                $info_repositorio = array();
                $info_as400 = array();
                $info_otros = array();

                $nuevo_resumen = array();
                $grand_tramites = 0;
                $grand_conciliados = 0;
                $grand_no_conciliados = 0;
                $grand_monto_conciliado = 0;
                $grand_monto_no_conciliado = 0;
                $grand_total = 0;



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

                    $total_conciliados_otros    = 0;
                    $total_no_conciliados_otros = 0;
                    $monto_conciliado_otros     = 0;
                    $monto_no_conciliado_otros  = 0;

                    $total_cruce                = 0;
                    $total_no_conciliados_cruce = 0;
                    $monto_cruce                = 0;

                    $total_duplicados           = 0;
                    $total_no_conciliados_dupliacados = 0;

                    
                    $total_dif_estatus          = 0;
                    $total_no_conciliados_dif_estatus = 0;
                    
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
                                // son los de AS400
                                if(strcmp($t["status"],"p") == 0)
                                {
                                    $total_conciliados_otros ++;
                                    $monto_conciliado_otros += $t["amount"];
                                }else{
                                    $total_no_conciliados_otros ++;
                                    $monto_no_conciliado_otros += (float)$t["amount"];
                                }
                                break;
                        }
                    
                    }

                    $grand_tramites             += $total_conciliados + $total_no_conciliados + $total_conciliados_repo + $total_no_conciliados_repo +$total_conciliados_as400 + $total_no_conciliados_as400 + $total_conciliados_otros + $total_no_conciliados_otros;
                    $grand_conciliados          += $total_conciliados + $total_conciliados_repo + $total_conciliados_as400 + $total_conciliados_otros;
                    $grand_no_conciliados       += $total_no_conciliados + $total_no_conciliados_repo + $total_no_conciliados_as400 + $total_no_conciliados_otros;
                    $grand_monto_conciliado     += $monto_conciliado + $monto_conciliado_repo + $monto_conciliado_as400 + $monto_conciliado_otros;
                    $grand_monto_no_conciliado  += $monto_no_conciliado + $monto_no_conciliado_repo + $monto_no_conciliado_as400 + $monto_no_conciliado_otros;
                    $grand_total                += $grand_monto_conciliado + $grand_monto_no_conciliado;
                    // nuevo resumen
                    $nuevo_resumen []= array(
                        "alias"     => $alias,
                        "cuenta"    => $cuenta,
                        "resumen"   => 
                            array(
                                "tramites"              => $total_conciliados + $total_no_conciliados + $total_conciliados_repo + $total_no_conciliados_repo +$total_conciliados_as400 + $total_no_conciliados_as400 + $total_conciliados_otros + $total_no_conciliados_otros,
                                "conciliados"           => $total_conciliados + $total_conciliados_repo + $total_conciliados_as400 + $total_conciliados_otros,
                                "no_conciliados"        => $total_no_conciliados + $total_no_conciliados_repo + $total_no_conciliados_as400 + $total_no_conciliados_otros,
                                "monto_conciliado"      => number_format(($monto_conciliado + $monto_conciliado_repo + $monto_conciliado_as400 + $monto_conciliado_otros),2),
                                "monto_no_conciliado"   => number_format(($monto_no_conciliado + $monto_no_conciliado_repo + $monto_no_conciliado_as400 + $monto_no_conciliado_otros),2),
                                "total"                 => number_format(($monto_conciliado + $monto_conciliado_repo + $monto_conciliado_as400 + $monto_conciliado_otros +$monto_no_conciliado + $monto_no_conciliado_repo + $monto_no_conciliado_as400 + $monto_no_conciliado_otros),2)
                            ),

                        "internet"  => 
                            array(
                                "tramites"              => $total_conciliados + $total_no_conciliados,
                                "conciliados"           => $total_conciliados,
                                "no_conciliados"        => $total_no_conciliados,
                                "monto_conciliado"      => number_format($monto_conciliado,2),
                                "monto_no_conciliado"   => number_format($monto_no_conciliado,2),
                            ),
                        "repositorio"  => 
                            array(
                                "tramites"              => $total_conciliados_repo + $total_no_conciliados_repo,
                                "conciliados"           => $total_conciliados_repo,
                                "no_conciliados"        => $total_no_conciliados_repo,
                                "monto_conciliado"      => number_format($monto_conciliado_repo,2),
                                "monto_no_conciliado"   => number_format($monto_no_conciliado_repo,2),
                            ),
                        "as400"  => 
                            array(
                                "tramites"              => $total_conciliados_as400 + $total_no_conciliados_as400,
                                "conciliados"           => $total_conciliados_as400,
                                "no_conciliados"        => $total_no_conciliados_as400,
                                "monto_conciliado"      => number_format($monto_conciliado_as400,2),
                                "monto_no_conciliado"   => number_format($monto_no_conciliado_as400,2),
                            ),
                        "otros"  => 
                            array(
                                "tramites"              => $total_conciliados_otros + $total_no_conciliados_otros,
                                "conciliados"           => $total_conciliados_otros,
                                "no_conciliados"        => $total_no_conciliados_otros,
                                "monto_conciliado"      => number_format($monto_conciliado_otros,2),
                                "monto_no_conciliado"   => number_format($monto_no_conciliado_otros,2),
                            )
                    );

                $bol_cruce=false;
                    
                }
                /*
                $final [$bd]= array(
                    "descripcion"       => $info["descripcion"],
                    "info"              => $info_internet,
                    "info_repositorio"  => $info_repositorio, 
                    "info_as400"        => $info_as400, 
                    "info_otros"        => $info_otros, 
                );*/
                //log::info($nuevo_resumen);
                
                $final [$bd]= array(
                    "descripcion"               => $info["descripcion"],
                    "resumen"                   => $nuevo_resumen,
                    "grand"                     => 
                        array(
                            "tramites"              => $grand_tramites,
                            "conciliados"           => $grand_conciliados,
                            "no_conciliados"        => $grand_no_conciliados,
                            "monto_conciliado"      => number_format($grand_monto_conciliado,2),
                            "monto_no_conciliado"   => number_format($grand_monto_no_conciliado,2),
                            "monto_no_conciliado"   => number_format($grand_monto_no_conciliado,2),
                            "total"                 => number_format($grand_total,2)
                        ),
                );
                
                
            }
            $result []= array(
            "final"  => $final,
            "duplicados"  => $this->duplicados,
            "noconciliado"  => $this->noInfo,
            "difStatus"  => $this->difStatus);      
        }else{
            $result = 0;
           
        }
        //log::info($this->noInfo);
        return $result;

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
            $info = $this->pr->where('fecha_ejecucion',$date)->groupBy('referencia','transaccion_id','banco_id')->get();

            return $info;
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:getInfo]' . $e->getMessage());
        }

    }
    private function getResultNoConciliado($date)
    {
        try{
            $fecha=Carbon::parse($date)->subDay(1)->format('Y-m-d');
            $fechaFi=$fecha . ' 23:59:59';
           
            $feriado=1;
           do {//log::info('1'); 
           $nombre_dia=date('w', strtotime($fecha));
           $d = explode("-",$fecha);
               $diaF=$this->diaFeriadodb->findWhere(['Ano'=> $d[0],'Mes'=> $d[1],'Dia'=> $d[2]]);
            if($diaF->count()>0)
                {
                    if($nombre_dia==1)
                    {
                       $fecha=Carbon::parse($fecha)->subDay(3)->format('Y-m-d'); 
                    }else{
                        $fecha=Carbon::parse($fecha)->subDay(1)->format('Y-m-d'); 
                    }

                }else{
                    if($nombre_dia==7)
                    {
                       $fecha=Carbon::parse($fecha)->subDay(2)->format('Y-m-d'); 
                    }
                    break;
                }                
            } while ($feriado <= 2);
            //log::info('2');
            
            $fechaIn= $fecha . ' 00:00:00';   
            //log::info($fechaIn . '---' . $fechaFi);        
            $result=$this->operTrans->findTransaccionesNoConciliadas($fechaIn,$fechaFi);

            return $result;
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:getResultNoConciliado]' . $e->getMessage());
        }

    }
     private function getResultDifStatus($date)
    {
        try{
            $fecha=Carbon::parse($date)->format('Y-m-d');
            $result=$this->pr->findStatusDif($fecha);

            return $result;
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:getResultDifStatus]' . $e->getMessage());
        }

    }
     private function getResultDusplicados($date)
    {
        try{
            $fecha=Carbon::parse($date)->format('Y-m-d');
            $result=$this->pr->findDuplicados($fecha);
             $duplicados = array();
             $verif=array();
             $res = array();
             
             if($result<>null)
             {
                foreach ($result as $e) {
                   array_push($verif,$e->referencia);
                }
             }
            $cnt_array = array_count_values($verif);
            
            foreach($cnt_array as $key=>$val){
                if($val > 1){
                    array_push($res, $key);
                }
            }
            if($res<>null)
            {
                foreach ($res as $d) {
                //log::info($d);
                    foreach ($result as $r) {
                        if($r->referencia==$d)
                        {
                        array_push($duplicados,$r);
                        }
                    }
                }
            }
            //log::info($duplicados);
            return $duplicados;
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:getResultDifStatus]' . $e->getMessage());
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

        Log::info("Fuente = " . $fuente);
        
        $folio_id = array();
        // checar si el movimiento esta en repositorio o en internet
        if($fuente == 1)
        {
            try{

                $data = $this->pr
                            ->where('cuenta_banco',$cuenta)
                            ->where('cuenta_alias',$alias)
                            ->where('fecha_ejecucion',$f)
                            ->where('status','<>','p')
                            ->where('origen',1 )
                            ->groupBy('transaccion_id')->get();

            }catch( \Exception $e){
               Log::info('[Conciliacion:getAnomalia] ERROR buscando anomalías... ' . $e->getMessage()); 
            }

            if($data->count() > 0)
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
                $results = array(
                    "response"  => 0,
                    "data"      => "No existen errores"
                );  
            }
        }elseif($fuente == 3){
            // son todos los movimientos en el repositorio
            try{

                $data = $this->pr
                            ->where('cuenta_banco',$cuenta)
                            ->where('cuenta_alias',$alias)
                            ->where('fecha_ejecucion',$f)
                            ->where('status','<>','p')
                            ->whereIn('origen', array(2,5) )
                            ->groupBy('referencia')->get();

            }catch( \Exception $e){
               Log::info('[Conciliacion:getAnomalia] ERROR buscando anomalías... ' . $e->getMessage()); 
            }
            if($data->count() > 0)
            {
                foreach($data as $d)
                {
                    $folio_id []= array(
                        "internet"      => array(
                            "idTrans" => "N / A",
                            "TotalTramite" => "N / A",
                            "CostoMensajeria" => "N / A",
                        ), 
                        "repositorio"  => $d
                    );
                }    
                $results = array(
                    "response"  => 1,
                    "data"      => $folio_id
                );    
            }else{
                $results = array(
                    "response"  => 0,
                    "data"      => "No existen errores"
                );
            }
            
        }else{
            // son todos los movimientos en el repositorio
            try{

                $data = $this->pr
                            ->where('cuenta_banco',$cuenta)
                            ->where('cuenta_alias',$alias)
                            ->where('fecha_ejecucion',$f)
                            ->where('status','<>','p')
                            ->whereNotIn('origen', array(1,11,2,5) )
                            ->groupBy('referencia')->get();

            }catch( \Exception $e){
               Log::info('[Conciliacion:getAnomalia] ERROR buscando anomalías... ' . $e->getMessage()); 
            }
            if($data->count() > 0)
            {
                foreach($data as $d)
                {
                    $folio_id []= array(
                        "internet"      => array(
                            "idTrans" => "N / A",
                            "TotalTramite" => "N / A",
                            "CostoMensajeria" => "N / A",
                        ), 
                        "repositorio"  => $d
                    );
                }    
                $results = array(
                    "response"  => 1,
                    "data"      => $folio_id
                );    
            }else{
                $results = array(
                    "response"  => 0,
                    "data"      => "No existen errores"
                );
            }
        }
        return $results;
    }


    /**
     *
     * Resumen de archivos procesados o por procesar
     *
     * @param ninguno
     *
     * 
     * @return json_array con el listado de los archivos procesados 
     * y de los pendientes por procesar en el servidor    
     *
     **/

    private function getFilesandStatus()
    { 
        $final = array();
        
        $pending = Storage::files('toProcess');

        $processed = Storage::files('Processed');

        if(count($pending) > 0)
        {
            foreach($pending as $p)
            {
                $final []= array("file" => $p, "status" => "NP", "path" => Storage::url($p));
            }
        }

        if(count($processed) > 0)
        {
            foreach($processed as $pr)
            {
                $final []= array("file" => $pr, "status" => "PR", "path" => Storage::url($pr));
            }
        }

        return $final;

    }

    /********/

    public function tramitesNoConciliados()
    {
        return view('conciliacion/tramitesnoconciliados');
    }
    public function findTramitesnoconcilados(Request $request)
    {
       try{

            $fechaIn=Carbon::parse($request->fechaInicio)->format('Y-m-d');
            $fechaFi=Carbon::parse($request->fechaFin)->format('Y-m-d');
            $fechaIn= $fechaIn . ' 00:00:00';
            $fechaFi=$fechaFi . ' 23:59:59';   
           // log::info($fechaIn . '---' . $fechaFi);        
            $result=$this->operTrans->findTransaccionesNoConciliadas($fechaIn,$fechaFi);

            return json_encode($result);
               
        }catch( \Exception $e ){
            Log::info('[Conciliacion:findTramitesnoconcilados]' . $e->getMessage());
        }   
    }

}
