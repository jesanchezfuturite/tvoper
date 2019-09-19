<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\ProcessedregistersRepositoryEloquent;
/*************/
use Carbon\Carbon;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;
use App\Repositories\MetodopagoRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\PagotramiteRepositoryEloquent;
use App\Repositories\EntidadRepositoryEloquent;
use App\Repositories\EntidadtramiteRepositoryEloquent;
use App\Repositories\TiporeferenciaRepositoryEloquent;
use App\Repositories\EgobiernostatusRepositoryEloquent;
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\TramitesRepositoryEloquent;
use App\Repositories\TramitedetalleRepositoryEloquent;
use App\Repositories\EgobfoliosRepositoryEloquent;
use App\Repositories\EgobreferenciabancariaRepositoryEloquent;
use App\Repositories\ConciliacionconciliacionRepositoryEloquent;
use App\Repositories\EgobiernocontvehRepositoryEloquent;
use App\Repositories\EgobiernoregtranlicRepositoryEloquent;
use App\Repositories\EgobiernonominaRepositoryEloquent;
use Mail;
class ConciliacionController extends Controller
{
    //
    protected $files, $pr;

    protected $bancodb;
    protected $cuentasbancodb;
    protected $metodopagodb;
    protected $tiposerviciodb;
    protected $pagotramitedb;
    protected $entidaddb;
    protected $entidadtramitedb;
    protected $tiporeferenciadb;
    protected $statusdb;
    protected $transaccionesdb;
    protected $oper_transaccionesdb;
    protected $tramitedb;
    protected $tramite_detalledb;
    protected $foliosdb;
    protected $referenciabancariadb;
    protected $conciliaciondb;
    protected $contvehdb;
    protected $regtranlicdb;
    protected $nominadb;
    
    public function __construct(
        ProcessedregistersRepositoryEloquent $pr,
        BancoRepositoryEloquent $bancodb,
        MetodopagoRepositoryEloquent $metodopagodb,
        CuentasbancoRepositoryEloquent $cuentasbancodb,
        EgobiernotiposerviciosRepositoryEloquent $tiposerviciodb,
        PagotramiteRepositoryEloquent $pagotramitedb,
        EntidadRepositoryEloquent $entidaddb,
        EntidadtramiteRepositoryEloquent $entidadtramitedb,
        TiporeferenciaRepositoryEloquent $tiporeferenciadb,
        EgobiernostatusRepositoryEloquent $statusdb,
        EgobiernotransaccionesRepositoryEloquent $transaccionesdb,
        TransaccionesRepositoryEloquent $oper_transaccionesdb,
        TramitesRepositoryEloquent $tramitedb,
        TramitedetalleRepositoryEloquent $tramite_detalledb,
        EgobfoliosRepositoryEloquent $foliosdb,
        EgobreferenciabancariaRepositoryEloquent $referenciabancariadb,
        ConciliacionconciliacionRepositoryEloquent $conciliaciondb,
        EgobiernocontvehRepositoryEloquent $contvehdb,
        EgobiernoregtranlicRepositoryEloquent $regtranlicdb,
        EgobiernonominaRepositoryEloquent $nominadb

    )
    {
    	$this->middleware('auth');

    	$this->files = config('conciliacion.conciliacion_conf');

        $this->pr = $pr;


        /******///
        $this->bancodb=$bancodb;
        $this->metodopagodb=$metodopagodb;
        $this->cuentasbancodb=$cuentasbancodb;
        $this->tiposerviciodb=$tiposerviciodb;
        $this->pagotramitedb=$pagotramitedb;
        $this->entidaddb=$entidaddb;
        $this->entidadtramitedb=$entidadtramitedb;
        $this->tiporeferenciadb=$tiporeferenciadb;
        $this->statusdb=$statusdb;
        $this->transaccionesdb=$transaccionesdb;
        $this->oper_transaccionesdb=$oper_transaccionesdb;
        $this->tramitedb=$tramitedb;
        $this->tramite_detalledb=$tramite_detalledb;
        $this->foliosdb=$foliosdb;
        $this->referenciabancariadb=$referenciabancariadb;
        $this->conciliaciondb=$conciliaciondb;
        $this->contvehdb=$contvehdb;
        $this->regtranlicdb=$regtranlicdb;
        $this->nominadb=$nominadb;

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
            "totalMontoE" => $montoEgo,
            "totalM" => $countElse,
        );

        return $response;
    }

    public function generaarchivo()
    {
        //$this->gArchivo_Impuesto_Controlv();
        //$this->gArchivo_Tenencia();
        //$this->gArchivo_Licencias();
        //$this->gArchivo_Nomina();
        $this->gArchivo_Carta_no_Inhabilita();
    }
    
    private function gArchivo_Impuesto_Controlv()
    {

        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Impuesto_ControlVeicular'.'.txt';
        log::info($txt);
        $response = array();
        $medio_pago='M_P';
        $clave_tramite='C_T';
        $total_pago='T_P';
        $partida='P';
        $consepto='C';
        $fecha_disp='F_D';
        $hora_disp='H_D';
        $fecha_pago='F_P';
        $hora_pago='H_P';
        $cuenta_pago='C_P';
        $referencia='R';
        $Archivo=fopen(storage_path('app/txt/'.$txt),"w");
        $Archivo=fopen(storage_path('app/txt/'.$txt),"a");
        $RowReferencia=str_pad('REFERECIA BANCARIA',32);
        $RowFolio=str_pad('FOLIO DE PAGO',22);
        $RowOrigen=str_pad('ORIGEN',8);
        $RowMedio_pago=str_pad('MEDIO\PAGO',12);
        $RowTotalpago=str_pad('TOTAL DE PAGO',15);
        $RowClaveltramite=str_pad('CLAVE TRAMITE',15);
        $RowPartida=str_pad('PARTIDA',9);
        $RowConsepto=str_pad('DESC CONSEPTO',120);
        $RowFechaDis=str_pad('FECHA DIS.',12);
        $RowHoraDis=str_pad('HORA DIS.',11);
        $RowFechapago=str_pad('FECHA PAGO',12);
        $RowHorapago=str_pad('HORA PAGO',12);
        $RowCuentaPago=str_pad('CUENTA PAGO',14);

        $dataAnsi=iconv(mb_detect_encoding($RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago), 'Windows-1252', $RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago);
        //log::info($dataAnsi);
        fwrite($Archivo,$dataAnsi."\r\n");
        $Servicios= array('30','1');
                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $clave_tramite=$trans->TipoServicio;
                $fecha_pago=$trans->fechatramite;
                $hora_pago=$trans->HoraTramite;

                $tramite=$this->tramitedb->findwhere(['id_transaccion_motor'=>$trans->idTrans]);
                if($tramite->count()==0)
                {
                    $partida='P';
                    $consepto='C';  
                }else{  foreach ($tramite as $tram) {
                    $tamite_detalle=$this->tramite_detalledb->findwhere(['id_tramite_motor'=>$trans->id_tramite_motor]);
                        foreach ($tamite_detalle as $tram_detalle) {
                            $partida=$tram_detalle->partida;
                            $consepto=$tram_detalle->consepto;
                        }
                    }
                }
                
                $folios=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folios->count()==0)
                    {
                        $foliopago='F_P';
                        $total_pago='T_P';
                    }else{
                    foreach ($folios as $fol) {
                        $foliopago=$fol->Folio;
                        $total_pago=$fol->CartImporte;
                    }
                }
                $referenciabancaria=$this->referenciabancariadb->findwhere(['idTrans'=>$trans->idTrans]);
                if($referenciabancaria->count()==0)
                {
                    $referencia='R';
                }else{
                    foreach ($referenciabancaria as $refbancaria) {
                    $referencia=$refbancaria->Linea;
                    }
                } 
             $RowReferencia=str_pad($referencia,32);
            $RowFolio=str_pad($foliopago,22);
            $RowOrigen=str_pad($concilia->origen,8);
            $RowMedio_pago=str_pad($medio_pago,12);
            $RowTotalpago=str_pad($total_pago,15);
            $RowClaveltramite=str_pad($clave_tramite,15);
            $RowPartida=str_pad($partida,9);
            $RowConsepto=str_pad($consepto,120);
            $RowFechaDis=str_pad($fecha_disp,12);
            $RowHoraDis=str_pad($hora_disp,11);
            $RowFechapago=str_pad($fecha_pago,12);
            $RowHorapago=str_pad($hora_pago,12);
            $RowCuentaPago=str_pad($cuenta_pago,14);
            $dataAnsi=iconv(mb_detect_encoding($RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago), 'Windows-1252', $RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago);
            fwrite($Archivo,$dataAnsi."\r\n");
            }            
            }
        }
      
        fclose($Archivo); 
        //$this->enviacorreo($txt);
    }
    
    private function gArchivo_Tenencia()
    {

        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt_tenencia=$nombreArchivo.'_Corte_Tenencia'.'.txt';
        log::info($txt_tenencia);
        $response = array();        
        $Archivo=fopen(storage_path('app/txt/'.$txt_tenencia),"w");
        $Archivo=fopen(storage_path('app/txt/'.$txt_tenencia),"a");
        /****** campos  ******/
        $guid;
        $referencia;
        $idTrans;
        $importe;$import;$recarg;
        $fecha_banco;
        $fecha_disp;
        $clave_origen='015';
        $tipo_pago;

        $RowGuid=str_pad('GUID',34);
        $RowReferencia=str_pad('REFERECIA',32);
        $RowIdTrans=str_pad('IDTRANS',13);
        $RowImporte=str_pad('IMPORTE',13);
        $RowFechaBanco=str_pad('FECHA BANCO',14);
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);
        $RowClaveOrigen=str_pad('CLAVE ORIGEN',14);
        $RowTipoPago=str_pad('TIPO PAGO',11);         
       
        $dataAnsi=iconv(mb_detect_encoding($RowGuid.$RowReferencia.$RowIdTrans.$RowImporte.$RowFechaBanco.$RowFechaDispersion.$RowClaveOrigen.$RowTipoPago), 'Windows-1252', $RowGuid.$RowReferencia.$RowIdTrans.$RowImporte.$RowFechaBanco.$RowFechaDispersion.$RowClaveOrigen.$RowTipoPago);
        
        fwrite($Archivo,$dataAnsi."\r\n");
        $Servicios= array('1');
                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $idTrans=$trans->idTrans;
                $fecha_disp=$trans->Clabe_FechaDisp;
                $tipo_pago=$trans->TipoPago;

                $contvet=$this->contvehdb->findwhere(['idTran'=>$trans->idTrans]);
                if($contvet->count()==0)
                {
                    $guid='G';
                    $referencia='R';
                     $import=0;
                    $recarg=0;
                    $importe= $import+$recarg;    
                }else{  
                    foreach ($contvet as $cont) {
                    $guid=$cont->guid;
                    $referencia=$cont->referencia;
                    $import=$cont->importe;
                    $recarg=$cont->recargo;
                    $importe= $import+$recarg;                   
                    }
                }
                
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $fecha_banco='F_B';
                       
                    }else{
                    foreach ($conc as $con) {
                        $fecha_banco=$con->archivo;   
                    }
                }
                
            $RowGuid=str_pad($guid,34); //ya
            $RowReferencia=str_pad($referencia,32); //ya
            $RowIdTrans=str_pad($idTrans,13);//ya
            $RowImporte=str_pad($importe,13);//ya
            $RowFechaBanco=str_pad($fecha_banco,14);//ya
            $RowFechaDispersion=str_pad($fecha_disp,18);//ya
            $RowClaveOrigen=str_pad($clave_origen,14);//ya
            $RowTipoPago=str_pad($tipo_pago,11);//ya
            $dataAnsi=iconv(mb_detect_encoding($RowGuid.$RowReferencia.$RowIdTrans.$RowImporte.$RowFechaBanco.$RowFechaDispersion.$RowClaveOrigen.$RowTipoPago), 'Windows-1252', $RowGuid.$RowReferencia.$RowIdTrans.$RowImporte.$RowFechaBanco.$RowFechaDispersion.$RowClaveOrigen.$RowTipoPago);
                fwrite($Archivo,$dataAnsi."\r\n");
                }            
            }
        }
      
        fclose($Archivo); 
        //$this->enviacorreo($txt_tenencia);
    }
    private function gArchivo_Licencias()
    {        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt_lic=$nombreArchivo.'_Corte_Licencias'.'.txt';
        log::info($txt_lic);
        $response = array();        
        $Archivo=fopen(storage_path('app/txt/'.$txt_lic),"w");
        $Archivo=fopen(storage_path('app/txt/'.$txt_lic),"a");
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',11);
        $RowFolio=str_pad('FOLIO',13);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);
        $RowTitularLicencia=str_pad('TITULAR DE LICENCIA',52);
        $RowNumLicencia=str_pad('NO. DE LICENCIA',17);
        $RowIdControlV=str_pad('ID CONTROL VEHICULAR',22);
        $RowImporteLic=str_pad('IMPORTE LICENCIA',18);         
        $RowImporteMens=str_pad('IMPORTE MENSAJERIA',20);         
        $RowImporteDon=str_pad('IMPORTE DONATIVO',18);         
        $RowImporteTotal=str_pad('IMPORTE TOTAL TRAMITE',23);         
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);         
        $RowFechaCorte=str_pad('FECHA CORTE',13);         
       
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowTitularLicencia.$RowNumLicencia.$RowIdControlV.$RowImporteLic.$RowImporteMens.$RowImporteDon.$RowImporteTotal.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte), 'Windows-1252', $RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowTitularLicencia.$RowNumLicencia.$RowIdControlV.$RowImporteLic.$RowImporteMens.$RowImporteDon.$RowImporteTotal.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte);
        
        fwrite($Archivo,$dataAnsi."\r\n");
        $Servicios= array('1');
                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=$trans->idTrans;
                $RowFechaTramite=$trans->fechatramite;
                $RowHoraTramite=$trans->HoraTramite;
                $RowTitularLicencia=$trans->NombreEnvio;
                $RowFechaDispersion=$trans->Clabe_FechaDisp;
                $RowHoraDispersion=$trans->Clabe_FechaDisp;


                $regtranlic=$this->regtranlicdb->findwhere(['idcarrito'=>$trans->idTrans]);
                if($regtranlic->count()==0)
                {
                    $RowImporteLic='I_L';         
                    $RowImporteMens='I_M';         
                    $RowImporteDon='I_D';         
                    $RowImporteTotal='I_T';      
                }else{  
                    foreach ($regtranlic as $reg) {
                        $RowImporteLic=$reg->imp_trav;         
                        $RowImporteMens=$reg->imp_msj;         
                        $RowImporteDon=$reg->imp_don;         
                        $RowImporteTotal=$reg->imp_ttl;              
                    }
                }
                
                $folios=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folios->count()==0)
                    {
                        $RowFolio='F'; 
                        $RowNumLicencia='No_L';
                        $RowIdControlV='Id_C';
                       
                    }else{
                    foreach ($folios as $fol) {
                        $RowFolio=$fol->Folio; 
                        $RowNumLicencia=$fol->CartKey2;
                        $RowIdControlV=$fol->CartKey3;
                    }
                }
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte='F_C';
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=$con->archivo;   
                    }
                }
                
            $RowIdTrans=str_pad($RowIdTrans,11);            //ya
            $RowFolio=str_pad($RowFolio,13);                ///ya
            $RowFechaTramite=str_pad($RowFechaTramite,15);  //ya
            $RowHoraTramite=str_pad($RowHoraTramite,14);    //ya
            $RowTitularLicencia=str_pad($RowTitularLicencia,52);    //ya
            $RowNumLicencia=str_pad($RowNumLicencia,17);        //ya
            $RowIdControlV=str_pad($RowIdControlV,22);          //ya
            $RowImporteLic=str_pad($RowImporteLic,18);         //pendiente
            $RowImporteMens=str_pad($RowImporteMens,20);       //pendiente  
            $RowImporteDon=str_pad($RowImporteDon,18);         //pendiente
            $RowImporteTotal=str_pad($RowImporteTotal,23);     //pendiente    
            $RowFechaDispersion=str_pad($RowFechaDispersion,18); ///ya        
            $RowHoraDispersion=str_pad($RowHoraDispersion,17);   //ya     
            $RowFechaCorte=str_pad($RowFechaCorte,13);           //ya
       
            $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowTitularLicencia.$RowNumLicencia.$RowIdControlV.$RowImporteLic.$RowImporteMens.$RowImporteDon.$RowImporteTotal.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte), 'Windows-1252', $RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowTitularLicencia.$RowNumLicencia.$RowIdControlV.$RowImporteLic.$RowImporteMens.$RowImporteDon.$RowImporteTotal.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte);
                fwrite($Archivo,$dataAnsi."\r\n");
                }            
            }
        }
      
        fclose($Archivo); 
        //$this->enviacorreo($txt_lic);
    }

    private function gArchivo_Nomina()
    {

        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt_lic=$nombreArchivo.'_Corte_Nomina'.'.txt';
        log::info($txt_lic);
        $response = array();        
        $Archivo=fopen(storage_path('app/txt/'.$txt_lic),"w");
        $Archivo=fopen(storage_path('app/txt/'.$txt_lic),"a");
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',11);
        $RowFolio=str_pad('FOLIO',13);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);
        $RowMunnom=str_pad('MUNNOM',8);
        $RowClaveNombre=str_pad('CLAVE NOMBRE',14);
        $RowRfcAlfa=str_pad('RFC ALFA',10);
        $RowRfcNumero=str_pad('RFC NUMERO',12);
        $RowRfcHomoclave=str_pad('RFC HOMOCLAVE',15);         
        $RowTipoPagoN=str_pad('TIPO PAGO',11);         
        $RowMesDec=str_pad('MESDEC',8);
        $RowTriDec=str_pad('TRIDEC',8);        
        $RowAnoDec=str_pad('ANODEC',8);         
        $RowNumemp=str_pad('NUMEMP',8);         
        $RowRenumeracion=str_pad('RENUMERACION',14);        
        $RowBase=str_pad('BASE',13);         
        $RowActualiza=str_pad('ACTUALIZA',11);         
        $RowRecargos=str_pad('RECARGOS',10);         
        $RowGastosEjecucion=str_pad('GASTOS DE EJECUCION',21);     
        $RowSancion=str_pad('SANSION',9);         
        $RowFuente=str_pad('FUENTE',8);         
        $RowTipoPagoT=str_pad('TIPO PAGO',11);     
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);         
        $RowFechaCorte=str_pad('FECHA CORTE',13);         
        $RowCompensacion=str_pad('COMPENSACION',23);          
       
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion), 'Windows-1252', $RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion);
        
        fwrite($Archivo,$dataAnsi."\r\n");
        $Servicios= array('1');
                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=$trans->idTrans;
                $RowFechaTramite=$trans->fechatramite;
                $RowHoraTramite=$trans->HoraTramite;
                $RowFuente=$trans->fuente;
                $RowTipoPagoT=$trans->TipoPago;
                $RowFechaDispersion=$trans->Clabe_FechaDisp;
                $RowHoraDispersion=$trans->Clabe_FechaDisp;

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte='F_C';
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=$con->archivo;   
                    }
                }
                $nomina=$this->nominadb->findwhere(['idTran'=>$trans->idTrans]);
                if($nomina->count()==0)
                    {
                        $RowFolio='F';
                        $RowMunnom='M';
                        $RowClaveNombre='CN';
                        $RowRfcAlfa='RA';
                        $RowRfcNumero='RN';
                        $RowRfcHomoclave='RH';         
                        $RowTipoPagoN='TP';         
                        $RowMesDec='MD'; 
                        $RowTriDec='TD';        
                        $RowAnoDec='AD';         
                        $RowNumemp='N';         
                        $RowRenumeracion='R';        
                        $RowBase='B';         
                        $RowActualiza='A';         
                        $RowRecargos='R';         
                        $RowGastosEjecucion='GE';     
                        $RowSancion='S';
                        $RowCompensacion='C';

                       
                    }else{
                    foreach ($nomina as $nom) {
                       $RowFolio=$nom->folio;
                        $RowMunnom=$nom->munnom;
                        $RowClaveNombre=$nom->cvenom;
                        $RowRfcAlfa=$nom->rfcalf;
                        $RowRfcNumero=$nom->rfcnum;
                        $RowRfcHomoclave=$nom->rfchomo;         
                        $RowTipoPagoN=$nom->tipopago;         
                        $RowMesDec=$nom->mesdec;         
                        $RowTriDec=$nom->mesdec;         
                        $RowAnoDec=$nom->anodec;         
                        $RowNumemp=$nom->numemp;         
                        $RowRenumeracion=$nom->remuneracion;        
                        $RowBase=$nom->base;         
                        $RowActualiza=$nom->actualiza;         
                        $RowRecargos=$nom->recargos;         
                        $RowGastosEjecucion=$nom->gtoeje;     
                        $RowSancion=$nom->sancion;
                        $RowCompensacion=$nom->compensacion;
                    }
                }                
        $RowIdTrans=str_pad($RowIdTrans,11);
        $RowFolio=str_pad($RowFolio,13);
        $RowFechaTramite=str_pad($RowFechaTramite,15);
        $RowHoraTramite=str_pad($RowHoraTramite,14);
        $RowMunnom=str_pad($RowMunnom,8);
        $RowClaveNombre=str_pad($RowClaveNombre,14);
        $RowRfcAlfa=str_pad($RowRfcAlfa,10);
        $RowRfcNumero=str_pad($RowRfcNumero,12);
        $RowRfcHomoclave=str_pad($RowRfcHomoclave,15);         
        $RowTipoPagoN=str_pad($RowTipoPagoN,11);         
        $RowMesDec=str_pad($RowMesDec,8);
        $RowTriDec=str_pad($RowTriDec,8);        
        $RowAnoDec=str_pad($RowAnoDec,8);         
        $RowNumemp=str_pad($RowNumemp,8);         
        $RowRenumeracion=str_pad($RowRenumeracion,14);        
        $RowBase=str_pad($RowBase,13);         
        $RowActualiza=str_pad($RowActualiza,11);         
        $RowRecargos=str_pad($RowRecargos,10);         
        $RowGastosEjecucion=str_pad($RowGastosEjecucion,21);     
        $RowSancion=str_pad($RowSancion,9);         
        $RowFuente=str_pad($RowFuente,8);         
        $RowTipoPagoT=str_pad($RowTipoPagoT,11);     
        $RowFechaDispersion=str_pad($RowFechaDispersion,18);         
        $RowHoraDispersion=str_pad($RowHoraDispersion,17);         
        $RowFechaCorte=str_pad($RowFechaCorte,13);         
        $RowCompensacion=str_pad($RowCompensacion,23);       
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion), 'Windows-1252',$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion);
                fwrite($Archivo,$dataAnsi."\r\n");
                }            
            }
        }
      
        fclose($Archivo); 
        //$this->enviacorreo($txt_lic);
    }
    private function gArchivo_Carta_no_Inhabilita()
    {
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt_lic=$nombreArchivo.'_Carta_No_Inhabilitada'.'.txt';
        log::info($txt_lic);
        $response = array();        
        $Archivo=fopen(storage_path('app/txt/'.$txt_lic),"w");
        $Archivo=fopen(storage_path('app/txt/'.$txt_lic),"a");
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',11);
        $RowFolio=str_pad('FOLIO',13);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);       
        $RowRfc=str_pad('RFC',15);
        $RowCurp=str_pad('CURP',20);
        $RowNombre=str_pad('NOMBRE',62);         
        $RowImporte=str_pad('IMPORTE',14);   
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);         
        $RowFechaCorte=str_pad('FECHA CORTE',13);         
       
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCurp.$RowNombre.$RowImporte.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte), 'Windows-1252',$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCurp.$RowNombre.$RowImporte.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte);
        
        fwrite($Archivo,$dataAnsi."\r\n");
        $Servicios= array('1');                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=$trans->idTrans;
                $RowFechaTramite=$trans->fechatramite;
                $RowHoraTramite=$trans->HoraTramite;
                $RowNombre=$trans->NombreEnvio;
                $RowFechaDispersion=$trans->Clabe_FechaDisp;
                $RowHoraDispersion=$trans->Clabe_FechaDisp;

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte='F_C';                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=$con->archivo;   
                    }
                }
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {
                         $RowFolio='F';
                         $RowRfc='R';
                         $RowImporte='F';                       
                    }else{
                    foreach ($folio as $fol) {
                        $RowFolio=$fol->Folio;
                        $RowRfc=$fol->CartKey1;
                        $RowImporte=$fol->CartImporte;                        
                    }
                }                
        $RowIdTrans=str_pad($RowIdTrans,11);
        $RowFolio=str_pad($RowFolio,13);
        $RowFechaTramite=str_pad($RowFechaTramite,15);
        $RowHoraTramite=str_pad($RowHoraTramite,14);
        $RowRfc=str_pad($RowRfc,15);
        $RowCurp=str_pad($RowCurp,20);///falta------------
        $RowNombre=str_pad($RowNombre,62);         
        $RowImporte=str_pad($RowImporte,14);  
        $RowFechaDispersion=str_pad($RowFechaDispersion,18);         
        $RowHoraDispersion=str_pad($RowHoraDispersion,17);         
        $RowFechaCorte=str_pad($RowFechaCorte,13); 
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCurp.$RowNombre.$RowImporte.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte), 'Windows-1252',$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCurp.$RowNombre.$RowImporte.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte);
                fwrite($Archivo,$dataAnsi."\r\n");
                }            
            }
        }
      
        fclose($Archivo); 
        //$this->enviacorreo($txt_lic);
    }
    private function gArchivo_ISAN_ISH()
    {

        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Nomina'.'.txt';
        $response = array();        
        $Archivo=fopen(storage_path('app/txt/'.$txt),"w");
        $Archivo=fopen(storage_path('app/txt/'.$txt),"a");
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',11);
        $RowFolio=str_pad('FOLIO',13);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);
        $RowMunnom=str_pad('MUNNOM',8);
        $RowClaveNombre=str_pad('CLAVE NOMBRE',14);
        $RowRfcAlfa=str_pad('RFC ALFA',10);
        $RowRfcNumero=str_pad('RFC NUMERO',12);
        $RowRfcHomoclave=str_pad('RFC HOMOCLAVE',15);         
        $RowTipoPagoN=str_pad('TIPO PAGO',11);         
        $RowMesDec=str_pad('MESDEC',8);
        $RowTriDec=str_pad('TRIDEC',8);        
        $RowAnoDec=str_pad('ANODEC',8);         
        $RowNumemp=str_pad('NUMEMP',8);         
        $RowRenumeracion=str_pad('RENUMERACION',14);        
        $RowBase=str_pad('BASE',13);         
        $RowActualiza=str_pad('ACTUALIZA',11);         
        $RowRecargos=str_pad('RECARGOS',10);         
        $RowGastosEjecucion=str_pad('GASTOS DE EJECUCION',21);     
        $RowSancion=str_pad('SANSION',9);         
        $RowFuente=str_pad('FUENTE',8);         
        $RowTipoPagoT=str_pad('TIPO PAGO',11);     
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);         
        $RowFechaCorte=str_pad('FECHA CORTE',13);         
        $RowCompensacion=str_pad('COMPENSACION',23);          
       
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion), 'Windows-1252', $RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion);        
        fwrite($Archivo,$dataAnsi."\r\n");
        ///***tramites array***/////
        $Servicios= array('1');
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=$trans->idTrans;
                $RowFechaTramite=$trans->fechatramite;
                $RowHoraTramite=$trans->HoraTramite;
                $RowFuente=$trans->fuente;
                $RowTipoPagoT=$trans->TipoPago;
                $RowFechaDispersion=$trans->Clabe_FechaDisp;
                $RowHoraDispersion=$trans->Clabe_FechaDisp;

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte='F_C';
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=$con->archivo;   
                    }
                }
                $nomina=$this->nominadb->findwhere(['idTran'=>$trans->idTrans]);
                if($nomina->count()==0)
                    {
                        $RowFolio='F';
                        $RowMunnom='M';
                        $RowClaveNombre='CN';
                        $RowRfcAlfa='RA';
                        $RowRfcNumero='RN';
                        $RowRfcHomoclave='RH';         
                        $RowTipoPagoN='TP';         
                        $RowMesDec='MD'; 
                        $RowTriDec='TD';        
                        $RowAnoDec='AD';         
                        $RowNumemp='N';         
                        $RowRenumeracion='R';        
                        $RowBase='B';         
                        $RowActualiza='A';         
                        $RowRecargos='R';         
                        $RowGastosEjecucion='GE';     
                        $RowSancion='S';
                        $RowCompensacion='C';

                       
                    }else{
                    foreach ($nomina as $nom) {
                       $RowFolio=$nom->folio;
                        $RowMunnom=$nom->munnom;
                        $RowClaveNombre=$nom->cvenom;
                        $RowRfcAlfa=$nom->rfcalf;
                        $RowRfcNumero=$nom->rfcnum;
                        $RowRfcHomoclave=$nom->rfchomo;         
                        $RowTipoPagoN=$nom->tipopago;         
                        $RowMesDec=$nom->mesdec;         
                        $RowTriDec=$nom->mesdec;         
                        $RowAnoDec=$nom->anodec;         
                        $RowNumemp=$nom->numemp;         
                        $RowRenumeracion=$nom->remuneracion;        
                        $RowBase=$nom->base;         
                        $RowActualiza=$nom->actualiza;         
                        $RowRecargos=$nom->recargos;         
                        $RowGastosEjecucion=$nom->gtoeje;     
                        $RowSancion=$nom->sancion;
                        $RowCompensacion=$nom->compensacion;
                    }
                }                
        $RowIdTrans=str_pad($RowIdTrans,11);
        $RowFolio=str_pad($RowFolio,13);
        $RowFechaTramite=str_pad($RowFechaTramite,15);
        $RowHoraTramite=str_pad($RowHoraTramite,14);
        $RowMunnom=str_pad($RowMunnom,8);
        $RowClaveNombre=str_pad($RowClaveNombre,14);
        $RowRfcAlfa=str_pad($RowRfcAlfa,10);
        $RowRfcNumero=str_pad($RowRfcNumero,12);
        $RowRfcHomoclave=str_pad($RowRfcHomoclave,15);         
        $RowTipoPagoN=str_pad($RowTipoPagoN,11);         
        $RowMesDec=str_pad($RowMesDec,8);
        $RowTriDec=str_pad($RowTriDec,8);        
        $RowAnoDec=str_pad($RowAnoDec,8);         
        $RowNumemp=str_pad($RowNumemp,8);         
        $RowRenumeracion=str_pad($RowRenumeracion,14);        
        $RowBase=str_pad($RowBase,13);         
        $RowActualiza=str_pad($RowActualiza,11);         
        $RowRecargos=str_pad($RowRecargos,10);         
        $RowGastosEjecucion=str_pad($RowGastosEjecucion,21);     
        $RowSancion=str_pad($RowSancion,9);         
        $RowFuente=str_pad($RowFuente,8);         
        $RowTipoPagoT=str_pad($RowTipoPagoT,11);     
        $RowFechaDispersion=str_pad($RowFechaDispersion,18);         
        $RowHoraDispersion=str_pad($RowHoraDispersion,17);         
        $RowFechaCorte=str_pad($RowFechaCorte,13);         
        $RowCompensacion=str_pad($RowCompensacion,23);       
        $dataAnsi=iconv(mb_detect_encoding($RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion), 'Windows-1252',$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion);
                fwrite($Archivo,$dataAnsi."\r\n");
                }            
            }
        }
      
        fclose($Archivo); 
        //$this->enviacorreo($txt);
    }
    private function enviacorreo($txt)
    {   
        log::info($txt);               
        $Archivo=$txt;
        $subject = "Prueba Correo/Archivo";
        $data = [ 'link' => 'https' ];
        $for = "juancarlos96.15.02@gmail.com";
        Mail::send('email',$data, function($msj) use($subject,$for,$Archivo){
            $msj->from("juan.carlos.cruz.bautista@hotmail.com","Juan Carlos CB");
            $msj->subject($subject);
            $msj->to($for);
                
            $msj->attach(storage_path('app/txt/'.$Archivo));
        });

    }
}
