<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
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
use App\Repositories\CortesolicitudRepositoryEloquent;

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
    protected $partidasdb;
    protected $cortearchivosdb;
    protected $cortesolicituddb;

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
        CorteArchivosRepositoryEloquent $cortearchivosdb,
        CortesolicitudRepositoryEloquent $cortesolicituddb

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
        $this->partidasdb=$partidasdb;
        $this->cortearchivosdb=$cortearchivosdb;
        $this->cortesolicituddb=$cortesolicituddb;

    }
   
    public function GeneraArchivo()
    {
        
        $banco_id='3';
        $fecha='2019-10-18';
        $cuenta='';
        $alias=''; 
        /*$banco_id=$request->banco_id;
        $fecha=$request->fecha;
        $cuenta=$request->cuenta;
        $alias=$request->alias;*/ 

        if($fecha==''){
            $fecha=Carbon::now();
        }else
        {
           $fecha= Carbon::parse($fecha);
        }
        $buscaFecha=(string)$fecha->format('Y-m-d');
        if (!File::exists(storage_path('app/Cortes')))
        { File::makeDirectory(storage_path('app/Cortes'));}       
        $path1=storage_path('app/Cortes/'.$fecha->format('Y'));
        $path2=$path1.'/'.$fecha->format('m');
        $path3=$path2.'/'.$fecha->format('d');        
        $path4=$path3.'/'.$banco_id;      
        if (!File::exists($path1))
                {File::makeDirectory($path1);}
        if (!File::exists($path2))
                {File::makeDirectory($path2);}
        if (!File::exists($path3))
                {File::makeDirectory($path3);}
        if (!File::exists($path4))
                {File::makeDirectory($path4);}
        //$Archivos=File::allFiles($path4);
        if($cuenta=="" && $alias=="")
        {
            $findBancos=$this->cuentasbancodb->findWhere(['banco_id'=>$banco_id]);
            foreach ($findBancos as $k) {
                foreach (json_decode($k->beneficiario) as $e) {
                    $alias=(string)$e->alias;
                    $cuenta=(string)$e->cuenta;                    
                }
                $this->gArchivos($path4,$buscaFecha,$banco_id,$cuenta,$alias);
            }
       }else{
            $this->gArchivos($path4,$buscaFecha,$banco_id,$cuenta,$alias);  
        }
        //$this->enviacorreo();
    }
    private function gArchivos($path,$fecha,$banco_id,$cuenta,$alias)
    {        
        
        $this->gArchivo_Generico($path,$fecha,$banco_id,$cuenta,$alias);        
        $this->gArchivo_Nomina($path,$fecha,$banco_id,$cuenta,$alias);            
        $this->gArchivo_ISAN($path,$fecha,$banco_id,$cuenta,$alias); 
        $this->gArchivo_ISH($path,$fecha,$banco_id,$cuenta,$alias); 
        $this->gArchivo_ISOP($path,$fecha,$banco_id,$cuenta,$alias); 
        $this->gArchivo_Prestadora_Servicios($path,$fecha,$banco_id,$cuenta,$alias); 
        $this->gArchivo_Retenedora_Servicios($path,$fecha,$banco_id,$cuenta,$alias); 
        $this->gArchivo_Juegos_Apuestas($path,$fecha,$banco_id,$cuenta,$alias);          
    } 
    private function gArchivo_Generico($path,$fecha,$banco_id,$cuenta,$alias)
    {        

        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_Generico'.'.txt';
        $Directorio=$path."/".$nombreArchivo;
        $cadena='';
        $Servicios= array(1,30,20,21,27,28,29,156,157,158,160);       
            for ($i=100; $i < 151; $i++) { 
               array_push($Servicios ,$i );
            }
        $existe=false;
        $conciliacion=$this->pr->Generico_Corte($fecha,$banco_id,$cuenta,$alias);
        if($conciliacion<>null){     
        foreach ($conciliacion as $concilia) {          
            $existe=false;                            
            foreach ($Servicios as $serv){
                if($serv==$concilia->tipo_servicio){
                        $existe=true;}
                }
                  
                if($existe)
                {
                    $RowClaveltramite=str_pad($concilia->tipo_servicio,6,"0",STR_PAD_LEFT);
                   $k=json_decode($concilia->info_transacciones);                    
                       $RowFechapago=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHorapago=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDis=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDis=str_replace("Por Operacion", "",$k->fecha_disp);
                        if(strlen($RowFechaDis)==13)
                        {
                        $RowFechaDis=str_pad(Carbon::parse(Str::limit($RowFechaDis,10,''))->format('Y-m-d'),10);
                        $RowHoraDis=str_pad(substr($RowHoraDis,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDis==null)
                            {
                            $RowFechaDis=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDis=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDis=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDis=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        } 
                    
                    $RowFechapago=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                    $RowHorapago=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                    $RowPartida=str_pad($concilia->id_partida,5,"0",STR_PAD_LEFT);
                    $RowConsepto=str_pad(mb_convert_encoding($concilia->descripcion, "Windows-1252", "UTF-8"),120);
                    $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);
                    $RowTotalpago=str_pad(str_replace(".","",$concilia->CartImporte) ,13,"0",STR_PAD_LEFT);
                    $RowReferencia=str_pad($concilia->Linea,30,"0",STR_PAD_LEFT);                           
                    $RowOrigen=str_pad("027",3,"0",STR_PAD_LEFT);  
                    $RowMedio_pago=str_pad('001',3,"0",STR_PAD_LEFT); // pendiente                                               
                    $RowDatoAdicional1=str_pad('',30,"0",STR_PAD_LEFT);//pendiente
                    $RowDatoAdicional2=str_pad('',15,"0",STR_PAD_LEFT);//pendiente
                    $RowCuentaPago=str_pad($concilia->cuenta_banco,30,"0",STR_PAD_LEFT);
                    $RowAlias=str_pad($concilia->cuenta_alias,6,"0",STR_PAD_LEFT); 
                    $cadena=$RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowDatoAdicional1.$RowDatoAdicional2.$RowCuentaPago.$RowAlias;
                       // $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                    File::append($Directorio,$cadena."\r\n");
                    $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);
                    
                }
            }
        }
    }
    private function gArchivo_Nomina($path,$fecha,$banco_id,$cuenta,$alias)
    {
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_Nomina'.'.txt';
        $Directorio=$path."/".$nombreArchivo;       
        $cadena='';
        $tipoServicio='3';
        $conciliacion=$this->pr->Nomina_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias);
        if($conciliacion<>null)
        {   
            foreach ($conciliacion as $concilia) {          
            $RowFechaCorte=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Ymd'),8);
                $RowIdTrans=str_pad($concilia->transaccion_id,9,"0",STR_PAD_LEFT);       
                $RowFuente=str_pad(substr($concilia->fuente, 4),4);         
                $RowTipoPagoT=str_pad($concilia->TipoPago,4,"0",STR_PAD_LEFT);     
                $k=json_decode($concilia->info_transacciones);                    
                       $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                        if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        } 
                                          
                $RowFolio=str_pad($concilia->folio,11,"0",STR_PAD_LEFT);
                $RowMunnom=str_pad($concilia->munnom,2,"0",STR_PAD_LEFT);
                $RowClaveNombre=str_pad($concilia->cvenom,7,"0",STR_PAD_LEFT);
                $RowRfcAlfa=str_pad(Str::limit($concilia->rfcalf, 4,''),4," ",STR_PAD_LEFT);
                $RowRfcNumero=str_pad(Str::limit($concilia->rfcnum, 6,''),6,"0",STR_PAD_LEFT);
                $RowRfcHomoclave=str_pad(Str::limit($concilia->rfchomo, 3,''),3," ",STR_PAD_LEFT);         
                $RowTipoPagoN=str_pad($concilia->tipopago,1,"0",STR_PAD_LEFT);         
                $RowMesDec=str_pad($concilia->mesdec,2,"0",STR_PAD_LEFT);
                $RowTriDec=str_pad($concilia->tridec,1,"0",STR_PAD_LEFT);        
                $RowAnoDec=str_pad($concilia->anodec,4,"0",STR_PAD_LEFT);         
                $RowNumemp=str_pad($concilia->numemp,6,"0",STR_PAD_LEFT);         
                $RowRenumeracion=str_pad(str_replace(".", "", $concilia->remuneracion),15,"0",STR_PAD_LEFT);        
                $RowBase=str_pad(str_replace(".", "",$concilia->base ),15,"0",STR_PAD_LEFT);         
                $RowActualiza=str_pad(str_replace(".", "",$concilia->actualiza ),11,"0",STR_PAD_LEFT);         
                $RowRecargos=str_pad(str_replace(".", "", $concilia->recargos),9,"0",STR_PAD_LEFT);         
                $RowGastosEjecucion=str_pad(str_replace(".", "", $concilia->gtoeje),9,"0",STR_PAD_LEFT);     
                $RowSancion=str_pad(str_replace(".", "",$concilia->sancion ),9,"0",STR_PAD_LEFT);
                $RowCompensacion=str_pad(str_replace(".", "", $concilia->compensacion),15,"0",STR_PAD_LEFT);         
                $RowValorFijo="0";

                $cadena=$RowIdTrans.$RowFolio.$RowValorFijo.$RowFechaTramite.$RowHoraTramite.$RowMunnom.$RowClaveNombre.$RowRfcAlfa.$RowRfcNumero.$RowRfcHomoclave.$RowTipoPagoN.$RowMesDec.$RowTriDec.$RowAnoDec.$RowNumemp.$RowRenumeracion.$RowBase.$RowActualiza.$RowRecargos.$RowGastosEjecucion.$RowSancion.$RowFuente.$RowTipoPagoT.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowCompensacion;
                $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252',$cadena);
                File::append($Directorio,$dataAnsi."\r\n");
                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);              
            } 
        }             
    }
    private function gArchivo_ISAN($path,$fecha,$banco_id,$cuenta,$alias)
    {
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_ISH_ISAN'.'.txt';
        $Directorio=$path."/".$nombreArchivo;       
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
        $tipoServicio= '13';
        $conciliacion=$this->pr->ISAN_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias);         
        if($conciliacion<>null)
        {       
            foreach ($conciliacion as $concilia) {
                $RowFechaBanco=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Ymd'),8);       
                $RowIdTrans=str_pad($concilia->transaccion_id,20,"0",STR_PAD_LEFT);
                $k=json_decode($concilia->info_transacciones);                    
                       $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                        if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        }                 
                $RowTipoPago=str_pad($concilia->TipoPago,4,"0",STR_PAD_LEFT);
                $RowTotalTramite=str_pad(str_replace(".", "",$concilia->TotalTramite),11,"0",STR_PAD_LEFT);             
                $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);
                $RowRfc=str_pad($concilia->CartKey1,13," ",STR_PAD_LEFT);
                $RowCuenta=str_pad($concilia->cuenta,11,"0",STR_PAD_LEFT);
                $RowCurp=str_pad($concilia->curp,18," ",STR_PAD_LEFT);
                $RowRazonSocial=str_pad(mb_convert_encoding($concilia->nombre_razonS, "Windows-1252", "UTF-8"),150);
                $RowTipoDeclaracion=str_pad(Str::limit($concilia->tipo_declaracion,1,''),1);
                $RowPeriodicidad=str_pad(Str::limit($concilia->tipo_tramite,1,''),1);
                $RowAnoDeclarado=str_pad($concilia->anio_1,4);
                $RowMesDeclarado=str_pad($concilia->mes_1,2,"0",STR_PAD_LEFT);
                $RowNoComple=str_pad($concilia->num_complementaria,1);
                $RowFolioAnterior=str_pad($concilia->folio_anterior,20,"0",STR_PAD_LEFT);
                $RowDeclaracionAnterior=str_pad((int)$concilia->declaracion_anterior,13,"0",STR_PAD_LEFT);
                $RowRenumeracion=str_pad('',15,"0",STR_PAD_LEFT);     
                $RowTipoEstabl=str_pad($concilia->tipo_establecimiento,20,"0",STR_PAD_LEFT);          
                $RowTipoContrib=str_pad($concilia->tipo_contribuyente,20,"0",STR_PAD_LEFT);          
                $RowAlr=str_pad($concilia->ALR,4,"0",STR_PAD_LEFT);          
                $RowAutosEnajenUnidades=str_pad((int)$concilia->autos_enajenados_unidades,12,"0",STR_PAD_LEFT);          
                $RowCamionesEnajenUnidades=str_pad((int)$concilia->camiones_enajenados_unidades,12,"0",STR_PAD_LEFT);   
                $RowAutosExeUnidades=str_pad((int)$concilia->autos_exentos_unidades,12,"0",STR_PAD_LEFT);          
                $RowVehiculosExtUnidades=str_pad((int)$concilia->vehiculos_exentos_unidades,12,"0",STR_PAD_LEFT);        
                $RowAutosEnajenValor=str_pad((int)$concilia->autos_enajenados_valor,15,"0",STR_PAD_LEFT);  
                $RowCamionesEnajenValor=str_pad((int)$concilia->camiones_enajenados_valor,15,"0",STR_PAD_LEFT);          
                $RowAutosExtValor=str_pad((int)$concilia->autos_exentos_valor,15,"0",STR_PAD_LEFT);          
                $RowVehiculosExtValor=str_pad((int)$concilia->vehiculos_exentos_valor,15,"0",STR_PAD_LEFT);          
                $RowTotalUnidades=str_pad((int)$concilia->total_unidades,12,"0",STR_PAD_LEFT);          
                $RowTotalValor=str_pad((int)$concilia->total_valor,15,"0",STR_PAD_LEFT);          
                $RowVehiculosIncorp=str_pad((int)$concilia->vehiculos_incorporados,12,"0",STR_PAD_LEFT);   
                $RowFacturasExpInicial=str_pad((int)$concilia->facturas_expedidas_inicial,12,"0",STR_PAD_LEFT);         
                $RowFacturasExpFinal=str_pad((int)$concilia->facturas_expedidas_final,12,"0",STR_PAD_LEFT);
                $RowVehiculosenajenados=str_pad($concilia->vehiculos_enajenados_periodo,12,"0",STR_PAD_LEFT);    
                $RowValorTotEnajena=str_pad((int)$concilia->valor_total_enajenacion,15,"0",STR_PAD_LEFT);
                $RowFuente=str_pad('0015',4);          
                $RowClaveImpuesto=str_pad('5001',4);                       
                $declaracion=$concilia->tipo_declaracion;
                $impuesto=$concilia->impuesto;
                $actualizacion=$concilia->actualizacion;
                $recargos=$concilia->recargos;
                $dif_imp=$concilia->dif_impuesto;
                $dif_act=$concilia->dif_actualizacion;
                $dif_rec=$concilia->dif_recargos;                                         
                $RowTipoPagoD=str_pad('00',2,"0",STR_PAD_LEFT);      
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
                        File::append($Directorio,$cadena."\r\n");
                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);           

                }            
            }
        }      
    }
    private function gArchivo_ISH($path,$fecha,$banco_id,$cuenta,$alias)
    {
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_ISH_ISAN'.'.txt';
        $Directorio=$path."/".$nombreArchivo;       
        //File::delete($Directorio);
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
        $tipoServicio= '14';
        $conciliacion=$this->pr->ISH_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias); 
        if($conciliacion<>null)
        {
        foreach ($conciliacion as $concilia) {
            $RowFechaBanco=str_pad(Carbon::parse($concilia->created_at)->format('Ymd'),8);
            $RowIdTrans=str_pad($concilia->transaccion_id,20,"0",STR_PAD_LEFT);
            $k=json_decode($concilia->info_transacciones);        
                $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                    if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                        }
                    } 
                               
        $RowTipoPago=str_pad($concilia->TipoPago,4,"0",STR_PAD_LEFT);
        $RowTotalTramite=str_pad(str_replace(".", "",$concilia->TotalTramite),11,"0",STR_PAD_LEFT);       
        $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);
        $RowRfc=str_pad($concilia->CartKey1,13," ",STR_PAD_LEFT);
        $RowCuenta=str_pad($concilia->cuenta,11,"0",STR_PAD_LEFT);
        $RowCurp=str_pad($concilia->curp,18," ",STR_PAD_LEFT);
        $RowRazonSocial=str_pad(mb_convert_encoding($concilia->nombre_razonS, "Windows-1252", "UTF-8"),150);
        $RowTipoDeclaracion=str_pad(Str::limit($concilia->tipo_declaracion,1,''),1);
        $RowPeriodicidad=str_pad('M',1);                         
        $RowAnoDeclarado=str_pad($concilia->anio,4,"0",STR_PAD_LEFT);
        $RowMesDeclarado=str_pad($concilia->mes,2,"0",STR_PAD_LEFT);
        $RowNoComple=str_pad($concilia->num_complementaria,1,"0",STR_PAD_LEFT);
        $RowFolioAnterior=str_pad($concilia->folio_anterior,20,"0",STR_PAD_LEFT);
        $RowDeclaracionAnterior=str_pad((int)$concilia->declaracion_anterior,13,"0",STR_PAD_LEFT);
        $RowRenumeracion=str_pad((int)$concilia->erogaciones,15,"0",STR_PAD_LEFT);
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
        $declaracion=$concilia->tipo_declaracion;
        $impuesto=$concilia->impuesto;
        $actualizacion=$concilia->actualizacion;
        $recargos=$concilia->recargos;
        $dif_imp=$concilia->dif_imp;
        $dif_act=$concilia->dif_act;
        $dif_rec=$concilia->dif_rec;
        $RowTipoPagoD=str_pad('00',2,"0",STR_PAD_LEFT);      
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
                        File::append($Directorio,$cadena."\r\n");
                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);           
                        
                }
            }           
        }      
    }
    private function gArchivo_ISOP($path,$fecha,$banco_id,$cuenta,$alias)
    {
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_ISOP'.'.txt';
        $Directorio=$path."/".$nombreArchivo;
        $cadena='';        
        $tipoServicio= '15';
        $conciliacion=$this->pr->ISOP_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias);         
        if($conciliacion<>null)
        {
        foreach ($conciliacion as $concilia) {
            $RowFechaCorte=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Ymd'),8);
            $RowIdTrans=str_pad($concilia->transaccion_id,9,"0",STR_PAD_LEFT);
                $k=json_decode($concilia->info_transacciones);           
                       $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                        if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        }   
            $RowTipoPago=str_pad($concilia->TipoPago,2,"0",STR_PAD_LEFT);               
            $RowFolio=str_pad($concilia->Folio,11,"0",STR_PAD_LEFT);
            $RowRfc=str_pad($concilia->CartKey1,13," ",STR_PAD_LEFT);           
            $RowCuentaEstatal=str_pad($concilia->cuenta,11,"0",STR_PAD_LEFT);   
            $RowCurp=str_pad($concilia->curp,18);        
            $RowNombreRazonS=str_pad(mb_convert_encoding($concilia->nombre_razonS, "Windows-1252", "UTF-8"),120);
            $RowMesDeclarado=str_pad($concilia->mes,2,"0",STR_PAD_LEFT);
            $RowAnoDeclarado=str_pad($concilia->anio,4);
            $RowTipoDeclaracion=str_pad('N',1,"0",STR_PAD_LEFT);
            $RowPremio=str_pad($concilia->premio,15,"0",STR_PAD_LEFT);
            $RowImpuesto=str_pad(str_replace(".", "",$concilia->impuesto),15,"0",STR_PAD_LEFT);
            $RowActualizacion=str_pad(str_replace(".", "",$concilia->actualizacion),15,"0",STR_PAD_LEFT);
            $RowRecargos=str_pad(str_replace(".", "",$concilia->recargos),15,"0",STR_PAD_LEFT);
            $RowTotalContr=str_pad(str_replace(".", "",$concilia->total_contribuciones),15,"0",STR_PAD_LEFT);
            
            $cadena=$RowIdTrans.$RowFolio.$RowFechaTramite.$RowHoraTramite.$RowRfc.$RowCuentaEstatal.$RowCurp.$RowNombreRazonS.$RowTipoPago.$RowMesDeclarado.$RowAnoDeclarado.$RowTipoDeclaracion.$RowPremio.$RowImpuesto.$RowActualizacion.$RowRecargos.$RowTotalContr.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte;
            //$dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
            File::append($Directorio,$cadena."\r\n"); 
                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);           

           } 
        }       
    }
    private function gArchivo_Prestadora_Servicios($path,$fecha,$banco_id,$cuenta,$alias)
    {        
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_Prestadora_Servicios'.'.txt';
        $Directorio=$path."/".$nombreArchivo;  
        $cadena='';   
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
        $tipoServicio= '23';
        $conciliacion=$this->pr->PrestadoraServicios_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias);     
        if($conciliacion<>null){ 
            foreach ($conciliacion as $concilia) {
                $RowFechaCorte=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Ymd'),8);
                $RowBanco=str_pad($concilia->banco_id,4,"0",STR_PAD_LEFT);        
                $k=json_decode($concilia->info_transacciones);                    
                
                       $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                        $RowTotalTramite=str_pad(str_replace(".", "", $k->total_tramite),11,"0",STR_PAD_LEFT);
                        if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        }            

                $RowIdTrans=str_pad($concilia->transaccion_id,20,"0",STR_PAD_LEFT);
                $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);     
                $RowRfcAlfa=str_pad($concilia->rfcalfa,4,"0",STR_PAD_LEFT);  
                $RowRfcCnum=str_pad($concilia->rfcnum,6,"0",STR_PAD_LEFT);  
                $RowRfcChom=str_pad($concilia->rfchom,3,"0",STR_PAD_LEFT);  
                $RowCuenta=str_pad($concilia->cuenta,11,"0",STR_PAD_LEFT);
                $RowNombreRazonS=mb_convert_encoding($concilia->nombre_razonS,"Windows-1252", "UTF-8");
                $RowNombreRazonS=str_pad(mb_convert_encoding($RowNombreRazonS,"Windows-1252", "UTF-8"),150);
                $RowTipoDeclaracion=str_pad(Str::limit($concilia->tipo_declaracion, 1,''),1,"0",STR_PAD_LEFT);
                $RowValorFijo=str_pad('1',1);
                $RowAno=str_pad($concilia->anio,4);
                $RowMes=str_pad($concilia->mes,2,"0",STR_PAD_LEFT);       
                $RowFolioAnterior=str_pad($concilia->folio_anterior,20,"0",STR_PAD_LEFT);
                $RowNumComplem=str_pad(Str::limit($concilia->num_complementaria, 1,''),1,"0",STR_PAD_LEFT);
                $RowImptAnterior=str_pad(str_replace(".", "",$concilia->declaracion_anterior),13,"0",STR_PAD_LEFT);
                $RowEmpleados=str_pad($concilia->no_empleados,6,"0",STR_PAD_LEFT);
                $RowRenumeracion=str_pad(str_replace(".", "",$concilia->remuneraciones),15,"0",STR_PAD_LEFT);
                $declaracion=$concilia->tipo_declaracion;
                $impuesto=$concilia->impuesto;
                $cant_acreditada=$concilia->cant_acreditada;
                $actualizacion=$concilia->actualizacion;
                $recargos=$concilia->recargos;
                $dif_imp=$concilia->dif_impuesto;
                $dif_act=$concilia->dif_actualizacion;
                $dif_rec=$concilia->dif_recargos;

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
                        File::append($Directorio,$cadena."\r\n");
                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);           
                        
                }       
            }
        } 
    }
    private function gArchivo_Retenedora_Servicios($path,$fecha,$banco_id,$cuenta,$alias)
    {
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_Retenedora_Servicios'.'.txt'; 
        $Directorio=$path."/".$nombreArchivo; 
        $cadena='';  
        $tipoServicio= array('24');
        $conciliacion=$this->pr->RetenedoraServicios_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias);         
        if($conciliacion<>null) { 
            foreach ($conciliacion as $concilia) {
                $RowFechaCorte=str_pad(Carbon::parse($concilia->crated_at)->format('Ymd'),8);
                $RowBanco=str_pad($concilia->banco_id,4,"0",STR_PAD_LEFT);               
                   $k=json_decode($concilia->info_transacciones);                    
                        $RowTotalTramite=str_pad(str_replace(".", "", $k->total_tramite),13,"0",STR_PAD_LEFT);
                       $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                        if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        }   
                $RowIdTrans=str_pad($concilia->transaccion_id,20,"0",STR_PAD_LEFT);
                $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);        
                $RowRfcAlfa=str_pad($concilia->rfcalfa,4,"0",STR_PAD_LEFT);  
                $RowRfcCnum=str_pad($concilia->rfcnum,6,"0",STR_PAD_LEFT);  
                $RowRfcChom=str_pad($concilia->rfchom,3,"0",STR_PAD_LEFT);  
                $RowCuentaRet=str_pad($concilia->cuenta,11,"0",STR_PAD_LEFT);    
                $RowTipoDeclaracion=str_pad(Str::limit($concilia->tipo_declaracion, 1,''),1,"0",STR_PAD_LEFT);
                $RowAno=str_pad($concilia->anio,4);
                $RowMes=str_pad($concilia->mes,2,"0",STR_PAD_LEFT);  
                $RowNumComplem=str_pad(str_replace(".",$concilia->num_complementaria,""),1,"0",STR_PAD_LEFT);
                $RowFolioAnterior=str_pad(str_replace(".",$concilia->folio_anterior,""),20,"0",STR_PAD_LEFT);
                $RowImptDeclaracion=str_pad(str_replace(".", "", $concilia->declaracion_anterior),13,"0",STR_PAD_LEFT);
                $RowActualizaciones=str_pad(str_replace(".",$concilia->actualizacion,""),13,"0",STR_PAD_LEFT);
                $RowRecargos=str_pad(str_replace(".",$concilia->recargos,""),13,"0",STR_PAD_LEFT);
                $RowNombreRet=str_pad(mb_convert_encoding($concilia->nombre_retenedora, "Windows-1252", "UTF-8"),150);
                $RowRfcPrest=str_pad(mb_convert_encoding($concilia->rfc_prestadora, "Windows-1252", "UTF-8"),13);
                $RowCuentaPrest=str_pad($concilia->cuenta_2,11,"0",STR_PAD_LEFT);
                $RowNombrePrest=str_pad(mb_convert_encoding($concilia->nombre_prestadora, "Windows-1252","UTF-8"),150);
                $RowEmpleados=str_pad($concilia->no_empleados,6,"0",STR_PAD_LEFT);
                $RowRenumeracion=str_pad(str_replace(".", "", $concilia->remuneraciones),15,"0",STR_PAD_LEFT); 
                $RowRetencion=str_pad(str_replace(".","",$concilia->retencion),13,"0",STR_PAD_LEFT);
                
                $RowPartidaRet=str_pad('12510',5);
                $RowPartidaActu=str_pad('40215',5);
                $RowPartidaRecargo=str_pad('12514',5); 
                $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowCuentaRet.$RowNombreRet.$RowRfcPrest.$RowCuentaPrest.$RowNombrePrest.$RowTipoDeclaracion.$RowAno.$RowMes.$RowNumComplem.$RowFolioAnterior.$RowImptDeclaracion.$RowEmpleados.$RowRenumeracion.$RowPartidaRet.$RowRetencion.$RowPartidaActu.$RowActualizaciones.$RowPartidaRecargo.$RowRecargos.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowBanco.$RowTotalTramite;
                //$dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
               File::append($Directorio,$cadena."\r\n");

                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);           
            }
        }
    }

    private function gArchivo_Juegos_Apuestas($path,$fecha,$banco_id,$cuenta,$alias)
    {        
        $nombreArchivo=$alias.'_'.$cuenta.'_Corte_Juegos_Apuestas'.'.txt';
        $Directorio=$path."/".$nombreArchivo;
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
        $tipoServicio= '25';
        $conciliacion=$this->pr->Juegos_Apuestas_Corte($fecha,$banco_id,$tipoServicio,$cuenta,$alias);         
        if($conciliacion<>null){ 
            foreach ($conciliacion as $concilia) {
                $RowFechaCorte=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Ymd'),8);
                $RowIdTrans=str_pad($concilia->transaccion_id,20,"0",STR_PAD_LEFT);
               
                $k=json_decode($concilia->info_transacciones);               
                    $RowTotalTramite=str_pad(str_replace(".", "",$k->total_tramite ),13,"0",STR_PAD_LEFT);       
                    $RowFechaTramite=str_pad(Carbon::parse($k->fecha_tramite)->format('Ymd'),8);
                        $RowHoraTramite=str_pad(Carbon::parse($k->hora_tramite)->format('hms'),6);
                        $RowFechaDispersion=str_replace("Por Operacion", "", $k->fecha_disp);         
                        $RowHoraDispersion=str_replace("Por Operacion", "",$k->fecha_disp);
                        if(strlen($RowFechaDispersion)==13)
                        {
                        $RowFechaDispersion=str_pad(Carbon::parse(Str::limit($RowFechaDispersion,10,''))->format('Y-m-d'),10);
                        $RowHoraDispersion=str_pad(substr($RowHoraDispersion,-2).":00:00",8);
                        } 
                        else{
                            if($RowFechaDispersion==null)
                            {
                            $RowFechaDispersion=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad("00:00:00",8);
                             
                            }else{
                            $RowFechaDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('Y-m-d'),10);
                            $RowHoraDispersion=str_pad(Carbon::parse($k->fecha_disp)->format('H:m:s'),8);
                            }
                        } 
                       
                $RowTipoPago=str_pad($concilia->TipoPago,4,"0",STR_PAD_LEFT); /////////             
                
                $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);        
                $RowDescrip=str_pad(mb_convert_encoding($concilia->CartDescripcion, "Windows-1252", "UTF-8"),150);       
                $RowRfcAlfa=str_pad($concilia->rfcalf,4,"0",STR_PAD_LEFT);  
                $RowRfcCnum=str_pad($concilia->rfcnum,6,"0",STR_PAD_LEFT);  
                $RowRfcChom=str_pad($concilia->rfchom,3,"0",STR_PAD_LEFT);  
                $RowClaveMun=str_pad($concilia->cve_mpo,3,"0",STR_PAD_LEFT);        
                $RowCuenta=str_pad($concilia->cuenta,11,"0",STR_PAD_LEFT);
                $RowCurp=str_pad($concilia->curp,18);
                $RowClave=str_pad($concilia->cve_imp,4,"0",STR_PAD_LEFT);      
                $RowTipoDeclaracion=str_pad(Str::limit($concilia->tipo_dec, 1,''),1,"0",STR_PAD_LEFT);        
                $RowMes=str_pad($concilia->mes,2,"0",STR_PAD_LEFT);
                $RowAno=str_pad($concilia->anio,4,"0",STR_PAD_LEFT);
                $RowNumComplem=str_pad($concilia->num_comp,1,"0",STR_PAD_LEFT);
                $RowFolioAnterior=str_pad($concilia->folio_anterior,20,"0",STR_PAD_LEFT);
                $RowImporteAnterior=str_pad(str_replace(".", "", $concilia->imp_anterior),13,"0",STR_PAD_LEFT);     
                $importe=$concilia->imp_anterior;
                                  
                foreach (json_decode($consepto) as $cont) {
                    $calc= (float)$cont->total-(float)$importe;
                    $calc=number_format($calc,2,'.','');
                    $RowPartida=str_pad($cont->partida,5,"0",STR_PAD_LEFT);
                    $RowImporte=str_pad(str_replace(".", "",$calc ),13,"0",STR_PAD_LEFT);
                    $RowTotal=str_pad(str_replace(".", "",$cont->total."00" ),13,"0",STR_PAD_LEFT);
                    $RowClave=str_pad($cont->clave,2,"0",STR_PAD_LEFT);                      
                     
                    $cadena=$RowIdTrans.$RowFolio.$RowRfcAlfa.$RowRfcCnum.$RowRfcChom.$RowClaveMun.$RowCuenta.$RowDescrip.$RowCurp.$RowClave.$RowTipoDeclaracion.$RowAno.$RowMes.$RowNumComplem.$RowFolioAnterior.$RowImporteAnterior.$RowFechaTramite.$RowHoraTramite.$RowFechaDispersion.$RowHoraDispersion.$RowFechaCorte.$RowTipoPago.$RowTotalTramite.$RowPartida.$RowImporte.$RowTotal;
                        $dataAnsi=iconv(mb_detect_encoding($cadena), 'Windows-1252', $cadena);
                    File::append($Directorio,$dataAnsi."\r\n");
                $updateConciliacion=$this->pr->UpdatePorTransaccion($fecha,$concilia->transaccion_id);      

                }            
            }
        }
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
