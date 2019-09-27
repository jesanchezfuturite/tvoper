<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use File;
use Mail;
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

class CorteController extends Controller
{
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
        ContdetimpisopRepositoryEloquent $detimpisopdb

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
        $this->detalleisandb=$detalleisandb;
        $this->detalleishdb=$detalleishdb;
        $this->detalleisopdb=$detalleisopdb;
        $this->detalleisnprestadoradb=$detalleisnprestadoradb;
        $this->detalleisnretenedordb=$detalleisnretenedordb;
        $this->detalleretencionesdb=$detalleretencionesdb;
        $this->detimpisopdb=$detimpisopdb;

    }
    public function generaarchivo()
    {
        //$this->insrtfolio();
        //$this->gArchivo_Impuesto_Controlv(); ///
        //$this->gArchivo_Tenencia();
        //$this->gArchivo_Licencias();
        //$this->gArchivo_Nomina();     ////
        //$this->gArchivo_Carta_no_Inhabilita();
        $this->gArchivo_ISAN_ISH();  /////
        //$this->gArchivo_ISOP(); ////
        //$this->gArchivo_Prestadora_Servicios(); ////
        //$this->gArchivo_Retenedora_Servicios(); ////
        //$this->gArchivo_Juegos_Apuestas();   ////
    }
    
    private function gArchivo_Impuesto_Controlv()
    {

        
        $nombreArchivo=Carbon::now();
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Impuesto_ControlVeicular'.'.txt';
        File::delete(storage_path('app/txt/'.$txt));
        $response = array();
        $cadena='';
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
        $cadena=$RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
        $Servicios= array('30','1');
                
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {          
            //log::info($S);
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowClaveltramite=str_pad($trans->TipoServicio,15);
                $RowFechapago=str_pad($trans->fechatramite,12);
                $RowHorapago=str_pad($trans->HoraTramite,12);
                $tramite=$this->tramitedb->findwhere(['id_transaccion_motor'=>$trans->idTrans]);
                if($tramite->count()==0)
                {
                    $RowPartida=str_pad('P',9);
                    $RowConsepto=str_pad('C',120);  
                }else{  foreach ($tramite as $tram) {
                    $tamite_detalle=$this->tramite_detalledb->findwhere(['id_tramite_motor'=>$trans->id_tramite_motor]);
                        foreach ($tamite_detalle as $tram_detalle) {
                            $RowPartida=str_pad($tram_detalle->partida,9);
                            $RowConsepto=str_pad($tram_detalle->consepto,120);
                        }
                    }
                }                
                $folios=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folios->count()==0)
                    {
                        $RowTotalpago=str_pad('T',15);
                        $RowFolio=str_pad('F',22);
                    }else{
                    foreach ($folios as $fol) {
                         $RowFolio=str_pad($fol->Folio,22);
                         $RowTotalpago=str_pad($fol->CartImporte,15);
                    }
                }
                $referenciabancaria=$this->referenciabancariadb->findwhere(['idTrans'=>$trans->idTrans]);
                if($referenciabancaria->count()==0)
                {
                    $RowReferencia=str_pad('R',32);
                }else{
                    foreach ($referenciabancaria as $refbancaria) {
                    $RowReferencia=str_pad($refbancaria->Linea,32);
                    }
                }
            $RowOrigen=str_pad('0',8);//pendiente   $concilia->origen
            $RowMedio_pago=str_pad('1',12);//pendiente
            $RowFechaDis=str_pad('01/08/2019',12);//pendiente
            $RowHoraDis=str_pad('14:02:01',11);//pendiente
            $RowCuentaPago=str_pad('01215402407',14);//pendiente

            $cadena=$RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago;
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
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Nomina'.'.txt';
        $response = array();        
       File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
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
        $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
        
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
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
                $RowFuente=str_pad($trans->fuente,8);         
                $RowTipoPagoT=str_pad($trans->TipoPago,11);     
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
                $nomina=$this->nominadb->findwhere(['idTran'=>$trans->idTrans]);
                if($nomina->count()==0)
                    {  
                        $RowFolio=str_pad('F',13);
                        $RowMunnom=str_pad('M',8);
                        $RowClaveNombre=str_pad('CN',14);
                        $RowRfcAlfa=str_pad('RA',10);
                        $RowRfcNumero=str_pad('RN',12);
                        $RowRfcHomoclave=str_pad('RH',15);         
                        $RowTipoPagoN=str_pad('TP',11);         
                        $RowMesDec=str_pad('MD',8);
                        $RowTriDec=str_pad('TD',8);        
                        $RowAnoDec=str_pad('AD',8);         
                        $RowNumemp=str_pad('N',8);         
                        $RowRenumeracion=str_pad('R',14);        
                        $RowBase=str_pad('B',13);         
                        $RowActualiza=str_pad('A',11);         
                        $RowRecargos=str_pad('R',10);         
                        $RowGastosEjecucion=str_pad('GE',21);     
                        $RowSancion=str_pad('S',9);
                        $RowCompensacion=str_pad('C',23);
                       
                    }else{
                    foreach ($nomina as $nom) {
                         
                        $RowFolio=str_pad($nom->folio,13);
                        $RowMunnom=str_pad($nom->munnom,8);
                        $RowClaveNombre=str_pad($nom->cvenom,14);
                        $RowRfcAlfa=str_pad($nom->rfcalf,10);
                        $RowRfcNumero=str_pad($nom->rfcnum,12);
                        $RowRfcHomoclave=str_pad($nom->rfchomo,15);         
                        $RowTipoPagoN=str_pad($nom->tipopago,11);         
                        $RowMesDec=str_pad($nom->mesdec,8);
                        $RowTriDec=str_pad($nom->mesdec,8);        
                        $RowAnoDec=str_pad($nom->anodec,8);         
                        $RowNumemp=str_pad($nom->numemp,8);         
                        $RowRenumeracion=str_pad($nom->remuneracion,14);        
                        $RowBase=str_pad($nom->base,13);         
                        $RowActualiza=str_pad($nom->actualiza,11);         
                        $RowRecargos=str_pad($nom->recargos,10);         
                        $RowGastosEjecucion=str_pad($nom->gtoeje,21);     
                        $RowSancion=str_pad($nom->sancion,9);
                        $RowCompensacion=str_pad($nom->compensacion,23);
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
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_ISAN_ISH'.'.txt';
        File::delete(storage_path('app/txt/'.$txt));
        $response = array(); 
        $cadena='';
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',22);
        $RowFolio=str_pad('FOLIO',22);
        $RowRfc=str_pad('RFC',15);
        $RowCuenta=str_pad('CUENTA',13);
        $RowCurp=str_pad('CURP',20);
        $RowRazonSocial=str_pad('NOMBRE O RAZON SOCIAL',152);
        $RowTipoPagoD=str_pad('TIPO PAGO',11);
        $RowTipoDeclaracion=str_pad('TIPO DECLARACION',18);
        $RowAnoDeclarado=str_pad('AÑO DECLARADO',15);
        $RowMesDeclarado=str_pad('MES DECLARADO',15);
        $RowNoComple=str_pad('NO. COMPLEMENTARIA',20);
        $RowFolioAnterior=str_pad('FOLIO ANTERIOR',22);
        $RowDeclaracionAnterior=str_pad('DECLARACION ANTERIOR',22);
        $RowEmpleados=str_pad('EMPLEADOS',12);
        $RowRenumeracion=str_pad('RENUMERACION',17);
        $RowClaveConsepto=str_pad('CLAVE CONSEPTO',16);
        $RowImporteDecl=str_pad('IMPORTE DECLARACION',21);        
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);
        $RowFechaBanco=str_pad('FECHA BANCO',13); 
        $RowTipoPago=str_pad('TIPO PAGO',11);
        $RowTotalTramite=str_pad('TOTAL TRAMITE',15);
        $RowPartida=str_pad('PARTIDA',8);
        $RowImporte=str_pad('IMPORTE',13);          
        $RowTipoEstabl=str_pad('TIPO ESTABLECIMIENTO',22);          
        $RowTipoContrib=str_pad('TIPO CONTRIBUYENTE',19);          
        $RowAlr=str_pad('ALR',6);          
        $RowAutosEnajenUnidades=str_pad('AUTOS ENAJENADOS UNIDADES',27);          
        $RowCamionesEnajenUnidades=str_pad('CAMIONES ENAJENADOS UNIDADES',30);        
        $RowAutosExeUnidades=str_pad('AUTOS EXENTOS UNIDADES',24);          
        $RowVehiculosExtUnidades=str_pad('VEHICULOS EXTERNOS UNIDADES',29);         
        $RowAutosEnajenValor=str_pad('AUTOS ENAJENADOS VALOR',24);  
        $RowCamionesEnajenValor=str_pad('CAMIONES ENAJENADOS VALOR',27);          
        $RowAutosExtValor=str_pad('AUTOS EXTERNOS VALOR',22);          
        $RowVehiculosExtValor=str_pad('VEHICULOS EXTERNOS VALOR',26);          
        $RowTotalUnidades=str_pad('TOTAL UNIDADES',16);          
        $RowTotalValor=str_pad('TOTAL VALOR',17);          
        $RowVehiculosIncorp=str_pad('VEHICULOS INCORPORADOS',24);   
        $RowFacturasExpInicial=str_pad('FACTURAS EXPENDIDAS INICIAL',29);         
        $RowFacturasExpFinal=str_pad('FACTURAS EXPENDIDAS FINAL',27);      
        $RowValorTotEnajena=str_pad('VALOR TOTAL ENAJENACION',25);
        $RowFuente=str_pad('FUENTE',8);          
        $RowClaveImpuesto=str_pad('CLAVE IMPUESTO',16);          
        $cadena=$RowIdTrans.$RowFolio.$RowRfc.$RowCuenta.$RowCurp.$RowRazonSocial.$RowTipoPagoD.$RowTipoDeclaracion.$RowAnoDeclarado.$RowMesDeclarado.$RowNoComple.$RowFolioAnterior.$RowDeclaracionAnterior.$RowEmpleados.$RowRenumeracion.$RowClaveConsepto.$RowImporteDecl.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaBanco.$RowTipoPago.$RowTotalTramite.$RowPartida.$RowImporte.$RowTipoEstabl.$RowTipoContrib.$RowAlr.$RowAutosEnajenUnidades.$RowCamionesEnajenUnidades.$RowAutosExeUnidades.$RowVehiculosExtUnidades.$RowAutosEnajenValor.$RowCamionesEnajenValor.$RowAutosExtValor.$RowVehiculosExtValor.$RowTotalUnidades.$RowTotalValor.$RowVehiculosIncorp.$RowFacturasExpInicial.$RowFacturasExpFinal.$RowValorTotEnajena.$RowFuente.$RowClaveImpuesto;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);        
       File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
        ///***tramites array***/////
        $Servicios= array('1');
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,22);
                $RowFechaTramite=str_pad($trans->fechatramite,15);
                $RowHoraTramite=str_pad($trans->HoraTramite,14);
                $RowFechaDispersion=str_pad($trans->Clabe_FechaDisp,18);         
                $RowHoraDispersion=str_pad($trans->Clabe_FechaDisp,17);
                $RowTipoPago=str_pad($trans->TipoPago,11);
                $RowTotalTramite=str_pad($trans->TotalTramite,15);

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaBanco=str_pad('F B',13);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaBanco=str_pad($con->archivo,13);  
                    }
                }
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {                     
                       $RowFolio=str_pad('C',22);
                       $RowRfc=str_pad('R',15);
                    }else{
                    foreach ($folio as $fol) {                       
                       $RowFolio=str_pad($fol->Folio,22);
                       $RowRfc=str_pad($fol->CartKey1,15);
                    }
                }
                $isan=$this->detalleisandb->findwhere(['idTrans'=>$trans->idTrans]); 
                if($isan->count()==0)
                {
                    $ish=$this->detalleishdb->findwhere(['idTrans'=>$trans->idTrans]);
                    if($ish->count()==0){
                        $RowCuenta=str_pad('12012',13);
                        $RowCurp=str_pad('LJIU02101',20);
                        $RowRazonSocial=str_pad('Razon Social ISAN/ISH',152);
                        $RowTipoDeclaracion=str_pad('1',18);
                        $RowAnoDeclarado=str_pad('0',15);
                        $RowMesDeclarado=str_pad('0',15);
                        $RowNoComple=str_pad('210',20);
                        $RowFolioAnterior=str_pad('14250',22);
                        $RowDeclaracionAnterior=str_pad('0',22);
                        $RowRenumeracion=str_pad('001',17);
                        $RowImporteDecl=str_pad('0',21);   //pendiente    
                        $RowImporte=str_pad('0',13);   ///pendiente       
                        $RowTipoEstabl=str_pad('1',22);          
                        $RowTipoContrib=str_pad('1',19);          
                        $RowAlr=str_pad('1',6);          
                        $RowAutosEnajenUnidades=str_pad('000000000000',27);          
                        $RowCamionesEnajenUnidades=str_pad('000000000000',30);        
                        $RowAutosExeUnidades=str_pad('000000000000',24);          
                        $RowVehiculosExtUnidades=str_pad('000000000000',29);         
                        $RowAutosEnajenValor=str_pad('000000000000',24);  
                        $RowCamionesEnajenValor=str_pad('000000000000',27);          
                        $RowAutosExtValor=str_pad('000000000000',22);          
                        $RowVehiculosExtValor=str_pad('000000000000',26);          
                        $RowTotalUnidades=str_pad('000000000000',16);          
                        $RowTotalValor=str_pad('000000000000',17);          
                        $RowVehiculosIncorp=str_pad('000000000000',24);   
                        $RowFacturasExpInicial=str_pad('000000000000',29);         
                        $RowFacturasExpFinal=str_pad('000000000000',27);      
                        $RowValorTotEnajena=str_pad('000000000000',25);
                        $RowFuente=str_pad('0015',8);          
                        $RowClaveImpuesto=str_pad('0010',16);
                    }else{
                    foreach ($ish as $is ) {
                        $RowCuenta=str_pad($is->cuenta,13);
                        $RowCurp=str_pad($is->cuenta,20);
                        $RowRazonSocial=str_pad($is->nombre_razonS,152);
                        $RowTipoDeclaracion=str_pad($is->tipo_declaracion,18);
                        $RowAnoDeclarado=str_pad($is->anio,15);
                        $RowMesDeclarado=str_pad($is->mes,15);
                        $RowNoComple=str_pad($is->num_complementaria,20);
                        $RowFolioAnterior=str_pad($is->folio_anterior,22);
                        $RowDeclaracionAnterior=str_pad($is->declaracion_anterior,22);
                        $RowRenumeracion=str_pad($is->erogaciones,17);
                        $RowImporteDecl=str_pad($is->tipo_declaracion,21);   //pendiente    
                        $RowImporte=str_pad($is->dif_imp,13);   ///pendiente       
                        $RowTipoEstabl=str_pad(' ',22);          
                        $RowTipoContrib=str_pad(' ',19);          
                        $RowAlr=str_pad(' ',6);          
                        $RowAutosEnajenUnidades=str_pad('000000000000',27);          
                        $RowCamionesEnajenUnidades=str_pad('000000000000',30);        
                        $RowAutosExeUnidades=str_pad('000000000000',24);          
                        $RowVehiculosExtUnidades=str_pad('000000000000',29);         
                        $RowAutosEnajenValor=str_pad('000000000000',24);  
                        $RowCamionesEnajenValor=str_pad('000000000000',27);          
                        $RowAutosExtValor=str_pad('000000000000',22);          
                        $RowVehiculosExtValor=str_pad('000000000000',26);          
                        $RowTotalUnidades=str_pad('000000000000',16);          
                        $RowTotalValor=str_pad('000000000000',17);          
                        $RowVehiculosIncorp=str_pad('000000000000',24);   
                        $RowFacturasExpInicial=str_pad('000000000000',29);         
                        $RowFacturasExpFinal=str_pad('000000000000',27);      
                        $RowValorTotEnajena=str_pad('000000000000',25);
                        $RowFuente=str_pad('0015',8);          
                        $RowClaveImpuesto=str_pad('0010',16);
                        }
                    }

                }else{
                    foreach ($isan as $i) {
                        $RowCuenta=str_pad($i->cuenta,13);
                        $RowCurp=str_pad($i->curp,20);///pendiente
                        $RowRazonSocial=str_pad($i->nombre_razonS,152);
                        $RowTipoDeclaracion=str_pad($i->tipo_declaracion,18);
                        $RowAnoDeclarado=str_pad($i->anio_1,15);//pendiente
                        $RowMesDeclarado=str_pad($i->mes_1,15);  //pendiente
                        $RowNoComple=str_pad($i->num_complementaria,20);
                        $RowFolioAnterior=str_pad($i->folio_anterior,22);
                        $RowDeclaracionAnterior=str_pad($i->declaracion_anterior,22);
                        $RowRenumeracion=str_pad('000000000000000',17);
                        $RowImporteDecl=str_pad($i->tipo_declaracion,21);      ///pendiente 
                        $RowImporte=str_pad($i->monto,13); //pendiente         
                        $RowTipoEstabl=str_pad($i->tipo_establecimiento,22);          
                        $RowTipoContrib=str_pad($i->tipo_contribuyente,19);          
                        $RowAlr=str_pad($i->ALR,6);          
                        $RowAutosEnajenUnidades=str_pad($i->autos_enajenados_unidades,27);          
                        $RowCamionesEnajenUnidades=str_pad($i->camiones_enajenados_unidades,30);       
                        $RowAutosExeUnidades=str_pad($i->autos_exentos_unidades,24);          
                        $RowVehiculosExtUnidades=str_pad($i->vehiculos_exentos_unidades,29);         
                        $RowAutosEnajenValor=str_pad($i->autos_enajenados_valor,24);  
                        $RowCamionesEnajenValor=str_pad($i->camiones_enajenados_valor,27);          
                        $RowAutosExtValor=str_pad($i->autos_exentos_valor,22);          
                        $RowVehiculosExtValor=str_pad($i->vehiculos_exentos_valor,26);          
                        $RowTotalUnidades=str_pad($i->total_unidades,16);          
                        $RowTotalValor=str_pad($i->total_valor,17);          
                        $RowVehiculosIncorp=str_pad($i->vehiculos_incorporados,24);   
                        $RowFacturasExpInicial=str_pad($i->facturas_expedidas_inicial,29);         
                        $RowFacturasExpFinal=str_pad($i->facturas_expedidas_final,27);      
                        $RowValorTotEnajena=str_pad($i->valor_total_enajenacion,25);
                        $RowFuente=str_pad('0015',8);          
                        $RowClaveImpuesto=str_pad('0010',16); ///pendiente
                    }
                }  
        
                    $RowTipoPagoD=str_pad('00',11);        
                    $RowEmpleados=str_pad('0000000000',12);        
                    $RowClaveConsepto=str_pad('01',16);//pendiente
                    $RowPartida=str_pad('00',8);//pendiente                 
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
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_ISOP'.'.txt';
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',22);
        $RowFolio=str_pad('FOLIO',22); 
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);
        $RowRfc=str_pad('RFC',15);  
        $RowCuentaEstatal=str_pad('CUENTA ESTATAL',16);             
        $RowCurp=str_pad('CURP',20);        
        $RowNombreRazonS=str_pad('NOMBRE O RAZÓN SOCIAL',122);
        $RowTipoPago=str_pad('TIPO PAGO',11);
        $RowMesDeclarado=str_pad('MES DECLARADO',15);
        $RowAnoDeclarado=str_pad('AÑO DECLARADO',15);
        $RowTipoDeclaracion=str_pad('TIPO DECLARADO',16);
        $RowPremio=str_pad('PREMIO',15);
        $RowImpuesto=str_pad('IMPUESTO',15);
        $RowActualizacion=str_pad('ACTUALIZACION',15);
        $RowRecargos=str_pad('RECARGOS',15);
        $RowTotalContr=str_pad('TOTAL CONTRIBUCIONES',22);
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);
        $RowFechaCorte=str_pad('FECHA CORTE',13);         
                 
        $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCuentaEstatal.$RowCurp.$RowNombreRazonS.$RowTipoPago.$RowMesDeclarado.$RowAnoDeclarado.$RowTipoDeclaracion.$RowPremio.$RowImpuesto.$RowActualizacion.$RowRecargos.$RowTotalContr.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);        
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
        ///***tramites array***/////
        $Servicios= array('1');
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,22);
                $RowFechaTramite=str_pad($trans->fechatramite,15);
                $RowHoraTramite=str_pad($trans->HoraTramite,14);
                $RowFechaDispersion=str_pad($trans->Clabe_FechaDisp,18);         
                $RowHoraDispersion=str_pad($trans->Clabe_FechaDisp,17);
                $RowTipoPago=str_pad($trans->TipoPago,11);

                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('F B',13);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,13);  
                    }
                }
                $folio=$this->foliosdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($folio->count()==0)
                    {                     
                       $RowFolio=str_pad('C',22);
                       $RowRfc=str_pad('R',15);
                    }else{
                    foreach ($folio as $fol) {                       
                       $RowFolio=str_pad($fol->Folio,22);
                       $RowRfc=str_pad($fol->CartKey1,15);
                    }
                }
                $isop=$this->detalleisopdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($isop->count()==0)
                    {
                            $RowCuentaEstatal=str_pad('C',16);             
                            $RowCurp=str_pad('C',20);        
                            $RowNombreRazonS=str_pad('NR',122);
                            $RowMesDeclarado=str_pad('MD',15);
                            $RowAnoDeclarado=str_pad('AD',15);
                            $RowTipoDeclaracion=str_pad('TD',16);
                            $RowPremio=str_pad('P',15);
                            $RowImpuesto=str_pad('I',15);
                            $RowActualizacion=str_pad('A',15);
                            $RowRecargos=str_pad('R',15);
                            $RowTotalContr=str_pad('TC',22);

                    }else{
                        foreach ($isop as $iso) {
                           
                            $RowCuentaEstatal=str_pad($iso->cuenta,16);   
                            $RowCurp=str_pad($iso->curp,20);        
                            $RowNombreRazonS=str_pad($iso->nombre_razonS,23);
                            $RowMesDeclarado=str_pad($iso->mes,15);
                            $RowAnoDeclarado=str_pad($iso->anio,15);
                            $RowTipoDeclaracion=str_pad(' ',16);//pendiente $iso->
                            $RowPremio=str_pad($iso->premio,15);
                            $RowImpuesto=str_pad($iso->impuesto,15);
                            $RowActualizacion=str_pad($iso->actualizacion,15);
                            $RowRecargos=str_pad($iso->recargos,15);
                            $RowTotalContr=str_pad($iso->total_contribuciones,22);
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
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Prestadora_de_Servicios'.'.txt';
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',22);
        $RowFolio=str_pad('FOLIO',22);        
        $RowRfcAlfa=str_pad('RFCalfa',9);  
        $RowRfcCnum=str_pad('RFCnum',8);  
        $RowRfcChom=str_pad('RFChom',8);  
        $RowCuenta=str_pad('CUENTA',13);        
        $RowNombreRazonS=str_pad('NOMBRE O RAZÓN SOCIAL',152);
        $RowTipoDeclaracion=str_pad('TIPO DECLARACION(N,C,F)',25);
        $RowValorFijo=str_pad('Valor Fijo',12);
        $RowAno=str_pad('AÑO',5);
        $RowMes=str_pad('MES',5);       
        $RowFolioAnterior=str_pad('FOLIO ANTERIOR',22);
        $RowNumComplem=str_pad('NUMERO COMPLEMENTARIA',23);
        $RowImptAnterior=str_pad('IMPORTE DECLARACION ANTERIOR',30);
        $RowEmpleados=str_pad('EMPLEADOS',11);
        $RowRenumeracion=str_pad('RENUMERACIONES',16);
        $RowClave=str_pad('CLAVE',7);
        $RowImporteC=str_pad('IMPORTE',11);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);        
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);
        $RowFechaCorte=str_pad('FECHA CORTE',13);
        $RowBanco=str_pad('BANCO',7);
        $RowTotalTramite=str_pad('TOTAL TRAMITE',15);
        $RowPartida=str_pad('PARTIDA',9);
        $RowImporte=str_pad('IMPORTE',11);

                 
        $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuenta.$RowNombreRazonS.$RowTipoDeclaracion.$RowValorFijo.$RowAno.$RowMes.$RowFolioAnterior.$RowNumComplem.$RowImptAnterior.$RowEmpleados.$RowRenumeracion.$RowClave.$RowImporteC.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite.$RowPartida.$RowImporte;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);        
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
        ///***tramites array***/////
        $Servicios= array('1');
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
               
                $RowFechaTramite=str_pad($trans->fechatramite,15);
                $RowHoraTramite=str_pad($trans->HoraTramite,14);
                $RowFechaDispersion=str_pad($trans->Clabe_FechaDisp,18);         
                $RowHoraDispersion=str_pad($trans->Clabe_FechaDisp,17);                
                $RowTotalTramite=str_pad($trans->TotalTramite,15);
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('F B',13);
                        $RowBanco=str_pad('B',7);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,13);
                        $RowBanco=str_pad($con->Banco,7); 
                    }
                }                
                $detalleisn=$this->detalleisnprestadoradb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleisn->count()==0)
                    {
                            
                        $RowIdTrans=str_pad('ID',22);
                            $RowFolio=str_pad('F',22);        
                            $RowRfcAlfa=str_pad('RA',9);  
                            $RowRfcCnum=str_pad('RC',8);  
                            $RowRfcChom=str_pad('RFC',8);  
                            $RowCuenta=str_pad('C',13);        
                            $RowNombreRazonS=str_pad('N    S',152);
                            $RowTipoDeclaracion=str_pad('TD',24);
                            $RowValorFijo=str_pad('1',12);
                            $RowAno=str_pad('A',5);
                            $RowMes=str_pad('M',5);       
                            $RowFolioAnterior=str_pad('FA',22);
                            $RowNumComplem=str_pad('NC',23);
                            $RowImptAnterior=str_pad('IDA',30);
                            $RowEmpleados=str_pad('E',11);
                            $RowRenumeracion=str_pad('R',16);
                            $RowClave=str_pad('C',7);
                            $RowImporteC=str_pad('I',11);                
                            $RowPartida=str_pad('P',9);
                            $RowImporte=str_pad('I',11);
                    }else{
                        foreach ($detalleisn as $isn) {
                           $RowIdTrans=str_pad($isn->idtrans,22);
                            $RowFolio=str_pad($isn->Folio,22);     
                            $RowRfcAlfa=str_pad($isn->rfcalfa,9);  
                            $RowRfcCnum=str_pad($isn->rfcnum,8);  
                            $RowRfcChom=str_pad($isn->rfchom,8);  
                            $RowCuenta=str_pad($isn->cuenta,13);
                            $RowNombreRazonS=str_pad($isn->nombre_razonS,152);
                            $RowTipoDeclaracion=str_pad($isn->tipo_declaracion,25);
                            $RowValorFijo=str_pad('1',12);
                            $RowAno=str_pad($isn->anio,5);
                            $RowMes=str_pad($isn->mes,5);       
                            $RowFolioAnterior=str_pad($isn->folio_anterior,22);
                            $RowNumComplem=str_pad($isn->num_complementaria,23);
                            $RowImptAnterior=str_pad($isn->declaracion_anterior,30);
                            $RowEmpleados=str_pad($isn->no_empleados,11);
                            $RowRenumeracion=str_pad($isn->remuneraciones,16);
                            $RowClave=str_pad('',7);//pendiente
                            $RowImporteC=str_pad('',11);//pendiente
                            $RowPartida=str_pad('',9);//pendiente
                            $RowImporte=str_pad('',11);//pendiente                            
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
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Retenedora_de_Servicios'.'.txt';
        $response = array();        
        File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',22);
        $RowFolio=str_pad('FOLIO',22);        
        $RowRfcAlfa=str_pad('RFCalfa',9);  
        $RowRfcCnum=str_pad('RFCnum',8);  
        $RowRfcChom=str_pad('RFChom',8);  
        $RowCuentaRet=str_pad('CUENTA RETENEDORA',19);        
        $RowNombreRet=str_pad('NOMBRE RETENEDORA',152);
        $RowRfcPrest=str_pad('RFC PRESTADORA',16);
        $RowCuentaPrest=str_pad('CUENTA PRESTADORA',19);
        $RowNombrePrest=str_pad('NOMBRE PRESTADORA',152);
        $RowTipoDeclaracion=str_pad('TIPO DECLARACION(N,C,F)',25);
        $RowAno=str_pad('AÑO',5);
        $RowMes=str_pad('MES',5);
        $RowNumComplem=str_pad('NUMERO COMPLEMENTARIA',23);
        $RowFolioAnterior=str_pad('FOLIO ANTERIOR',22);
        $RowImptDeclaracion=str_pad('IMPORTE DECLARACION ANTERIOR',30);
        $RowEmpleados=str_pad('EMPLEADOS',11);
        $RowRenumeracion=str_pad('RENUMERACIONES',16);
        $RowPartidaRet=str_pad('PARTIDA RETENCION',19);
        $RowRetencion=str_pad('RETENCION',11);
        $RowPartidaActu=str_pad('PARTIDAS ACTUALIZACIONES',26);
        $RowActualizaciones=str_pad('ACTUALIZACIONES',17);
        $RowPartidaRecargo=str_pad('PARTIDAS RECARGO',18);
        $RowRecargos=str_pad('RECARGOS',13);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);        
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);
        $RowFechaCorte=str_pad('FECHA CORTE',13);
        $RowBanco=str_pad('BANCO',7);
        $RowTotalTramite=str_pad('TOTAL TRAMITE',15);

                 
        $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuentaRet.$RowNombreRet.$RowRfcPrest.$RowCuentaPrest.$RowNombrePrest.$RowTipoDeclaracion.$RowAno.$RowMes.$RowNumComplem.$RowFolioAnterior.$RowImptDeclaracion.$RowEmpleados.$RowRenumeracion.$RowPartidaRet.$RowRetencion.$RowPartidaActu.$RowActualizaciones.$RowPartidaRecargo.$RowRecargos.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);        
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
        ///***tramites array***/////
        $Servicios= array('1');
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
               
                $RowFechaTramite=str_pad($trans->fechatramite,15);
                $RowHoraTramite=str_pad($trans->HoraTramite,14);
                $RowFechaDispersion=str_pad($trans->Clabe_FechaDisp,18);         
                $RowHoraDispersion=str_pad($trans->Clabe_FechaDisp,17);                
                $RowTotalTramite=str_pad($trans->TotalTramite,15);
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('F B',13);
                        $RowBanco=str_pad('B',7);
                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,13);
                        $RowBanco=str_pad($con->Banco,7); 
                    }
                }                
                $detalleisnr=$this->detalleisnretenedordb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleisnr->count()==0)
                    {
                        $RowIdTrans=str_pad('IDT',22);
                        $RowFolio=str_pad('F',22);        
                        $RowRfcAlfa=str_pad('RFCalfa',9);  
                        $RowRfcCnum=str_pad('RFCnum',8);  
                        $RowRfcChom=str_pad('RFChom',8);  
                        $RowCuentaRet=str_pad('CUENTA',19);    
                        $RowTipoDeclaracion=str_pad('TIPO D',25);
                        $RowAno=str_pad('A',5);
                        $RowMes=str_pad('M',5);  
                        $RowNumComplem=str_pad('NUMERO C',23);
                        $RowFolioAnterior=str_pad('FOLIO A',22);
                        $RowImptDeclaracion=str_pad('IMPORTE D',30);
                       

                    }else{
                        foreach ($detalleisnr as $isn) {
                        $RowIdTrans=str_pad($isn->idtrans,22);
                        $RowFolio=str_pad($isn->Folio,22);        
                        $RowRfcAlfa=str_pad($isn->rfcalfa,9);  
                        $RowRfcCnum=str_pad($isn->rfcnum,8);  
                        $RowRfcChom=str_pad($isn->rfchom,8);  
                        $RowCuentaRet=str_pad($isn->cuenta,19);    
                        $RowTipoDeclaracion=str_pad($isn->tipo_declaracion,25);
                        $RowAno=str_pad($isn->anio,5);
                        $RowMes=str_pad($isn->mes,5);  
                        $RowNumComplem=str_pad($isn->num_complementaria,23);
                        $RowFolioAnterior=str_pad($isn->folio_anterior,22);
                        $RowImptDeclaracion=str_pad($isn->declaracion_anterior,30);
                                               
                        }

                    }
            $detalleretenciones=$this->detalleretencionesdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($detalleretenciones->count()==0)
                    {
                        
                        $RowNombreRet=str_pad('NOMBRE R',152);
                        $RowRfcPrest=str_pad('RFC P',16);
                        $RowCuentaPrest=str_pad('CUENTA P',19);
                        $RowNombrePrest=str_pad('NOMBRE P',152);
                        $RowEmpleados=str_pad('EMP',11);
                        $RowRenumeracion=str_pad('RENUM',16);
                        $RowPartidaRet=str_pad('12510',19);
                        $RowRetencion=str_pad('RET',11);
                        $RowPartidaActu=str_pad('40215',26);
                        $RowActualizaciones=str_pad('0.00',17);
                        $RowPartidaRecargo=str_pad('12514',18);
                        $RowRecargos=str_pad('0.00',13);   
                    }else{
                        foreach ($detalleretenciones as $retenciones) {
                        $RowNombreRet=str_pad($retenciones->nombre_retenedora,152);
                        $RowRfcPrest=str_pad($retenciones->rfc_prestadora,16);
                        $RowCuentaPrest=str_pad($retenciones->cuenta,19);
                        $RowNombrePrest=str_pad($retenciones->nombre_prestadora,152);
                        $RowEmpleados=str_pad($retenciones->no_empleados,11);///pendiente
                        $RowRenumeracion=str_pad($retenciones->remuneraciones,16);  //pendiente 
                        $RowPartidaRet=str_pad('12510',19);
                        $RowRetencion=str_pad($retenciones->retencion,11);
                        $RowPartidaActu=str_pad('40215',26);
                        $RowActualizaciones=str_pad('0.00',17);
                        $RowPartidaRecargo=str_pad('12514',18);
                        $RowRecargos=str_pad('0.00',13);                       
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
        $nombreArchivo=$nombreArchivo->format('Y_m_d'); 
        $txt=$nombreArchivo.'_Corte_Juegos_Apuestas'.'.txt';
        $response = array();        
       File::delete(storage_path('app/txt/'.$txt));
        $cadena='';
        /****** campos  ******/
        $RowIdTrans=str_pad('IDTRANS',22);
        $RowFolio=str_pad('FOLIO',22);        
        $RowRfcAlfa=str_pad('RFCalfa',9);  
        $RowRfcCnum=str_pad('RFCnum',8);  
        $RowRfcChom=str_pad('RFChom',8);  
        $RowClaveMun=str_pad('CLAVE MUNICIPIO',17);        
        $RowCuenta=str_pad('CUENTA',13);        
        $RowDescrip=str_pad('DESCRIPCION',152);
        $RowCurp=str_pad('CURP',20);
        $RowClave=str_pad('CLAVE',7);        
        $RowMes=str_pad('MES',5);
        $RowFolioAnterior=str_pad('FOLIO ANTERIOR',22);
        $RowImporteAnterior=str_pad('IMPORTE ANTERIOR',18);
        $RowFechaTramite=str_pad('FECHA TRAMITE',15);
        $RowHoraTramite=str_pad('HORA TRAMITE',14);        
        $RowFechaDispersion=str_pad('FECHA DISPERSION',18);         
        $RowHoraDispersion=str_pad('HORA DISPERSION',17);
        $RowFechaCorte=str_pad('FECHA CORTE',13);
        $RowTotalTramite=str_pad('TOTAL TRAMITE',15);
        $RowPartida=str_pad('PARTIDA',9);
        $RowImporte=str_pad('IMPORTE',13);
        $RowTotal=str_pad('TOTAL',13);
        

                 
        $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowClaveMun.$RowCuenta.$RowDescrip.$RowCurp.$RowClave.$RowMes.$RowFolioAnterior.$RowImporteAnterior.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowTotalTramite.$RowPartida.$RowImporte.$RowTotal;
        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);        
        File::append(storage_path('app/txt/'.$txt),$dataAnsi."\r\n");
        ///***tramites array***/////
        $Servicios= array('1');
        $conciliacion=$this->pr->findwhere(['status'=>'p']);        
        foreach ($Servicios as $S) { 
            foreach ($conciliacion as $concilia) {
        $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id,'TipoServicio'=>$S]);
            foreach ($transacciones as $trans) {
                $RowIdTrans=str_pad($trans->idTrans,22);
               
                $RowFechaTramite=str_pad($trans->fechatramite,15);
                $RowHoraTramite=str_pad($trans->HoraTramite,14);
                $RowFechaDispersion=str_pad($trans->Clabe_FechaDisp,18);         
                $RowHoraDispersion=str_pad($trans->Clabe_FechaDisp,17);                
                $RowTotalTramite=str_pad($trans->TotalTramite,15);
                $conc=$this->conciliaciondb->findwhere(['idTrans'=>$trans->idTrans]);
                if($conc->count()==0)
                    {
                        $RowFechaCorte=str_pad('F B',13);                       
                    }else{
                    foreach ($conc as $con) {
                        $RowFechaCorte=str_pad($con->archivo,13);                        
                    }
                } 
                $folio=$this->foliosdb->findwhere([]);
                if($folio->count()==0){
                     $RowFolio=str_pad('F',22);
                     $RowDescrip=str_pad('DESCRIPCION',152);
                }
                else{
                    foreach ($folio as $fol) {
                        $RowFolio=str_pad($fol->Folio,22);        
                        $RowDescrip=str_pad($fol->CartDescripcion,152);
                    }
                }               
                $det=$this->detimpisopdb->findwhere(['idTrans'=>$trans->idTrans]);
                if($det->count()==0)
                    {      
                       
                       $RowRfcAlfa=str_pad('RFCa',9);  
                        $RowRfcCnum=str_pad('RFCn',8);  
                        $RowRfcChom=str_pad('RFCh',8);  
                        $RowClaveMun=str_pad('CLAVE M',17);        
                        $RowCuenta=str_pad('C',13);                       
                        $RowCurp=str_pad('CURP',20);
                        $RowClave=str_pad('CLA',7);        
                        $RowMes=str_pad('MES',5);
                        $RowFolioAnterior=str_pad('FOLIO A',22);
                        $RowImporteAnterior=str_pad('IMPORTE A',18);
                        $RowPartida=str_pad('PART',9);
                        $RowImporte=str_pad('IMP',13);
                        $RowTotal=str_pad('TO',13);

                    }else{
                        foreach ($det as $isop) {                                
                       $RowRfcAlfa=str_pad($isop->rfcalf,9);  
                        $RowRfcCnum=str_pad($isop->rfcnum,8);  
                        $RowRfcChom=str_pad($isop->rfchom,8);  
                        $RowClaveMun=str_pad($isop->cve_mpo,17);        
                        $RowCuenta=str_pad($isop->cuenta,13);
                        $RowCurp=str_pad($isop->curp,20);
                        $RowClave=str_pad($isop->cve_imp,7); ///pendiente       
                        $RowMes=str_pad($isop->mes,5);
                        $RowFolioAnterior=str_pad($isop->folio_anterior,22);
                        $RowImporteAnterior=str_pad($isop->imp_anterior,18); 
                        $RowPartida=str_pad($isop->imp_anterior,9);//pendiente
                        $RowImporte=str_pad($isop->imp_anterior,13);//pendiente
                        $RowTotal=str_pad($isop->imp_anterior,13);//pendiente
                                               
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
        $conciliacion=$this->pr->findwhere(['status'=>'p']);  
        foreach ($conciliacion as $concilia) {
          $transacciones=$this->transaccionesdb->findwhere(['idTrans'=>$concilia->transaccion_id]);
          foreach ($transacciones as $key) {
            $clave=str_random(12);
            $clave1=str_random(12);
            $clave2=str_random(12);
            $clave3=str_random(12);
              $insertD=$this->foliosdb->create(['idTrans'=>$key->idTrans,'CartKey1'=>$clave1,'CartKey2'=>$clave2,'CartKey3'=>$clave3,'CartCantidad'=>$concilia->monto,'CartImporte'=>$concilia->monto,'CartDescripcion'=>$clave,'CartTipo'=>'1','idgestor'=>'01']);
          }
      }
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
