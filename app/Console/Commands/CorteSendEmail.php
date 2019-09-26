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
        EgobiernopartidasRepositoryEloquent $partidasdb

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
       //$this->insrtfolio();
        $this->gArchivo_Impuesto_Controlv(); ///        
        $this->gArchivo_Nomina();     ////        
        $this->gArchivo_ISAN_ISH();  /////
       $this->gArchivo_ISOP(); ////
        $this->gArchivo_Prestadora_Servicios(); ////
        $this->gArchivo_Retenedora_Servicios(); ////
        $this->gArchivo_Juegos_Apuestas();   ////
        //$this->gArchivo_Tenencia();
        //$this->gArchivo_Licencias();
        //$this->gArchivo_Carta_no_Inhabilita();
        $this->enviacorreo();
        //$this->corta();
    }
    private function corta()
    {
        $cadena='12345678';
        $cad=Str::limit($cadena, 10,'');

        log::info($cadena);
        log::info($cad);
    }
    
    private function gArchivo_Impuesto_Controlv()
    {

        
        $nombreArchivo=Carbon::now(); 
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_Impuesto_Control_Vehicular'.'.txt';
        File::delete(storage_path('app/txt/'.$txt));
        $response = array();
        $cadena='';
        $Servicios= array('1','30');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowClaveltramite=str_pad($trans->TipoServicio,6,"0",STR_PAD_LEFT);
                $RowFechapago=str_pad(Carbon::parse($trans->fechatramite)->format('Ymd'),8);
                $RowHorapago=str_pad(Carbon::parse($trans->HoraTramite)->format('hms'),6);
                
                $partidas=$this->partidasdb->findwhere(['id_servicio'=>$trans->TipoServicio]);
                if($partidas->count()==0)
                {
                    $RowPartida=str_pad('',5);
                    $RowConsepto=str_pad('',120);  
                }else{  
                    foreach ($partidas as $part) {                   
                            $RowPartida=str_pad($part->id_partida,5,"0",STR_PAD_LEFT);
                            $RowConsepto=str_pad($part->descripcion,120);                       
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
                         $RowTotalpago=str_pad($fol->CartImporte,11,"0",STR_PAD_LEFT);
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
            $RowOrigen=str_pad($concilia->origen,3,"0",STR_PAD_LEFT);//pendiente   
            $RowMedio_pago=str_pad('1',3,"0",STR_PAD_LEFT);//pendiente
            $RowFechaDis=str_pad('01082019',8);//pendiente
            $RowHoraDis=str_pad('140201',6);//pendiente
            $RowCuentaPago=str_pad($concilia->cuenta_banco,10,"0",STR_PAD_LEFT);//pendiente
            $RowDatoAdicional1=str_pad('',30,"0",STR_PAD_LEFT);//pendiente
            $RowDatoAdicional2=str_pad('',15,"0",STR_PAD_LEFT);//pendiente

            $cadena=$RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago.$RowDatoAdicional1.$RowDatoAdicional1;
            $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
            File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
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
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_Nomina'.'.txt';
        $response = array();        
       File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        /****** campos  ******/
        
        $Servicios= array('1');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,9,"0",STR_PAD_LEFT);        
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite, 10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite, 10,''))->format('Hms'),6);                 
                $RowFuente=str_pad($trans->fuente,4);         
                $RowTipoPagoT=str_pad($trans->TipoPago,4,"0",STR_PAD_LEFT);     
                $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Y-m-d'),10);         
                $RowHoraDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('H:m:s'),8); 

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('0000-00-00',8); 
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad(Carbon::parse($con->archivo)->format('Ymd'),8);   
                    }
                }
                $nomina=$this->nominadb->findwhere(['idTran'=>$trans->idTrans]);
                if($nomina->count()==0)
                    {  
                        $RowFolio=str_pad('',11,"0",STR_PAD_LEFT);
                        $RowMunnom=str_pad('',2,"0",STR_PAD_LEFT);
                        $RowClaveNombre=str_pad('',7,"0",STR_PAD_LEFT);
                        $RowRfcAlfa=str_pad('',4,"0",STR_PAD_LEFT);
                        $RowRfcNumero=str_pad('',6,"0",STR_PAD_LEFT);
                        $RowRfcHomoclave=str_pad('',3,"0",STR_PAD_LEFT);         
                        $RowTipoPagoN=str_pad('',1,"0",STR_PAD_LEFT);         
                        $RowMesDec=str_pad('',2,"0",STR_PAD_LEFT);
                        $RowTriDec=str_pad('',1,"0",STR_PAD_LEFT);        
                        $RowAnoDec=str_pad('',4,"0",STR_PAD_LEFT);         
                        $RowNumemp=str_pad('',6,"0",STR_PAD_LEFT);         
                        $RowRenumeracion=str_pad('',11,"0",STR_PAD_LEFT);        
                        $RowBase=str_pad('',11,"0",STR_PAD_LEFT);         
                        $RowActualiza=str_pad('',9,"0",STR_PAD_LEFT);         
                        $RowRecargos=str_pad('',7,"0",STR_PAD_LEFT);         
                        $RowGastosEjecucion=str_pad('',7,"0",STR_PAD_LEFT);     
                        $RowSancion=str_pad('',7,"0",STR_PAD_LEFT);
                        $RowCompensacion=str_pad('',11,"0",STR_PAD_LEFT);
                       
                    }else{
                    foreach ($nomina as $nom) {
                         
                        $RowFolio=str_pad($nom->folio,11,"0",STR_PAD_LEFT);
                        $RowMunnom=str_pad($nom->munnom,2,"0",STR_PAD_LEFT);
                        $RowClaveNombre=str_pad($nom->cvenom,7,"0",STR_PAD_LEFT);
                        $RowRfcAlfa=str_pad($nom->rfcalf,4,"0",STR_PAD_LEFT);
                        $RowRfcNumero=str_pad($nom->rfcnum,6,"0",STR_PAD_LEFT);
                        $RowRfcHomoclave=str_pad($nom->rfchomo,3,"0",STR_PAD_LEFT);         
                        $RowTipoPagoN=str_pad($nom->tipopago,1,"0",STR_PAD_LEFT);         
                        $RowMesDec=str_pad($nom->mesdec,2,"0",STR_PAD_LEFT);
                        $RowTriDec=str_pad($nom->mesdec,1);        
                        $RowAnoDec=str_pad($nom->anodec,4,"0",STR_PAD_LEFT);         
                        $RowNumemp=str_pad($nom->numemp,6,"0",STR_PAD_LEFT);         
                        $RowRenumeracion=str_pad($nom->remuneracion,11,"0",STR_PAD_LEFT);        
                        $RowBase=str_pad($nom->base,11,"0",STR_PAD_LEFT);         
                        $RowActualiza=str_pad($nom->actualiza,9,"0",STR_PAD_LEFT);         
                        $RowRecargos=str_pad($nom->recargos,7,"0",STR_PAD_LEFT);         
                        $RowGastosEjecucion=str_pad($nom->gtoeje,7,"0",STR_PAD_LEFT);     
                        $RowSancion=str_pad($nom->sancion,7,"0",STR_PAD_LEFT);
                        $RowCompensacion=str_pad($nom->compensacion,11,"0",STR_PAD_LEFT);
                    }
                }                
              
                
        $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252',$cadena);
                File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }
       
        //$this->enviacorreo($txt);
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
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_ISAN_ISH'.'.txt';
        File::delete(storage_path('app/txt/'.$txt));
        $response = array(); 
        $cadena='';        
        ///***tramites array***/////
        $Servicios= array('1');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,20,"0",STR_PAD_LEFT);
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite, 10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite, 10,''))->format('Hms'),8);
                $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Ymd'),8);         
                $RowHoraDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Hms'),8);
                $RowTipoPago=str_pad($trans->TipoPago,4,"0",STR_PAD_LEFT);
                $RowTotalTramite=str_pad($trans->TotalTramite,11,"0",STR_PAD_LEFT);

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaBanco=str_pad('00000000',8);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaBanco=str_pad($con->archivo,8);  
                    }
                }
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {                     
                       $RowFolio=str_pad('',20,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad('',13);
                    }else{
                    foreach ($folio as $fol) {                       
                       $RowFolio=str_pad($fol->Folio,20,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad($fol->CartKey1,13);
                    }
                }
                $isan=$this->detalleisandb->findwhere(['idTrans'=>$trans->idTrans]); 
                if($isan->count()==0)
                {
                    $ish=$this->detalleishdb->findwhere(['idTrans'=>$trans->idTrans]);
                    if($ish->count()==0){
                        $RowCuenta=str_pad('12012',11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad('LJIU02101',18);
                        $RowRazonSocial=str_pad('Razon Social ISAN/ISH',150);
                        $RowTipoDeclaracion=str_pad('1',1);
                        $RowAnoDeclarado=str_pad('2019',4);
                        $RowMesDeclarado=str_pad('01',2,"0",STR_PAD_LEFT);
                        $RowNoComple=str_pad('1',1);
                        $RowFolioAnterior=str_pad('14250',20,"0",STR_PAD_LEFT);
                        $RowDeclaracionAnterior=str_pad('0',13,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad('001',15,"0",STR_PAD_LEFT);
                        $RowImporteDecl=str_pad('0',11,"0",STR_PAD_LEFT);   //pendiente    
                        $RowImporte=str_pad('0',11,"0",STR_PAD_LEFT);   ///pendiente       
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
                        $RowValorTotEnajena=str_pad('',12,"0",STR_PAD_LEFT);
                        $RowFuente=str_pad('0015',4);          
                        $RowClaveImpuesto=str_pad('0010',4);
                    }else{
                    foreach ($ish as $is ) {
                        $RowCuenta=str_pad($is->cuenta,11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad($is->cuenta,18);
                        $RowRazonSocial=str_pad($is->nombre_razonS,150);
                        $RowTipoDeclaracion=str_pad($is->tipo_declaracion,1);
                        $RowAnoDeclarado=str_pad($is->anio,4,"0",STR_PAD_LEFT);
                        $RowMesDeclarado=str_pad($is->mes,2,"0",STR_PAD_LEFT);
                        $RowNoComple=str_pad($is->num_complementaria,1,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad($is->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowDeclaracionAnterior=str_pad($is->declaracion_anterior,13,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad($is->erogaciones,15,"0",STR_PAD_LEFT);
                        $RowImporteDecl=str_pad($is->tipo_declaracion,11,"0",STR_PAD_LEFT);   //pendiente    
                        $RowImporte=str_pad($is->dif_imp,11,"0",STR_PAD_LEFT);   ///pendiente       
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
                        $RowValorTotEnajena=str_pad('',12,"0",STR_PAD_LEFT);
                        $RowFuente=str_pad('0015',4);          
                        $RowClaveImpuesto=str_pad('0010',4);
                        }
                    }

                }else{
                    foreach ($isan as $i) {
                        $RowCuenta=str_pad($i->cuenta,11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad($i->curp,18);///pendiente
                        $RowRazonSocial=str_pad($i->nombre_razonS,150);
                        $RowTipoDeclaracion=str_pad($i->tipo_declaracion,1);
                        $RowAnoDeclarado=str_pad($i->anio_1,4);//pendiente
                        $RowMesDeclarado=str_pad($i->mes_1,2,"0",STR_PAD_LEFT);  //pendiente
                        $RowNoComple=str_pad($i->num_complementaria,1);
                        $RowFolioAnterior=str_pad($i->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowDeclaracionAnterior=str_pad($i->declaracion_anterior,13,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad('',15,"0",STR_PAD_LEFT);
                        $RowImporteDecl=str_pad($i->tipo_declaracion,11,"0",STR_PAD_LEFT);      ///pendiente 
                        $RowImporte=str_pad($i->monto,11,"0",STR_PAD_LEFT); //pendiente         
                        $RowTipoEstabl=str_pad($i->tipo_establecimiento,20,"0",STR_PAD_LEFT);          
                        $RowTipoContrib=str_pad($i->tipo_contribuyente,20,"0",STR_PAD_LEFT);          
                        $RowAlr=str_pad($i->ALR,4,"0",STR_PAD_LEFT);          
                        $RowAutosEnajenUnidades=str_pad($i->autos_enajenados_unidades,12,"0",STR_PAD_LEFT);          
                        $RowCamionesEnajenUnidades=str_pad($i->camiones_enajenados_unidades,12,"0",STR_PAD_LEFT);       
                        $RowAutosExeUnidades=str_pad($i->autos_exentos_unidades,12,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtUnidades=str_pad($i->vehiculos_exentos_unidades,12,"0",STR_PAD_LEFT);         
                        $RowAutosEnajenValor=str_pad($i->autos_enajenados_valor,15,"0",STR_PAD_LEFT);  
                        $RowCamionesEnajenValor=str_pad($i->camiones_enajenados_valor,15,"0",STR_PAD_LEFT);          
                        $RowAutosExtValor=str_pad($i->autos_exentos_valor,15,"0",STR_PAD_LEFT);          
                        $RowVehiculosExtValor=str_pad($i->vehiculos_exentos_valor,15,"0",STR_PAD_LEFT);          
                        $RowTotalUnidades=str_pad($i->total_unidades,12,"0",STR_PAD_LEFT);          
                        $RowTotalValor=str_pad($i->total_valor,15,"0",STR_PAD_LEFT);          
                        $RowVehiculosIncorp=str_pad($i->vehiculos_incorporados,12,"0",STR_PAD_LEFT);   
                        $RowFacturasExpInicial=str_pad($i->facturas_expedidas_inicial,12,"0",STR_PAD_LEFT);         
                        $RowFacturasExpFinal=str_pad($i->facturas_expedidas_final,12,"0",STR_PAD_LEFT);      
                        $RowValorTotEnajena=str_pad($i->valor_total_enajenacion,12,"0",STR_PAD_LEFT);
                        $RowFuente=str_pad('0015',4);          
                        $RowClaveImpuesto=str_pad('0010',4); ///pendiente
                    }
                }  
        
                    $RowTipoPagoD=str_pad('00',2);        
                    $RowEmpleados=str_pad('',10,"0",STR_PAD_LEFT);        
                    $RowClaveConsepto=str_pad('01',2);//pendiente
                    $RowPartida=str_pad('00',5,"0",STR_PAD_LEFT);//pendiente                 
                    $cadena=$RowIdTrans.$RowFolio.$RowRfc.$RowCuenta.$RowCurp.$RowRazonSocial.$RowTipoPagoD.$RowTipoDeclaracion.$RowAnoDeclarado.$RowMesDeclarado.$RowNoComple.$RowFolioAnterior.$RowDeclaracionAnterior.$RowEmpleados.$RowRenumeracion.$RowClaveConsepto.$RowImporteDecl.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaBanco.$RowTipoPago.$RowTotalTramite.$RowPartida.$RowImporte.$RowTipoEstabl.$RowTipoContrib.$RowAlr.$RowAutosEnajenUnidades.$RowCamionesEnajenUnidades.$RowAutosExeUnidades.$RowVehiculosExtUnidades.$RowAutosEnajenValor.$RowCamionesEnajenValor.$RowAutosExtValor.$RowVehiculosExtValor.$RowTotalUnidades.$RowTotalValor.$RowVehiculosIncorp.$RowFacturasExpInicial.$RowFacturasExpFinal.$RowValorTotEnajena.$RowFuente.$RowClaveImpuesto;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                //fwrite($Archivo,$dataAnsi."\r\n");
                File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }
      
        //fclose($Archivo); 
        //$this->enviacorreo($txt);
    }
    private function gArchivo_ISOP()
    {
        $nombreArchivo=Carbon::now();
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_ISOP'.'.txt';
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt));
        $cadena='';        
        ///***tramites array***/////
        $Servicios= array('1');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,9,"0",STR_PAD_LEFT);
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('Hms'),6);
                $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Y-m-d'),10);
                $RowHoraDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('H:m:s'),8);
                $RowTipoPago=str_pad($trans->TipoPago,2,"0",STR_PAD_LEFT);

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('00000000',8);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad(Carbon::parse($con->archivo)->format('Ymd'),8);  
                    }
                }
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {                     
                       $RowFolio=str_pad('',11,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad('',13,"0",STR_PAD_LEFT);
                    }else{
                    foreach ($folio as $fol) {                       
                       $RowFolio=str_pad($fol->Folio,11,"0",STR_PAD_LEFT);
                       $RowRfc=str_pad($fol->CartKey1,13);
                    }
                }
                $isop=$this->detalleisopdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($isop->count()==0)
                    {
                            $RowCuentaEstatal=str_pad('',11);             
                            $RowCurp=str_pad('CURP423452',18);        
                            $RowNombreRazonS=str_pad('NR',120);
                            $RowMesDeclarado=str_pad('02',2,"0",STR_PAD_LEFT);
                            $RowAnoDeclarado=str_pad('2019',4);
                            $RowTipoDeclaracion=str_pad('1',1);
                            $RowPremio=str_pad('',13,"0",STR_PAD_LEFT);
                            $RowImpuesto=str_pad('',13,"0",STR_PAD_LEFT);
                            $RowActualizacion=str_pad('',13,"0",STR_PAD_LEFT);
                            $RowRecargos=str_pad('',13,"0",STR_PAD_LEFT);
                            $RowTotalContr=str_pad('',13,"0",STR_PAD_LEFT);

                    }else{
                        foreach ($isop as $iso) {
                           
                            $RowCuentaEstatal=str_pad($iso->cuenta,11,"0",STR_PAD_LEFT);   
                            $RowCurp=str_pad($iso->curp,18);        
                            $RowNombreRazonS=str_pad($iso->nombre_razonS,120);
                            $RowMesDeclarado=str_pad($iso->mes,2,"0",STR_PAD_LEFT);
                            $RowAnoDeclarado=str_pad($iso->anio,4);
                            $RowTipoDeclaracion=str_pad(' ',13,"0",STR_PAD_LEFT);//pendiente $iso->
                            $RowPremio=str_pad($iso->premio,13,"0",STR_PAD_LEFT);
                            $RowImpuesto=str_pad($iso->impuesto,13,"0",STR_PAD_LEFT);
                            $RowActualizacion=str_pad($iso->actualizacion,13,"0",STR_PAD_LEFT);
                            $RowRecargos=str_pad($iso->recargos,13,"0",STR_PAD_LEFT);
                            $RowTotalContr=str_pad($iso->total_contribuciones,13,"0",STR_PAD_LEFT);
                        }

                    }
                         
                $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCuentaEstatal.$RowCurp.$RowNombreRazonS.$RowTipoPago.$RowMesDeclarado.$RowAnoDeclarado.$RowTipoDeclaracion.$RowPremio.$RowImpuesto.$RowActualizacion.$RowRecargos.$RowTotalContr.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                //fwrite($Archivo,$dataAnsi."\r\n");
                File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }
      
        //$this->enviacorreo($txt);
    }

    private function gArchivo_Prestadora_Servicios()
    {

        
        $nombreArchivo=Carbon::now(); 
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_Prestadora_de_Servicios'.'.txt';
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt));
        $cadena='';        
        ///***tramites array***/////
        $Servicios= array('1');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
               
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('Hms'),6);
                $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Y-m-d'),10);
                $RowHoraDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('H:m:s'),8);      
                $RowTotalTramite=str_pad($trans->TotalTramite,9,"0",STR_PAD_LEFT);
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('',8);
                        $RowBanco=str_pad('',4,"0",STR_PAD_LEFT);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,8);
                        $RowBanco=str_pad($con->Banco,4,"0",STR_PAD_LEFT); 
                    }
                }                
                $detalleisn=$this->detalleisnprestadoradb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleisn->count()==0)
                    {                            
                        $RowIdTrans=str_pad('',20,"0",STR_PAD_LEFT);
                            $RowFolio=str_pad('',20,"0",STR_PAD_LEFT);        
                            $RowRfcAlfa=str_pad('',4,"0",STR_PAD_LEFT);  
                            $RowRfcCnum=str_pad('',6,"0",STR_PAD_LEFT);  
                            $RowRfcChom=str_pad('',3,"0",STR_PAD_LEFT);  
                            $RowCuenta=str_pad('',11,"0",STR_PAD_LEFT);        
                            $RowNombreRazonS=str_pad('',150);
                            $RowTipoDeclaracion=str_pad('1',1);
                            $RowValorFijo=str_pad('1',1);
                            $RowAno=str_pad('',4);
                            $RowMes=str_pad('',2,"0",STR_PAD_LEFT);       
                            $RowFolioAnterior=str_pad('',20,"0",STR_PAD_LEFT);
                            $RowNumComplem=str_pad('',2,"0",STR_PAD_LEFT);
                            $RowImptAnterior=str_pad('',11,"0",STR_PAD_LEFT);
                            $RowEmpleados=str_pad('',6,"0",STR_PAD_LEFT);
                            $RowRenumeracion=str_pad('',13,"0",STR_PAD_LEFT);
                            $RowClave=str_pad('C',2,"0",STR_PAD_LEFT);
                            $RowImporteC=str_pad('I',9,"0",STR_PAD_LEFT);                
                            $RowPartida=str_pad('P',5,"0",STR_PAD_LEFT);
                            $RowImporte=str_pad('I',9,"0",STR_PAD_LEFT);
                    }else{
                        foreach ($detalleisn as $isn) {
                           $RowIdTrans=str_pad($isn->idtrans,20,"0",STR_PAD_LEFT);
                            $RowFolio=str_pad($isn->Folio,20,"0",STR_PAD_LEFT);     
                            $RowRfcAlfa=str_pad($isn->rfcalfa,4,"0",STR_PAD_LEFT);  
                            $RowRfcCnum=str_pad($isn->rfcnum,6,"0",STR_PAD_LEFT);  
                            $RowRfcChom=str_pad($isn->rfchom,3,"0",STR_PAD_LEFT);  
                            $RowCuenta=str_pad($isn->cuenta,11,"0",STR_PAD_LEFT);
                            $RowNombreRazonS=str_pad($isn->nombre_razonS,150);
                            $RowTipoDeclaracion=str_pad($isn->tipo_declaracion,1);
                            $RowValorFijo=str_pad('1',1);
                            $RowAno=str_pad($isn->anio,4);
                            $RowMes=str_pad($isn->mes,2,"0",STR_PAD_LEFT);       
                            $RowFolioAnterior=str_pad($isn->folio_anterior,20,"0",STR_PAD_LEFT);
                            $RowNumComplem=str_pad($isn->num_complementaria,2,"0",STR_PAD_LEFT);
                            $RowImptAnterior=str_pad($isn->declaracion_anterior,11,"0",STR_PAD_LEFT);
                            $RowEmpleados=str_pad($isn->no_empleados,6,"0",STR_PAD_LEFT);
                            $RowRenumeracion=str_pad($isn->remuneraciones,13,"0",STR_PAD_LEFT);
                            $RowClave=str_pad('',2,"0",STR_PAD_LEFT);//pendiente
                            $RowImporteC=str_pad('',9,"0",STR_PAD_LEFT);//pendiente
                            $RowPartida=str_pad('',5,"0",STR_PAD_LEFT);//pendiente
                            $RowImporte=str_pad('',9,"0",STR_PAD_LEFT);//pendiente                            
                        }

                    }
                    
                         
                $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuenta.$RowNombreRazonS.$RowTipoDeclaracion.$RowValorFijo.$RowAno.$RowMes.$RowFolioAnterior.$RowNumComplem.$RowImptAnterior.$RowEmpleados.$RowRenumeracion.$RowClave.$RowImporteC.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite.$RowPartida.$RowImporte;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }
      
        //$this->enviacorreo($txt);
    }
    private function gArchivo_Retenedora_Servicios()
    {
        $nombreArchivo=Carbon::now(); 
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_Retenedora_de_Servicios'.'.txt';
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        
        ///***tramites array***/////
        $Servicios= array('1');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
               
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('Hms'),6);
                $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Y-m-d'),10);
                $RowHoraDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('H:m:s'),8);                
                $RowTotalTramite=str_pad($trans->TotalTramite,11,"0",STR_PAD_LEFT);
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('',8);
                        $RowBanco=str_pad('',4,"0",STR_PAD_LEFT);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,8);
                        $RowBanco=str_pad($con->Banco,4,"0",STR_PAD_LEFT); 
                    }
                }                
                $detalleisnr=$this->detalleisnretenedordb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleisnr->count()==0)
                    {
                        $RowIdTrans=str_pad('',20,"0",STR_PAD_LEFT);
                        $RowFolio=str_pad('',20,"0",STR_PAD_LEFT);        
                        $RowRfcAlfa=str_pad('',4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad('',6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad('',3,"0",STR_PAD_LEFT);  
                        $RowCuentaRet=str_pad('',11,"0",STR_PAD_LEFT);    
                        $RowTipoDeclaracion=str_pad('',1,"0",STR_PAD_LEFT);
                        $RowAno=str_pad('',4);
                        $RowMes=str_pad('',2,"0",STR_PAD_LEFT);  
                        $RowNumComplem=str_pad('',2,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad('',20,"0",STR_PAD_LEFT);
                        $RowImptDeclaracion=str_pad('',11,"0",STR_PAD_LEFT);
                       

                    }else{
                        foreach ($detalleisnr as $isn) {
                        $RowIdTrans=str_pad($isn->idtrans,20,"0",STR_PAD_LEFT);
                        $RowFolio=str_pad($isn->Folio,20,"0",STR_PAD_LEFT);        
                        $RowRfcAlfa=str_pad($isn->rfcalfa,4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad($isn->rfcnum,6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad($isn->rfchom,3,"0",STR_PAD_LEFT);  
                        $RowCuentaRet=str_pad($isn->cuenta,11,"0",STR_PAD_LEFT);    
                        $RowTipoDeclaracion=str_pad($isn->tipo_declaracion,1,"0",STR_PAD_LEFT);
                        $RowAno=str_pad($isn->anio,4);
                        $RowMes=str_pad($isn->mes,2,"0",STR_PAD_LEFT);  
                        $RowNumComplem=str_pad($isn->num_complementaria,2,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad($isn->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowImptDeclaracion=str_pad($isn->declaracion_anterior,11,"0",STR_PAD_LEFT);
                                               
                        }

                    }
            $detalleretenciones=$this->detalleretencionesdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleretenciones->count()==0)
                    {
                        
                        $RowNombreRet=str_pad('',150);
                        $RowRfcPrest=str_pad('',13,"0",STR_PAD_LEFT);
                        $RowCuentaPrest=str_pad('',11,"0",STR_PAD_LEFT);
                        $RowNombrePrest=str_pad('',150);
                        $RowEmpleados=str_pad('',6,"0",STR_PAD_LEFT);
                        $RowRenumeracion=str_pad('',13,"0",STR_PAD_LEFT);
                        $RowPartidaRet=str_pad('',5,"0",STR_PAD_LEFT);
                        $RowRetencion=str_pad('',11,"0",STR_PAD_LEFT);
                        $RowPartidaActu=str_pad('',5,"0",STR_PAD_LEFT);
                        $RowActualizaciones=str_pad('',11,"0",STR_PAD_LEFT);
                        $RowPartidaRecargo=str_pad('',5,"0",STR_PAD_LEFT);
                        $RowRecargos=str_pad('',11,"0",STR_PAD_LEFT);   
                    }else{
                        foreach ($detalleretenciones as $retenciones) {
                        $RowNombreRet=str_pad($retenciones->nombre_retenedora,150);
                        $RowRfcPrest=str_pad($retenciones->rfc_prestadora,13,"0",STR_PAD_LEFT);
                        $RowCuentaPrest=str_pad($retenciones->cuenta,11,"0",STR_PAD_LEFT);
                        $RowNombrePrest=str_pad($retenciones->nombre_prestadora,150);
                        $RowEmpleados=str_pad($retenciones->no_empleados,6,"0",STR_PAD_LEFT);///pendiente
                        $RowRenumeracion=str_pad($retenciones->remuneraciones,13,"0",STR_PAD_LEFT);  //pendiente 
                        $RowPartidaRet=str_pad('12510',5);
                        $RowRetencion=str_pad($retenciones->retencion,11,"0",STR_PAD_LEFT);
                        $RowPartidaActu=str_pad('40215',5);
                        $RowActualizaciones=str_pad('0.00',11,"0",STR_PAD_LEFT);
                        $RowPartidaRecargo=str_pad('12514',5);
                        $RowRecargos=str_pad('0.00',11,"0",STR_PAD_LEFT);                       
                        }

                    }
                    
               
         
                $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuentaRet.$RowNombreRet.$RowRfcPrest.$RowCuentaPrest.$RowNombrePrest.$RowTipoDeclaracion.$RowAno.$RowMes.$RowNumComplem.$RowFolioAnterior.$RowImptDeclaracion.$RowEmpleados.$RowRenumeracion.$RowPartidaRet.$RowRetencion.$RowPartidaActu.$RowActualizaciones.$RowPartidaRecargo.$RowRecargos.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
               File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }
      
        //$this->enviacorreo($txt);
    }
    private function gArchivo_Juegos_Apuestas()
    {

        
        $nombreArchivo=Carbon::now();
        $txt=$nombreArchivo->format('Y_m_d').'_Corte_Juegos_Apuestas'.'.txt';
        $response = array();        
       File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        
        ///***tramites array***/////
        $Servicios= array('1');
        $fechaIn=$nombreArchivo->format('Y-m-d').' 00:00:00';     
        $fechaFin=$nombreArchivo->format('Y-m-d').' 23:59:59';
        $conciliacion=$this->pr->findWhere(['status'=>'p',['created_at','>','2019-09-11 00:00:00'],['created_at','<','2019-09-11 23:59:59']]);         
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,20);
               
                $RowFechaTramite=str_pad(Carbon::parse(Str::limit($trans->fechatramite,10,''))->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse(Str::limit($trans->HoraTramite,10,''))->format('Hms'),6);
                $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('Y-m-d'),10);
                $RowHoraDispersion=str_pad(Carbon::parse(Str::limit($trans->Clabe_FechaDisp, 10,''))->format('H:m:s'),8);                
                $RowTotalTramite=str_pad($trans->TotalTramite,11,"0",STR_PAD_LEFT);
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('',8);                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,8);                        
                    }
                } 
                $folio=$this->foliosdb->findwhere([]);
                if($folio->count()==0){
                     $RowFolio=str_pad('',20,"0",STR_PAD_LEFT);
                     $RowDescrip=str_pad('',150);
                }
                else{
                    foreach ($folio as $fol) {
                        $RowFolio=str_pad($fol->Folio,20,"0",STR_PAD_LEFT);        
                        $RowDescrip=str_pad($fol->CartDescripcion,150);
                    }
                }               
                $det=$this->detimpisopdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($det->count()==0)
                    {      
                       
                       $RowRfcAlfa=str_pad('',4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad('',6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad('',3,"0",STR_PAD_LEFT);  
                        $RowClaveMun=str_pad('',3,"0",STR_PAD_LEFT);        
                        $RowCuenta=str_pad('',11,"0",STR_PAD_LEFT);                       
                        $RowCurp=str_pad('',18,"0",STR_PAD_LEFT);
                        $RowClave=str_pad('',4);        
                        $RowMes=str_pad('',2,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad('',20,"0",STR_PAD_LEFT);
                        $RowImporteAnterior=str_pad('',11,"0",STR_PAD_LEFT);
                        $RowPartida=str_pad('',5,"0",STR_PAD_LEFT);
                        $RowImporte=str_pad('',11,"0",STR_PAD_LEFT);
                        $RowTotal=str_pad('',11,"0",STR_PAD_LEFT);

                    }else{
                        foreach ($det as $isop) {                                
                       $RowRfcAlfa=str_pad($isop->rfcalf,4,"0",STR_PAD_LEFT);  
                        $RowRfcCnum=str_pad($isop->rfcnum,6,"0",STR_PAD_LEFT);  
                        $RowRfcChom=str_pad($isop->rfchom,3,"0",STR_PAD_LEFT);  
                        $RowClaveMun=str_pad($isop->cve_mpo,3,"0",STR_PAD_LEFT);        
                        $RowCuenta=str_pad($isop->cuenta,11,"0",STR_PAD_LEFT);
                        $RowCurp=str_pad($isop->curp);
                        $RowClave=str_pad($isop->cve_imp,4); ///pendiente       
                        $RowMes=str_pad($isop->mes,2,"0",STR_PAD_LEFT);
                        $RowFolioAnterior=str_pad($isop->folio_anterior,20,"0",STR_PAD_LEFT);
                        $RowImporteAnterior=str_pad($isop->imp_anterior,11,"0",STR_PAD_LEFT); 
                        $RowPartida=str_pad($isop->imp_anterior,5,"0",STR_PAD_LEFT);//pendiente
                        $RowImporte=str_pad($isop->imp_anterior,11,"0",STR_PAD_LEFT);//pendiente
                        $RowTotal=str_pad($isop->imp_anterior,11,"0",STR_PAD_LEFT);//pendiente
                                               
                        }

                    }
        
                $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowClaveMun.$RowCuenta.$RowDescrip.$RowCurp.$RowClave.$RowMes.$RowFolioAnterior.$RowImporteAnterior.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowTotalTramite.$RowPartida.$RowImporte.$RowTotal;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
                }            
            }
        }
        //$this->enviacorreo($txt);
    }
    private function insrtfolio()
    {

        $banco;
        $referen=556312312321;
        $process=$this->pr->findwhere(['status'=>'p']);  
        foreach ($process as $proc) {
          $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$proc->transaccion_id]);
          foreach ($transacciones as $key) {
            $referen=$referen+3214;
                $concilia=$this->conciliaciondb->findwhere(['idtrans'=>$key->idTrans]);
                foreach ($concilia as $con) {
                    $banco=$con->Banco;
                }
                $inserta=$this->referenciabancariadb->create(['idTrans'=>$key->idTrans,'Linea'=>$referen,'FechaLimite'=>'2019-08-28 00:00:00','BancoPago'=>$banco,'FechaCanc'=>'2019-09-02 00:00:00']);
          }
      }
    }
    private function enviacorreo()
    {   
         $nombreArchivo=Carbon::now(); 
        $txt_impuesto=$nombreArchivo->format('Y_m_d').'_Corte_Impuesto_Control_Vehicular'.'.txt';
        $txt_juegAp=$nombreArchivo->format('Y_m_d').'_Corte_Juegos_Apuestas'.'.txt';
        $txt_RetServ=$nombreArchivo->format('Y_m_d').'_Corte_Retenedora_de_Servicios'.'.txt';
        $txt_PrestServ=$nombreArchivo->format('Y_m_d').'_Corte_Prestadora_de_Servicios'.'.txt';
        $txt_isop=$nombreArchivo->format('Y_m_d').'_Corte_ISOP'.'.txt';
        $txt_isan=$nombreArchivo->format('Y_m_d').'_Corte_ISAN_ISH'.'.txt';
        $txt_nomina=$nombreArchivo->format('Y_m_d').'_Corte_Nomina'.'.txt';            
        $arrayAch=array($txt_impuesto, $txt_juegAp,$txt_RetServ,$txt_PrestServ,$txt_isop,$txt_isan,$txt_nomina);
        $subject ='Fecha de Corte '.$nombreArchivo->format('Y_m_d');
        $data = [ 'link' => 'https' ];
        $for = "juancarlos96.15.02@gmail.com";
        Mail::send('email',$data, function($msj) use($subject,$for,$arrayAch){
            $msj->from("juan.carlos.cruz.bautista@hotmail.com","Juan Carlos CB");
            $msj->subject($subject);
            $msj->to($for);
            foreach ($arrayAch as $key) {
               $msj->attach(storage_path('app/txt/'.$key));
            }
            
        });

    }
}
