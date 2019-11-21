<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use File;
use Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Repositories\ProcessedregistersRepositoryEloquent;
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
use App\Repositories\ContdetalleisanRepositoryEloquent;
use App\Repositories\ContdetalleishRepositoryEloquent;
use App\Repositories\ContdetalleisopRepositoryEloquent;
use App\Repositories\ContdetalleisnprestadoraRepositoryEloquent;
use App\Repositories\ContdetalleisnretenedorRepositoryEloquent;
use App\Repositories\ContdetalleretencionesRepositoryEloquent;
use App\Repositories\ContdetimpisopRepositoryEloquent;
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\CorteArchivosRepositoryEloquent;
class CorteSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CorteSendEmail:SendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera el Corte y Envia por correo los Archivos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $pr;
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
    protected $detalleisandb;
    protected $detalleishdb;
    protected $detalleisopdb;
    protected $detalleisnprestadoradb;
    protected $detalleisnretenedordb;
    protected $detalleretencionesdb;
    protected $detimpisopdb;
    protected $partidasdb;
    protected $cortearchivosdb;

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
        EgobiernonominaRepositoryEloquent $nominadb,        
        ContdetalleisanRepositoryEloquent $detalleisandb,
        ContdetalleishRepositoryEloquent $detalleishdb,
        ContdetalleisopRepositoryEloquent $detalleisopdb,
        ContdetalleisnprestadoraRepositoryEloquent $detalleisnprestadoradb,
        ContdetalleisnretenedorRepositoryEloquent $detalleisnretenedordb,
        ContdetalleretencionesRepositoryEloquent $detalleretencionesdb,
        ContdetimpisopRepositoryEloquent $detimpisopdb,
        EgobiernopartidasRepositoryEloquent $partidasdb,
        CorteArchivosRepositoryEloquent $cortearchivosdb
    )
    {
         parent::__construct();        
        $this->pr = $pr;
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
        $this->detalleisandb=$detalleisandb;
        $this->detalleishdb=$detalleishdb;
        $this->detalleisopdb=$detalleisopdb;
        $this->detalleisnprestadoradb=$detalleisnprestadoradb;
        $this->detalleisnretenedordb=$detalleisnretenedordb;
        $this->detalleretencionesdb=$detalleretencionesdb;
        $this->detimpisopdb=$detimpisopdb;
        $this->partidasdb=$partidasdb;
        $this->cortearchivosdb=$cortearchivosdb;

    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $this->generaarchivo();
    }
    private function generaarchivo()
    {
         $nombreArchivo=Carbon::now();
         $json_archivos=$arrayName = array();
        if (!File::exists(storage_path('app/Cortes')))
        { File::makeDirectory(storage_path('app/Cortes'));}       
        $path1=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y'));
        $path2=$path1.'/Cortes_'.$nombreArchivo->format('Y_m');
        $path3=$path2.'/Corte_'.$nombreArchivo->format('Y_m_d');        
        $response = array();       
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $cortearchivos=$this->cortearchivosdb->findWhere([['created_at','>',$fechaIn],['created_at','<',$fechaFin]]);
        if($cortearchivos->count()==0)
        {
           if (!File::exists($path1))
                {File::makeDirectory($path1);}
            if (!File::exists($path2))
                {File::makeDirectory($path2);}
            if (!File::exists($path3))
                {File::makeDirectory($path3);}
           $this->gArchivos();    
            $Archivos=File::allFiles($path3);       
            foreach ($Archivos as $key) {
                $json_archivos []= $arrayName = array('archivocorte'=>$key->getRelativePathname());
            }
            $json_archivos=json_encode($json_archivos);
            $insertaCorte=$this->cortearchivosdb->create(['json_archivos'=> $json_archivos]);
            //$this->enviacorreo();
            
        } else{
        /*foreach ($cortearchivos as $i ) {
            $array =$i->json_archivos;
        }
            $count = count(json_decode($array));
            log::info($count);*/
            $this->gArchivos();
            //$this->enviacorreo();
        }       
    }
    private function gArchivos()
    {
        //$this->insrtfolio();
        $this->gArchivo_Generico();        
        $this->gArchivo_Nomina();            
        $this->gArchivo_ISAN_ISH(); 
        $this->gArchivo_ISOP(); 
        $this->gArchivo_Prestadora_Servicios(); 
        $this->gArchivo_Retenedora_Servicios(); 
        $this->gArchivo_Juegos_Apuestas(); 
            //$this->gArchivo_Tenencia();
           // $this->gArchivo_Licencias();
          //  $this->gArchivo_Carta_no_Inhabilita();
            //$this->enviacorreo();
            //$this->corta();
           
    }
    private function corta()
    {
       /* $nombreArchivo=Carbon::now();
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d'));       
        $Archivos=File::allFiles($path);
        foreach ($Archivos as $key) {
            log::info($key->getRelativePathname());
        }*/
        $v1="12.011";        
        $v2="11";
        $cals=(double)$v1-(double)$v2;
        $cals=number_format($cals,2,'.','');
        log::info($cals);        
    }    
    private function gArchivo_Generico()
    {        
        $nombreArchivo=Carbon::now();
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_Generico'.'.txt');       
        File::delete($path);
        $response = array();
        $cadena='';
        $Servicios= array(1,30,20,21,27,28,29,156,157,158,160);       
            for ($i=100; $i < 151; $i++) { 
               array_push($Servicios ,$i );
            }
        $existe=false;
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);          
        foreach ($conciliacion as $concilia) {          
            $existe=false;             
            $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id]);            
            if($transacciones->Count()>0){
                foreach ($transacciones as $trans){
                
                    foreach ($Servicios as $serv){
                        if($serv==$trans->TipoServicio)
                        {$existe=true; }
                    }
                    if($existe)
                    {
                        $RowClaveltramite=str_pad($trans->TipoServicio,6,"0",STR_PAD_LEFT);
                        $RowFechapago=str_pad(Carbon::parse($trans->fechatramite)->format('Ymd'),8);
                        $RowHorapago=str_pad(Carbon::parse($trans->HoraTramite)->format('hms'),6);
                        $RowFechaDis=str_pad(Carbon::parse($trans->fechatramite)->format('Ymd'),8);
                        $RowHoraDis=str_pad(Carbon::parse($trans->HoraTramite)->format('hms'),6);
                    $partidas=$this->partidasdb->findwhere(['id_servicio'=>$trans->TipoServicio]);
                        if($partidas->count()==0)
                        {
                            $RowPartida=str_pad('',5);
                            $RowConsepto=str_pad('',120);  
                        }else{  
                            foreach ($partidas as $part) {                   
                                $RowPartida=str_pad($part->id_partida,5,"0",STR_PAD_LEFT);
                                $RowConsepto=str_pad(mb_convert_encoding($part->descripcion, "Windows-1252", "UTF-8"),120);                       
                            }
                        }                
                    $folios=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                        if($folios->count()==0)
                        {
                            $RowTotalpago=str_pad('',11,"0",STR_PAD_LEFT);
                            $RowFolio=str_pad('',20,"0",STR_PAD_LEFT);
                        }else{
                            foreach ($folios as $fol) {
                            $RowFolio=str_pad($fol->Folio,20,"0",STR_PAD_LEFT);
                            $RowTotalpago=str_pad(str_replace(".","",$fol->CartImporte) ,13,"0",STR_PAD_LEFT);
                            }
                        }
                    $referenciabancaria=$this->referenciabancariadb->findwhere(['idTrans'=>$trans->idTrans]);
                        if($referenciabancaria->count()==0)
                        {
                            $RowReferencia=str_pad('',30,"0",STR_PAD_LEFT);
                        }else{
                            foreach ($referenciabancaria as $refbancaria) {
                                $RowReferencia=str_pad($refbancaria->Linea,30,"0",STR_PAD_LEFT);
                            }
                        }
                        $RowOrigen=str_pad("027",3,"0",STR_PAD_LEFT);  
                        $RowMedio_pago=str_pad('001',3,"0",STR_PAD_LEFT);//pendiente                                                 
                        $RowDatoAdicional1=str_pad('',30,"0",STR_PAD_LEFT);//pendiente
                        $RowDatoAdicional2=str_pad('',15,"0",STR_PAD_LEFT);//pendiente
                        $RowCuentaPago=str_pad($concilia->cuenta_banco,30,"0",STR_PAD_LEFT);
                        $RowAlias=str_pad($concilia->cuenta_alias,6,"0",STR_PAD_LEFT); 
                        $cadena=$RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowDatoAdicional1.$RowDatoAdicional2.$RowCuentaPago.$RowAlias;
                       // $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                        File::append($path,$cadena."\r\n");
                    }            
                }
            }
        }
        //$this->enviacorreo($txt);
    }
    /*
    private function gArchivo_Tenencia()
    {        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Tenencia'.'.txt';
        $response = array();        
       File::delete(storage_path('app/txt/'.$txt));
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
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
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
                File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }      
    }*/
    /*
    private function gArchivo_Licencias()
    {        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt_lic=$nombreArchivo.'_Corte_Licencias'.'.txt';
        log::info($txt_lic);
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt_lic));
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
        File::append(storage_path('app/txt/'.$txt_lic),$dataAnsi."\r\n");
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
                File::append(storage_path('app/txt/'.$txt_lic),$dataAnsi."\r\n");
                }            
            }
        }       
        //$this->enviacorreo($txt_lic);
    }
*/
    private function gArchivo_Nomina()
    {
        $nombreArchivo=Carbon::now();
         $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_Nomina'.'.txt');       
        File::delete($path);
        $cadena='';
        $response = array();
        $Servicios= array('3');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {          
            $RowFechaCorte=str_pad(Carbon::parse($concilia->created_at)->format('Ymd'),8); 

            $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,9,"0",STR_PAD_LEFT);        
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite, 10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite, 10,''))->format('Hms'),6);          
                $RowFuente=str_pad(substr($trans->fuente, 4),4);         
                $RowTipoPagoT=str_pad($trans->TipoPago,4,"0",STR_PAD_LEFT);     
                $RowFechaDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);         
                $RowHoraDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);
                 if(strlen($RowFechaDispersion)==13)
                {
                    $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                    $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);

                } 
                else{
                    $RowFechaDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('Y-m-d'),10);
                    $RowHoraDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('H:m:s'),8);

                }  
                
                $nomina=$this->nominadb->findwhere(['idTran'=>$trans->idTrans]);
                if($nomina->count()==0)
                    {  
                        $RowFolio=str_pad('1',11,"0",STR_PAD_LEFT);
                        $RowMunnom=str_pad('1',2,"0",STR_PAD_LEFT);
                        $RowClaveNombre=str_pad('1',7,"0",STR_PAD_LEFT);
                        $RowRfcAlfa=str_pad('1',4,"0",STR_PAD_LEFT);
                        $RowRfcNumero=str_pad('1',6,"0",STR_PAD_LEFT);
                        $RowRfcHomoclave=str_pad('1',3,"0",STR_PAD_LEFT);         
                        $RowTipoPagoN=str_pad('1',1,"0",STR_PAD_LEFT);         
                        $RowMesDec=str_pad('1',2,"0",STR_PAD_LEFT);
                        $RowTriDec=str_pad('1',1,"0",STR_PAD_LEFT);        
                        $RowAnoDec=str_pad('2019',4,"0",STR_PAD_LEFT);         
                        $RowNumemp=str_pad('1',6,"0",STR_PAD_LEFT);         
                        $RowRenumeracion=str_pad('100',15,"0",STR_PAD_LEFT);        
                        $RowBase=str_pad('100',15,"0",STR_PAD_LEFT);         
                        $RowActualiza=str_pad('100',11,"0",STR_PAD_LEFT);         
                        $RowRecargos=str_pad('100',9,"0",STR_PAD_LEFT);         
                        $RowGastosEjecucion=str_pad('100',9,"0",STR_PAD_LEFT);     
                        $RowSancion=str_pad('100',9,"0",STR_PAD_LEFT);
                        $RowCompensacion=str_pad('100',15,"0",STR_PAD_LEFT);
                       
                    }else{
                    foreach ($nomina as $nom) {
                         
                        $RowFolio=str_pad($nom->folio,11,"0",STR_PAD_LEFT);
                        $RowMunnom=str_pad($nom->munnom,2,"0",STR_PAD_LEFT);
                        $RowClaveNombre=str_pad($nom->cvenom,7,"0",STR_PAD_LEFT);
                        $RowRfcAlfa=str_pad(Str::limit($nom->rfcalf, 4,''),4," ",STR_PAD_LEFT);
                        $RowRfcNumero=str_pad(Str::limit($nom->rfcnum, 6,''),6,"0",STR_PAD_LEFT);
                        $RowRfcHomoclave=str_pad(Str::limit($nom->rfchomo, 3,''),3," ",STR_PAD_LEFT);         
                        $RowTipoPagoN=str_pad($nom->tipopago,1,"0",STR_PAD_LEFT);         
                        $RowMesDec=str_pad($nom->mesdec,2,"0",STR_PAD_LEFT);
                        $RowTriDec=str_pad($nom->tridec,1,"0",STR_PAD_LEFT);        
                        $RowAnoDec=str_pad($nom->anodec,4,"0",STR_PAD_LEFT);         
                        $RowNumemp=str_pad($nom->numemp,6,"0",STR_PAD_LEFT);         
                        $RowRenumeracion=str_pad(str_replace(".", "", $nom->remuneracion),15,"0",STR_PAD_LEFT);        
                        $RowBase=str_pad(str_replace(".", "",$nom->base ),15,"0",STR_PAD_LEFT);         
                        $RowActualiza=str_pad(str_replace(".", "",$nom->actualiza ),11,"0",STR_PAD_LEFT);         
                        $RowRecargos=str_pad(str_replace(".", "", $nom->recargos),9,"0",STR_PAD_LEFT);         
                        $RowGastosEjecucion=str_pad(str_replace(".", "", $nom->gtoeje),9,"0",STR_PAD_LEFT);     
                        $RowSancion=str_pad(str_replace(".", "",$nom->sancion ),9,"0",STR_PAD_LEFT);
                        $RowCompensacion=str_pad(str_replace(".", "", $nom->compensacion),15,"0",STR_PAD_LEFT);
                    }
                }             
                $RowValorFijo="0";
                $cadena=$RowIdTrans.$RowFolio.$RowValorFijo.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252',$cadena);
                File::append($path,$dataAnsi."\r\n");
                }            
            }
        }       
    }
    /*
    private function gArchivo_Carta_no_Inhabilita()
    {
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Carta_No_Inhabilitada'.'.txt';
        log::info($txt_lic);
        $response = array();
        $cadena='';        
        File::delete(storage_path('app/txt/'.$txt));        
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
        $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCurp.$RowNombre.$RowImporte.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252',$cadena);        
        fwrite($Archivo,$dataAnsi."\r\n");
        $Servicios= array('1');                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,11);
                $RowFechaTramite=str_pad($trans->fechatramite,15);
                $RowHoraTramite=str_pad($trans->HoraTramite,14);
                $RowNombre=str_pad($trans->NombreEnvio,62); 
                $RowFechaDispersion=str_pad($trans->Clabe_FechaDisp,18);         
                $RowHoraDispersion=str_pad($trans->Clabe_FechaDisp,17); 
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('F_C',13);                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,13);   
                    }
                }
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {
                         $RowFolio=str_pad('F',13);
                         $RowRfc=str_pad('R',15);
                         $RowImporte=str_pad('Imp',14);                       
                    }else{
                    foreach ($folio as $fol) {
                        $RowFolio=str_pad($fol->Folio,13);
                        $RowRfc=str_pad($fol->CartKey1,15);
                        $RowImporte=str_pad($fol->CartImporte,14);                        
                    }
                }
            $RowCurp=str_pad($RowCurp,20);///falta------------
            $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCurp.$RowNombre.$RowImporte.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte;
            $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252',$cadena);
                fwrite($Archivo,$dataAnsi."\r\n");
                }            
            }
        }
      
        //$this->enviacorreo($txt_lic);
    }*/
    private function gArchivo_ISAN_ISH()
    {
        $nombreArchivo=Carbon::now();
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_ISAN_ISH'.'.txt');       
        File::delete($path);
        $response = array(); 
         
        $cadena='';        
        $conseptoo = array();
        $impuesto;
        $actualizacion;
        $recargos;
        $dif_imp;
        $dif_act;
        $dif_rec;
        $conseptoo []=array('clave' => '01','consepto'=>'Impuesto','partida'=>'12600');
        $conseptoo []=array('clave' => '02','consepto'=>'Actualizacion','partida'=>'12603');
        $conseptoo []=array('clave' => '03','consepto'=>'Recargos','partida'=>'40205');
        $consepto=json_encode($conseptoo);
        $declaracion;
        $Servicios= array('13','14');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $RowFechaBanco=str_pad(Carbon::parse($concilia->created_at)->format('Ymd'),8);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,20,"0",STR_PAD_LEFT);
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite, 10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite, 10,''))->format('H:m:s'),8);
               $RowFechaDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);         
                $RowHoraDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);
                if(strlen($RowFechaDispersion)==13)
                {
                    $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);

                } 
                else{
                    $RowFechaDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('H:m:s'),8);

                }                  
                $RowTipoPago=str_pad($trans->TipoPago,4,"0",STR_PAD_LEFT);
                $RowTotalTramite=str_pad(str_replace(".", "",$trans->TotalTramite),11,"0",STR_PAD_LEFT);
               
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {                     
                       $RowFolio=str_pad('',20,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad('',13," ",STR_PAD_LEFT);
                    }else{
                    foreach ($folio as $fol) {                       
                       $RowFolio=str_pad($fol->Folio,20,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad($fol->CartKey1,13," ",STR_PAD_LEFT);
                    }
                }
                $isan=$this->detalleisandb->findwhere(['idTrans'=>$trans->idTrans]); 

                if($isan->count()==0)
                {

                   $ish=$this->detalleishdb->findwhere(['idTrans'=>$trans->idTrans]);
                    if($ish->count()==0){
                        $RowCuenta=str_pad('12012',11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad('LJIU02101',18," ",STR_PAD_LEFT);
                        $RowRazonSocial=str_pad('Razon Social ISAN/ISH',150);
                        $RowTipoDeclaracion=str_pad('1',1);
                        $RowPeriodicidad=str_pad('M',1);                      
                        $RowAnoDeclarado=str_pad('2019',4);
                        $RowMesDeclarado=str_pad('01',2,"0",STR_PAD_LEFT);
                        $RowNoComple=str_pad('1',1);
                        $RowFolioAnterior=str_pad('14250',20,"0",STR_PAD_LEFT);
                        $RowDeclaracionAnterior=str_pad('0',13,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad('000',15,"0",STR_PAD_LEFT);
                        $RowImporteDecl=str_pad('100',11,"0",STR_PAD_LEFT);     
                        $RowImporte=str_pad('100',11,"0",STR_PAD_LEFT);        
                        $RowTipoEstabl=str_pad('',20);          
                        $RowTipoContrib=str_pad('',20);          
                        $RowAlr=str_pad('1',4,"0",STR_PAD_LEFT);          
                        $RowAutosEnajenUnidades=str_pad('',12,"0",STR_PAD_LEFT);          
                        $RowCamionesEnajenUnidades=str_pad('',12,"0",STR_PAD_LEFT);        
                        $RowAutosExeUnidades=str_pad('',12,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtUnidades=str_pad('',12,"0",STR_PAD_LEFT);         
                        $RowAutosEnajenValor=str_pad('',15,"0",STR_PAD_LEFT);  
                        $RowCamionesEnajenValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowAutosExtValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowTotalUnidades=str_pad('',12,"0",STR_PAD_LEFT);          
                        $RowTotalValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowVehiculosIncorp=str_pad('',12,"0",STR_PAD_LEFT);   
                        $RowFacturasExpInicial=str_pad('',12,"0",STR_PAD_LEFT);         
                        $RowFacturasExpFinal=str_pad('',12,"0",STR_PAD_LEFT);    
                        $RowVehiculosenajenados=str_pad('',12,"0",STR_PAD_LEFT);  
                        $RowValorTotEnajena=str_pad('',15,"0",STR_PAD_LEFT);
                        $RowFuente=str_pad('0015',4);          
                        $RowClaveImpuesto=str_pad('0010',4);
                        $declaracion="Normal";
                        $impuesto="1000";
                        $actualizacion="2000";
                        $recargos="1200";
                        $dif_imp="1300";
                        $dif_act="1200";
                        $dif_rec="5000";

                    }else{
                    foreach ($ish as $is ) {
                        $RowCuenta=str_pad($is->cuenta,11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad($is->curp,18," ",STR_PAD_LEFT);///pendiente
                        $RowRazonSocial=str_pad(mb_convert_encoding($is->nombre_razonS, "Windows-1252", "UTF-8"),150);
                        $RowTipoDeclaracion=str_pad(Str::limit($is->tipo_declaracion,1,''),1);
                        $RowPeriodicidad=str_pad('M',1);                         
                        $RowAnoDeclarado=str_pad($is->anio,4,"0",STR_PAD_LEFT);
                        $RowMesDeclarado=str_pad($is->mes,2,"0",STR_PAD_LEFT);
                        $RowNoComple=str_pad($is->num_complementaria,1,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad($is->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowDeclaracionAnterior=str_pad((int)$is->declaracion_anterior,13,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad((int)$is->erogaciones,15,"0",STR_PAD_LEFT);
                        $RowTipoEstabl=str_pad('',20);          
                        $RowTipoContrib=str_pad('',20);          
                        $RowAlr=str_pad('0000',4);          
                        $RowAutosEnajenUnidades=str_pad('',12,"0",STR_PAD_LEFT);          
                        $RowCamionesEnajenUnidades=str_pad('',12,"0",STR_PAD_LEFT);        
                        $RowAutosExeUnidades=str_pad('',12,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtUnidades=str_pad('',12,"0",STR_PAD_LEFT);         
                        $RowAutosEnajenValor=str_pad('',15,"0",STR_PAD_LEFT);  
                        $RowCamionesEnajenValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowAutosExtValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowTotalUnidades=str_pad('',12,"0",STR_PAD_LEFT);          
                        $RowTotalValor=str_pad('',15,"0",STR_PAD_LEFT);          
                        $RowVehiculosIncorp=str_pad('',12,"0",STR_PAD_LEFT);   
                        $RowFacturasExpInicial=str_pad('',12,"0",STR_PAD_LEFT);         
                        $RowFacturasExpFinal=str_pad('',12,"0",STR_PAD_LEFT);  
                        $RowVehiculosenajenados=str_pad('',12,"0",STR_PAD_LEFT);    
                        $RowValorTotEnajena=str_pad('1',15,"0",STR_PAD_LEFT);
                        $RowFuente=str_pad('0015',4);          
                        $RowClaveImpuesto=str_pad('0010',4);
                        $declaracion=$is->tipo_declaracion;
                        $impuesto=$is->impuesto;
                        $actualizacion=$is->actualizacion;
                        $recargos=$is->recargos;
                        $dif_imp=$is->dif_imp;
                        $dif_act=$is->dif_act;
                        $dif_rec=$is->dif_rec;
                        
                        }
                    }  
                }else{
                    foreach ($isan as $i) {

                        $RowCuenta=str_pad($i->cuenta,11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad($i->curp,18," ",STR_PAD_LEFT);
                        $RowRazonSocial=str_pad(mb_convert_encoding($i->nombre_razonS, "Windows-1252", "UTF-8"),150);
                        $RowTipoDeclaracion=str_pad(Str::limit($i->tipo_declaracion,1,''),1);
                        $RowPeriodicidad=str_pad(Str::limit($i->tipo_tramite,1,''),1);
                        $RowAnoDeclarado=str_pad($i->anio_1,4);
                        $RowMesDeclarado=str_pad($i->mes_1,2,"0",STR_PAD_LEFT);
                        $RowNoComple=str_pad($i->num_complementaria,1);
                        $RowFolioAnterior=str_pad($i->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowDeclaracionAnterior=str_pad((int)$i->declaracion_anterior,13,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad('',15,"0",STR_PAD_LEFT);     
                        $RowTipoEstabl=str_pad($i->tipo_establecimiento,20,"0",STR_PAD_LEFT);          
                        $RowTipoContrib=str_pad($i->tipo_contribuyente,20,"0",STR_PAD_LEFT);          
                        $RowAlr=str_pad($i->ALR,4,"0",STR_PAD_LEFT);          
                        $RowAutosEnajenUnidades=str_pad((int)$i->autos_enajenados_unidades,12,"0",STR_PAD_LEFT);          
                        $RowCamionesEnajenUnidades=str_pad((int)$i->camiones_enajenados_unidades,12,"0",STR_PAD_LEFT);   
                        $RowAutosExeUnidades=str_pad((int)$i->autos_exentos_unidades,12,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtUnidades=str_pad((int)$i->vehiculos_exentos_unidades,12,"0",STR_PAD_LEFT);        
                        $RowAutosEnajenValor=str_pad((int)$i->autos_enajenados_valor,15,"0",STR_PAD_LEFT);  
                        $RowCamionesEnajenValor=str_pad((int)$i->camiones_enajenados_valor,15,"0",STR_PAD_LEFT);          
                        $RowAutosExtValor=str_pad((int)$i->autos_exentos_valor,15,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtValor=str_pad((int)$i->vehiculos_exentos_valor,15,"0",STR_PAD_LEFT);          
                        $RowTotalUnidades=str_pad((int)$i->total_unidades,12,"0",STR_PAD_LEFT);          
                        $RowTotalValor=str_pad((int)$i->total_valor,15,"0",STR_PAD_LEFT);          
                        $RowVehiculosIncorp=str_pad((int)$i->vehiculos_incorporados,12,"0",STR_PAD_LEFT);   
                        $RowFacturasExpInicial=str_pad((int)$i->facturas_expedidas_inicial,12,"0",STR_PAD_LEFT);         
                        $RowFacturasExpFinal=str_pad((int)$i->facturas_expedidas_final,12,"0",STR_PAD_LEFT);
                        $RowVehiculosenajenados=str_pad($i->vehiculos_enajenados_periodo,12,"0",STR_PAD_LEFT);    
                        $RowValorTotEnajena=str_pad((int)$i->valor_total_enajenacion,15,"0",STR_PAD_LEFT);
                        $RowFuente=str_pad('0015',4);          
                        $RowClaveImpuesto=str_pad('5001',4);                       
                        $declaracion=$i->tipo_declaracion;
                        $impuesto=$i->impuesto;
                        $actualizacion=$i->actualizacion;
                        $recargos=$i->recargos;
                        $dif_imp=$i->dif_impuesto;
                        $dif_act=$i->dif_actualizacion;
                        $dif_rec=$i->dif_recargos;
                    }
                }
                  
        
                    $RowTipoPagoD=str_pad($trans->tipopago,2,"0",STR_PAD_LEFT);      
                    $RowEmpleados=str_pad('',10,"0",STR_PAD_LEFT);
                    
                    foreach (json_decode($consepto) as $cont) {
                        if($cont->clave=="01")
                        {
                            $RowImporte=str_pad(str_replace(".",$impuesto,""),11,"0",STR_PAD_LEFT);
                            $RowImporteDecl=str_pad(str_replace(".",$impuesto,""),11,"0",STR_PAD_LEFT);
                        }
                        if($cont->clave=="02")
                        {
                            $RowImporte=str_pad(str_replace(".", $actualizacion,""),11,"0",STR_PAD_LEFT);
                            $RowImporteDecl=str_pad(str_replace(".",$actualizacion,""),11,"0",STR_PAD_LEFT);
                        }
                        if($cont->clave=="03")
                        {
                            $RowImporte=str_pad(str_replace(".",$recargos,"" ),11,"0",STR_PAD_LEFT);
                            $RowImporteDecl=str_pad(str_replace(".",$recargos, ""),11,"0",STR_PAD_LEFT);
                        }                       
                        if($declaracion=="Complementaria")
                        {
                            if($cont->clave=="01")
                            {
                            $RowImporte=str_pad(str_replace(".", $dif_imp,""),11,"0",STR_PAD_LEFT);
                            }
                            if($cont->clave=="02")
                            {
                            $RowImporte=str_pad(str_replace(".", $dif_act,""),11,"0",STR_PAD_LEFT);
                            }
                            if($cont->clave=="03")
                            {
                            $RowImporte=str_pad(str_replace(".", $dif_rec,""),11,"0",STR_PAD_LEFT);
                            }
                        }
                        if($RowPeriodicidad=="A")
                        {
                            $RowClaveImpuesto=str_pad('5002',4);
                        }
                        $RowClaveConsepto=str_pad($cont->clave,2);
                        $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT);
                        $cadena=$RowIdTrans.$RowFolio.$RowRfc.$RowCuenta.$RowCurp.$RowRazonSocial.$RowTipoPagoD.$RowTipoDeclaracion.$RowPeriodicidad.$RowAnoDeclarado.$RowMesDeclarado.$RowNoComple.$RowFolioAnterior.$RowDeclaracionAnterior.$RowEmpleados.$RowRenumeracion.$RowClaveConsepto.$RowImporteDecl.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaBanco.$RowTipoPago.$RowTotalTramite.$RowPartida.$RowImporte.$RowTipoEstabl.$RowTipoContrib.$RowAlr.$RowAutosEnajenUnidades.$RowCamionesEnajenUnidades.$RowAutosExeUnidades.$RowVehiculosExtUnidades.$RowAutosEnajenValor.$RowCamionesEnajenValor.$RowAutosExtValor.$RowVehiculosExtValor.$RowTotalUnidades.$RowTotalValor.$RowVehiculosIncorp.$RowFacturasExpInicial.$RowFacturasExpFinal.$RowVehiculosenajenados.$RowValorTotEnajena.$RowFuente.$RowClaveImpuesto;
                        //$dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                        File::append($path,$cadena."\r\n");
                    }                
                }            
            }
        }      
    }
    private function gArchivo_ISOP()
    {
        $nombreArchivo=Carbon::now();
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_ISOP'.'.txt');       
        File::delete($path);
        $response = array();
        $cadena='';        
        ///***tramites array***/////
        $Servicios= array('15');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $RowFechaCorte=str_pad(Carbon::parse($concilia->created_at)->format('Ymd'),8); 

        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,9,"0",STR_PAD_LEFT);
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('Hms'),6);
                $RowFechaDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);         
                $RowHoraDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);
                 if(strlen($RowFechaDispersion)==13)
                {
                    $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);

                } 
                else{
                    $RowFechaDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('H:m:s'),8);

                }   
                $RowTipoPago=str_pad($trans->TipoPago,2,"0",STR_PAD_LEFT);
               
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {                     
                       $RowFolio=str_pad('',11,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad('',13," ",STR_PAD_LEFT);
                    }else{
                    foreach ($folio as $fol) {                       
                       $RowFolio=str_pad($fol->Folio,11,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad($fol->CartKey1,13," ",STR_PAD_LEFT);
                    }
                }
                $isop=$this->detalleisopdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($isop->count()==0)
                    {
                            $RowCuentaEstatal=str_pad('1',11,"0",STR_PAD_LEFT);             
                            $RowCurp=str_pad('CURP423452TR43HN06',18);        
                            $RowNombreRazonS=str_pad('Nombre Razon Social',120);
                            $RowMesDeclarado=str_pad('02',2,"0",STR_PAD_LEFT);
                            $RowAnoDeclarado=str_pad('2019',4);
                            $RowTipoDeclaracion=str_pad('N',1);
                            $RowPremio=str_pad('100',15,"0",STR_PAD_LEFT);
                            $RowImpuesto=str_pad('100',15,"0",STR_PAD_LEFT);
                            $RowActualizacion=str_pad('100',15,"0",STR_PAD_LEFT);
                            $RowRecargos=str_pad('100',15,"0",STR_PAD_LEFT);
                            $RowTotalContr=str_pad('100',15,"0",STR_PAD_LEFT);

                    }else{
                        foreach ($isop as $iso) {
                           
                            $RowCuentaEstatal=str_pad($iso->cuenta,11,"0",STR_PAD_LEFT);   
                            $RowCurp=str_pad($iso->curp,18);        
                            $RowNombreRazonS=str_pad(mb_convert_encoding($iso->nombre_razonS, "Windows-1252", "UTF-8"),120);
                            $RowMesDeclarado=str_pad($iso->mes,2,"0",STR_PAD_LEFT);
                            $RowAnoDeclarado=str_pad($iso->anio,4);
                            $RowTipoDeclaracion=str_pad($iso->tipo_dec,1,"0",STR_PAD_LEFT);
                            $RowPremio=str_pad($iso->premio,15,"0",STR_PAD_LEFT);
                            $RowImpuesto=str_pad(str_replace(".", "",$iso->impuesto),15,"0",STR_PAD_LEFT);
                            $RowActualizacion=str_pad(str_replace(".", "",$iso->actualizacion),15,"0",STR_PAD_LEFT);
                            $RowRecargos=str_pad(str_replace(".", "",$iso->recargos),15,"0",STR_PAD_LEFT);
                            $RowTotalContr=str_pad(str_replace(".", "",$iso->total_contribuciones),15,"0",STR_PAD_LEFT);
                        }
                    }
                         
                $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCuentaEstatal.$RowCurp.$RowNombreRazonS.$RowTipoPago.$RowMesDeclarado.$RowAnoDeclarado.$RowTipoDeclaracion.$RowPremio.$RowImpuesto.$RowActualizacion.$RowRecargos.$RowTotalContr.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte;
                //$dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                File::append($path,$cadena."\r\n");
                }            
            }
        }       
    }
    private function gArchivo_Prestadora_Servicios()
    {        
        $nombreArchivo=Carbon::now(); 
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_Prestadora_de_Servicios'.'.txt');       
        File::delete($path);
        $response = array(); 
        $cadena='';        
        ///***tramites array***/////
        $conseptoo = array();
        $impuesto;
        $actualizacion;
        $recargos;
        $cant_acreditada;
        $dif_imp;
        $dif_act;
        $dif_rec;
        $conseptoo []=array('clave' => '01','consepto'=>'Impuesto','partida'=>'12511');
        $conseptoo []=array('clave' => '02','consepto'=>'Actualizacion','partida'=>'12513');
        $conseptoo []=array('clave' => '03','consepto'=>'Recargos','partida'=>'40214');
        $conseptoo []=array('clave' => '06','consepto'=>'cant_acreditada','partida'=>'12512');
        $consepto=json_encode($conseptoo);
        $declaracion;
        $Servicios= array('23');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $RowFechaCorte=str_pad(Carbon::parse($concilia->created_at)->format('Ymd'),8);
        $RowBanco=str_pad($concilia->banco_id,4,"0",STR_PAD_LEFT);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
               
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('H:m:s'),8);
                $RowFechaDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);         
                $RowHoraDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);
                 if(strlen($RowFechaDispersion)==13)
                {
                    $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);

                } 
                else{
                    $RowFechaDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('H:m:s'),8);

                }      
                $RowTotalTramite=str_pad(str_replace(".", "", $trans->TotalTramite),11,"0",STR_PAD_LEFT);
                             
                $detalleisn=$this->detalleisnprestadoradb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleisn->count()==0)
                    {                            
                        $RowIdTrans=str_pad('1',20,"0",STR_PAD_LEFT);
                            $RowFolio=str_pad('1',20,"0",STR_PAD_LEFT);        
                            $RowRfcAlfa=str_pad('1',4,"0",STR_PAD_LEFT);  
                            $RowRfcCnum=str_pad('1',6,"0",STR_PAD_LEFT);  
                            $RowRfcChom=str_pad('1',3,"0",STR_PAD_LEFT);  
                            $RowCuenta=str_pad('1',11,"0",STR_PAD_LEFT);        
                            $RowNombreRazonS=str_pad('',150);
                            $RowTipoDeclaracion=str_pad('N',1);
                            $RowValorFijo=str_pad('1',1);
                            $RowAno=str_pad('2019',4);
                            $RowMes=str_pad('09',2,"0",STR_PAD_LEFT);       
                            $RowFolioAnterior=str_pad('1',20,"0",STR_PAD_LEFT);
                            $RowNumComplem=str_pad('1',1,"0",STR_PAD_LEFT);
                            $RowImptAnterior=str_pad('100',13,"0",STR_PAD_LEFT);
                            $RowEmpleados=str_pad('1',6,"0",STR_PAD_LEFT);
                            $RowRenumeracion=str_pad('',15,"0",STR_PAD_LEFT);
                            $RowClave=str_pad('',2,"0",STR_PAD_LEFT);
                            $RowImporteC=str_pad('100',11,"0",STR_PAD_LEFT);                
                            $RowPartida=str_pad('',5,"0",STR_PAD_LEFT);
                            $RowImporte=str_pad('100',11,"0",STR_PAD_LEFT);
                            $declaracion="Normal";
                            $impuesto="2000";
                            $cant_acreditada="1000";
                            $actualizacion="3000";
                            $recargos="2100";
                            $dif_imp="1000";
                            $dif_act="1000";
                            $dif_rec="4000";
                    }else{
                        foreach ($detalleisn as $isn) {
                           $RowIdTrans=str_pad($isn->idtrans,20,"0",STR_PAD_LEFT);
                            $RowFolio=str_pad($isn->Folio,20,"0",STR_PAD_LEFT);     
                            $RowRfcAlfa=str_pad($isn->rfcalfa,4,"0",STR_PAD_LEFT);  
                            $RowRfcCnum=str_pad($isn->rfcnum,6,"0",STR_PAD_LEFT);  
                            $RowRfcChom=str_pad($isn->rfchom,3,"0",STR_PAD_LEFT);  
                            $RowCuenta=str_pad($isn->cuenta,11,"0",STR_PAD_LEFT);
                            $RowNombreRazonS=mb_convert_encoding($isn->nombre_razonS,"Windows-1252", "UTF-8");
                            $RowNombreRazonS=str_pad(mb_convert_encoding($RowNombreRazonS,"Windows-1252", "UTF-8"),150);
                            $RowTipoDeclaracion=str_pad(Str::limit($isn->tipo_declaracion, 1,''),1,"0",STR_PAD_LEFT);
                            $RowValorFijo=str_pad('1',1);
                            $RowAno=str_pad($isn->anio,4);
                            $RowMes=str_pad($isn->mes,2,"0",STR_PAD_LEFT);       
                            $RowFolioAnterior=str_pad($isn->folio_anterior,20,"0",STR_PAD_LEFT);
                            $RowNumComplem=str_pad(Str::limit($isn->num_complementaria, 1,''),1,"0",STR_PAD_LEFT);
                            $RowImptAnterior=str_pad(str_replace(".", "",$isn->declaracion_anterior),13,"0",STR_PAD_LEFT);
                            $RowEmpleados=str_pad($isn->no_empleados,6,"0",STR_PAD_LEFT);
                            $RowRenumeracion=str_pad(str_replace(".", "",$isn->remuneraciones),15,"0",STR_PAD_LEFT);
                            $declaracion=$isn->tipo_declaracion;
                            $impuesto=$isn->impuesto;
                            $cant_acreditada=$isn->cant_acreditada;
                            $actualizacion=$isn->actualizacion;
                            $recargos=$isn->recargos;
                            $dif_imp=$isn->dif_impuesto;
                            $dif_act=$isn->dif_actualizacion;
                            $dif_rec=$isn->dif_recargos;                            
                                             
                        }
                    }
                    foreach (json_decode($consepto) as $cont) {

                    $RowClave=str_pad($cont->clave,2,"0",STR_PAD_LEFT);                      
                        if($cont->clave=="01")
                        {
                            $RowImporteC=str_pad(str_replace(".",$impuesto,""),11,"0",STR_PAD_LEFT);
                            $RowImporte=str_pad(str_replace(".",$impuesto,""),11,"0",STR_PAD_LEFT);
                            $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT); 
                        }
                        if($cont->clave=="02")
                        {
                            $RowImporteC=str_pad(str_replace(".", $actualizacion,""),11,"0",STR_PAD_LEFT);
                            $RowImporte=str_pad(str_replace(".",$actualizacion,""),11,"0",STR_PAD_LEFT);
                            $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT); 
                        }
                        if($cont->clave=="03")
                        {
                            $RowImporteC=str_pad(str_replace(".",$recargos,"" ),11,"0",STR_PAD_LEFT);
                            $RowImporte=str_pad(str_replace(".",$recargos, ""),11,"0",STR_PAD_LEFT);
                            $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT); 
                        }
                        if($cont->clave=="06")
                        {
                            $RowImporteC=str_pad(str_replace(".",$cant_acreditada,"" ),11,"0",STR_PAD_LEFT);
                            $RowImporte=str_pad(str_replace(".",$cant_acreditada, ""),11,"0",STR_PAD_LEFT);
                            $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT); 
                        }                       
                        if($RowTipoDeclaracion=="Complementaria")
                        {
                            if($cont->clave=="01")
                            {
                            $RowImporte=str_pad(str_replace(".", $dif_imp,""),11,"0",STR_PAD_LEFT);
                            }
                            if($cont->clave=="02")
                            {
                            $RowImporte=str_pad(str_replace(".", $dif_act,""),11,"0",STR_PAD_LEFT);
                            }
                            if($cont->clave=="03")
                            {
                            $RowImporte=str_pad(str_replace(".", $dif_rec,""),11,"0",STR_PAD_LEFT);
                            }
                        }
                       
                       $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuenta.$RowNombreRazonS.$RowTipoDeclaracion.$RowValorFijo.$RowAno.$RowMes.$RowFolioAnterior.$RowNumComplem.$RowImptAnterior.$RowEmpleados.$RowRenumeracion.$RowClave.$RowImporteC.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite.$RowPartida.$RowImporte;
                        //$dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                        File::append($path,$cadena."\r\n");
                    }
                        
                }            
            }
        }
      
        //$this->enviacorreo($txt);
    }
    private function gArchivo_Retenedora_Servicios()
    {
        $nombreArchivo=Carbon::now(); 
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_Retenedora_de_Servicios'.'.txt');       
        File::delete($path);
        $response = array();
        $cadena='';        
        ///***tramites array***/////
        $Servicios= array('24');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
            $RowFechaCorte=str_pad(Carbon::parse($concilia->crated_at)->format('Ymd'),8);
            $RowBanco=str_pad($concilia->banco_id,4,"0",STR_PAD_LEFT);
            $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {               
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('H:m:s'),8);
               $RowFechaDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);         
                $RowHoraDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);
                 if(strlen($RowFechaDispersion)==13)
                {
                    $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);

                } 
                else{
                    $RowFechaDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('H:m:s'),8);

                }          
                $RowTotalTramite=str_pad(str_replace(".", "", $trans->TotalTramite),13,"0",STR_PAD_LEFT);
                             
                $detalleisnr=$this->detalleisnretenedordb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleisnr->count()==0)
                    {
                        $RowIdTrans=str_pad('1',20,"0",STR_PAD_LEFT);
                        $RowFolio=str_pad('1',20,"0",STR_PAD_LEFT);        
                        $RowRfcAlfa=str_pad('1',4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad('1',6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad('1',3,"0",STR_PAD_LEFT);  
                        $RowCuentaRet=str_pad('1',11,"0",STR_PAD_LEFT);    
                        $RowTipoDeclaracion=str_pad('N',1);
                        $RowAno=str_pad('2019',4);
                        $RowMes=str_pad('11',2,"0",STR_PAD_LEFT);  
                        $RowNumComplem=str_pad('N',1,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad('1',20,"0",STR_PAD_LEFT);
                        $RowImptDeclaracion=str_pad('100',13,"0",STR_PAD_LEFT);
                       $RowActualizaciones=str_pad('0',13,"0",STR_PAD_LEFT);
                       $RowRecargos=str_pad('000',13,"0",STR_PAD_LEFT);

                    }else{
                        foreach ($detalleisnr as $isn) {
                        $RowIdTrans=str_pad($isn->idtrans,20,"0",STR_PAD_LEFT);
                        $RowFolio=str_pad($isn->Folio,20,"0",STR_PAD_LEFT);        
                        $RowRfcAlfa=str_pad($isn->rfcalfa,4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad($isn->rfcnum,6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad($isn->rfchom,3,"0",STR_PAD_LEFT);  
                        $RowCuentaRet=str_pad($isn->cuenta,11,"0",STR_PAD_LEFT);    
                        $RowTipoDeclaracion=str_pad(Str::limit($isn->tipo_declaracion, 1,''),1,"0",STR_PAD_LEFT);
                        $RowAno=str_pad($isn->anio,4);
                        $RowMes=str_pad($isn->mes,2,"0",STR_PAD_LEFT);  
                        $RowNumComplem=str_pad(str_replace(".",$isn->num_complementaria,""),1,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad(str_replace(".",$isn->folio_anterior,""),20,"0",STR_PAD_LEFT);
                        $RowImptDeclaracion=str_pad(str_replace(".", "", $isn->declaracion_anterior),13,"0",STR_PAD_LEFT);
                         $RowActualizaciones=str_pad(str_replace(".",$isn->actualizacion,""),13,"0",STR_PAD_LEFT);
                        $RowRecargos=str_pad(str_replace(".",$isn->recargos,""),13,"0",STR_PAD_LEFT);
                        }

                    }
                $detalleretenciones=$this->detalleretencionesdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleretenciones->count()==0)
                    {
                        
                        $RowNombreRet=str_pad('Nombre Ret',150);
                        $RowRfcPrest=str_pad('2',13,"0",STR_PAD_LEFT);
                        $RowCuentaPrest=str_pad('1',11,"0",STR_PAD_LEFT);
                        $RowNombrePrest=str_pad('Nombre Prest',150);
                        $RowEmpleados=str_pad('1',6,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad('100',15,"0",STR_PAD_LEFT);
                        $RowRetencion=str_pad('100',13,"0",STR_PAD_LEFT); 
                           
                    }else{
                        foreach ($detalleretenciones as $retenciones) {
                        $RowNombreRet=str_pad(mb_convert_encoding($retenciones->nombre_retenedora, "Windows-1252", "UTF-8"),150);
                        $RowRfcPrest=str_pad(mb_convert_encoding($retenciones->rfc_prestadora, "Windows-1252", "UTF-8"),13);
                        $RowCuentaPrest=str_pad($retenciones->cuenta,11,"0",STR_PAD_LEFT);
                        $RowNombrePrest=str_pad(mb_convert_encoding($retenciones->nombre_prestadora, "Windows-1252", "UTF-8"),150);
                        $RowEmpleados=str_pad($retenciones->no_empleados,6,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad(str_replace(".", "", $retenciones->remuneraciones),15,"0",STR_PAD_LEFT); 
                        $RowRetencion=str_pad(str_replace(".","",$retenciones->retencion),13,"0",STR_PAD_LEFT);
                        }
                    } 

                    $RowPartidaRet=str_pad('12510',5);
                    $RowPartidaActu=str_pad('40215',5);
                    $RowPartidaRecargo=str_pad('12514',5); 
                $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuentaRet.$RowNombreRet.$RowRfcPrest.$RowCuentaPrest.$RowNombrePrest.$RowTipoDeclaracion.$RowAno.$RowMes.$RowNumComplem.$RowFolioAnterior.$RowImptDeclaracion.$RowEmpleados.$RowRenumeracion.$RowPartidaRet.$RowRetencion.$RowPartidaActu.$RowActualizaciones.$RowPartidaRecargo.$RowRecargos.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite;
                //$dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
               File::append($path,$cadena."\r\n");
                }            
            }
        }
      
        //$this->enviacorreo($txt);
    }

    private function gArchivo_Juegos_Apuestas()
    {        
        $nombreArchivo=Carbon::now();
        $path=storage_path('app/Cortes/Cortes_'.$nombreArchivo->format('Y').'/Cortes_'.$nombreArchivo->format('Y_m').'/Corte_'.$nombreArchivo->format('Y_m_d').'/'.$nombreArchivo->format('Y_m_d').'_Corte_Juegos_Apuestas'.'.txt');       
        File::delete($path);
        $response = array();
        $cadena='';        
        ///***tramites array***/////
        $conseptoo = array();
        $conseptoo []=array('clave' => '0021','consepto'=>'imp_pre_isop','partida'=>'12700','total'=>'12700');
        $conseptoo []=array('clave' => '0021','consepto'=>'act_pre_isop','partida'=>'12701','total'=>'12701');
        $conseptoo []=array('clave' => '0021','consepto'=>'rec_pre_isop','partida'=>'12702','total'=>'12702');
        $conseptoo []=array('clave' => '0022','consepto'=>'imp_apu_isop','partida'=>'15001','total'=>'15001');
        $conseptoo []=array('clave' => '0022','consepto'=>'act_apu_isop','partida'=>'15002','total'=>'15002');
        $conseptoo []=array('clave' => '0022','consepto'=>'rec_apu_isop','partida'=>'15003','total'=>'15003');
        $conseptoo []=array('clave' => '0023','consepto'=>'imp_jys_isop','partida'=>'15101','total'=>'15101');
        $conseptoo []=array('clave' => '0023','consepto'=>'act_jys_isop','partida'=>'15102','total'=>'15102');
        $conseptoo []=array('clave' => '0023','consepto'=>'rec_jys_isop','partida'=>'15103','total'=>'15103');
        $consepto=json_encode($conseptoo);
        $importe;
        $Servicios= array('25');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-11-08 00:00:00'],['created_at','<','2019-11-08 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
            $RowFechaCorte=str_pad(Carbon::parse($concilia->created_at)->format('Ymd'),8);

            $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,20,"0",STR_PAD_LEFT);
               
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('H:m:s'),8);
                $RowFechaDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);         
                $RowHoraDispersion=str_replace("Por Operacion", "", $trans->Clabe_FechaDisp);
                 if(strlen($RowFechaDispersion)==13)
                {
                    $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);

                } 
                else{
                    $RowFechaDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('Ymd'),8);
                    $RowHoraDispersion=str_pad(Carbon::parse($trans->Clabe_FechaDisp)->format('H:m:s'),8);

                }    
                $RowTipoPago=str_pad($trans->TipoPago,4,"0",STR_PAD_LEFT);              
                $RowTotalTramite=str_pad(str_replace(".", "",$trans->TotalTramite ),13,"0",STR_PAD_LEFT);
                
                $folio=$this->foliosdb->findwhere([]);
                if($folio->count()==0){
                     $RowFolio=str_pad('1',20,"0",STR_PAD_LEFT);
                     $RowDescrip=str_pad('D',150);
                }
                else{
                    foreach ($folio as $fol) {
                        $RowFolio=str_pad($fol->Folio,20,"0",STR_PAD_LEFT);        
                        $RowDescrip=str_pad(mb_convert_encoding($fol->CartDescripcion, "Windows-1252", "UTF-8"),150);
                    }
                }               
                $det=$this->detimpisopdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($det->count()==0)
                    {      
                       
                       $RowRfcAlfa=str_pad('1',4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad('1',6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad('1',3,"0",STR_PAD_LEFT);  
                        $RowClaveMun=str_pad('1',3,"0",STR_PAD_LEFT);        
                        $RowCuenta=str_pad('1',11,"0",STR_PAD_LEFT);                       
                        $RowCurp=str_pad('1',18,"0",STR_PAD_LEFT);
                        $RowClave=str_pad('1',4,"0",STR_PAD_LEFT);
                        $RowTipoDeclaracion=str_pad('N',1,"0",STR_PAD_LEFT);
                        $RowNumComplem=str_pad('1',1,"0",STR_PAD_LEFT);
                        $RowAno=str_pad('2019',4,"0",STR_PAD_LEFT);
                        $RowMes=str_pad('1',2,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad('1',20,"0",STR_PAD_LEFT);
                        $RowImporteAnterior=str_pad('100',13,"0",STR_PAD_LEFT);
                        $RowPartida=str_pad('1',5,"0",STR_PAD_LEFT);
                        $RowImporte=str_pad('100',13,"0",STR_PAD_LEFT);
                        $RowTotal=str_pad('100',13,"0",STR_PAD_LEFT);
                        $importe="1000";

                    }else{
                        foreach ($det as $isop) {                                
                       $RowRfcAlfa=str_pad($isop->rfcalf,4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad($isop->rfcnum,6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad($isop->rfchom,3,"0",STR_PAD_LEFT);  
                        $RowClaveMun=str_pad($isop->cve_mpo,3,"0",STR_PAD_LEFT);        
                        $RowCuenta=str_pad($isop->cuenta,11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad($isop->curp,18);
                        $RowClave=str_pad($isop->cve_imp,4,"0",STR_PAD_LEFT);      
                        $RowTipoDeclaracion=str_pad(Str::limit($isop->tipo_dec, 1,''),1,"0",STR_PAD_LEFT);        
                        $RowMes=str_pad($isop->mes,2,"0",STR_PAD_LEFT);
                        $RowAno=str_pad($isop->anio,4,"0",STR_PAD_LEFT);
                        $RowNumComplem=str_pad($isop->num_comp,1,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad($isop->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowImporteAnterior=str_pad(str_replace(".", "", $isop->imp_anterior),13,"0",STR_PAD_LEFT);     
                        $importe=$isop->imp_anterior;
                        }

                    }
                
                    foreach (json_decode($consepto) as $cont) {
                        $calc= (float)$cont->total-(float)$importe;
                        $calc=number_format($calc,2,'.','');
                        $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT);
                        $RowImporte=str_pad(str_replace(".", "",$calc ),13,"0",STR_PAD_LEFT);
                        $RowTotal=str_pad(str_replace(".", "",$cont->total."00" ),13,"0",STR_PAD_LEFT);
                        $RowClave=str_pad($cont->clave,2,"0",STR_PAD_LEFT);                      
                     
                        $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowClaveMun.$RowCuenta.$RowDescrip.$RowCurp.$RowClave.$RowTipoDeclaracion.$RowAno.$RowMes.$RowNumComplem.$RowFolioAnterior.$RowImporteAnterior.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowTipoPago.$RowTotalTramite.$RowPartida.$RowImporte.$RowTotal;
                        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                        File::append($path,$dataAnsi."\r\n");  
                    }  
                }            
            }
        }
        //$this->enviacorreo($txt);
    }
   
    private function enviacorreo()
    {   
         $nombreArchivo=Carbon::now();
        $path=storage_path('app\Cortes\Cortes_'.$nombreArchivo->format('Y').'\Cortes_'.$nombreArchivo->format('Y_m').'\Corte_'.$nombreArchivo->format('Y_m_d'));       
        $Archivos=File::allFiles($path);
        $subject ='Fecha de Corte '.$nombreArchivo->format('Y-m-d');
        $data = [ 'link' => 'https' ];
        $for = "juancarlos96.15.02@gmail.com";
        Mail::send('email',$data, function($msj) use($subject,$for,$Archivos,$path){
            $msj->from("juan.carlos.cruz.bautista@hotmail.com","Juan Carlos CB");
            $msj->subject($subject);
            $msj->to($for);
            foreach ($Archivos as $key) {
               $msj->attach($path.'/'.$key->getRelativePathname());
            }
            
        });

    }
}
