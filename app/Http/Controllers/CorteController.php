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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
   
    public function enviacorreo($fecha)
    {   
        $Directorio=array();
        $fecha= Carbon::parse($fecha);
         //$this->gArchivo_Generico_prueba($fecha);
        //$findCorte=$this->cortesolicituddb->findWhere(['fecha_ejecucion'=>$fecha,'status'=>'1']);
        
        $response='false';
        $path1=storage_path('app/Cortes/'.$fecha->format('Y'));
        $path2=$path1.'/'.$fecha->format('m');
        $path3=$path2.'/'.$fecha->format('d');
        if (File::exists($path3))
        {
            $Archivos=File::allFiles($path3); 
            foreach ($Archivos as $key) {
                $Directorio []=array('path' => $path3.'/'.$key->getRelativePathname());
            }  
        } 
        /*foreach ($findCorte as $e) {
                    
            $path4=$path3.'/'.$e->banco_id;
            
            if (File::exists($path4))
            {
                $Archivos=File::allFiles($path4); 
                foreach ($Archivos as $key) {
                    $Directorio []=array('path' => $path4.'/'.$key->getRelativePathname());
                }  
            }   
        }*/

        $mail = new PHPMailer(true);
         $message="Corte Fecha: ".$fecha->format('Y-m-d');
        try{
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth =true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587'; 
            $mail->Username = 'nl.modulo2020@gmail.com';
            $mail->Password = 'M0du10n12020';
            $mail->setFrom('nl.modulo2020@gmail.com', 'MODULO2020'); 
            $mail->Subject = 'CORTE ARCHIVOS';
            
            $Directorio=json_decode(json_encode($Directorio));
            foreach ($Directorio as $d) {
                $mail->addAttachment($d->path);
            }
            $mail->MsgHTML($message);
            $mail->addCC('concentracioningresos@gmail.com'); 
            $mail->addCC('cesar.maresg@hotmail.com');
            $mail->addCC('iylamg@gmail.com');
            //$mail->addCC('juancarlos96.15.02@gmail.com');
            //$mail->addAddress('veronica.ramos@nuevoleon.gob.mx', 'Veronica Ramos'); 
            //$mail->addReplyTo('arturo.lopez@nuevoleon.gob.mx', 'Arturo Lopez'); 
            $mail->send();
            $response='true';
        }catch(phpmailerException $e){
            log::info($e);
            $response='false';
        }
        return $response;

    }
    private function gArchivo_Generico_prueba($fecha_ejecucion)
    {        
           
        $path1=storage_path('app/Cortes/'.$fecha_ejecucion->format('Y'));
        $path2=$path1.'/'.$fecha_ejecucion->format('m');
        $path3=$path2.'/'.$fecha_ejecucion->format('d');

         if (!File::exists($path1))
                {File::makeDirectory($path1, 0755, true);}
        if (!File::exists($path2))
                {File::makeDirectory($path2, 0755, true);}
        if (!File::exists($path3))
                {File::makeDirectory($path3, 0755, true);}
        $nombreArchivo='/'.Carbon::parse($fecha_ejecucion)->format('Ymd').'_Corte_Generico'.'.txt';
        $Directorio=$path3.$nombreArchivo;
        if (File::exists($Directorio))
        {
            File::delete($Directorio);
        }  
        $conciliacion=$this->pr->Generico_Corte_Oper_prueba($fecha_ejecucion); 
        //log::info($conciliacion);
        if($conciliacion<>null){     
        foreach ($conciliacion as $concilia) {  
                        
                        $RowClaveltramite=str_pad('025001',6,"0",STR_PAD_LEFT);
                    
                        $RowFechaDis=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Ymd'),8);
                        $RowHoraDis=str_pad(Carbon::parse($concilia->fecha_ejecucion)->format('Hms'),6);        
                        $RowFechapago=str_pad(Carbon::parse($concilia->year . '-' . $concilia->month . '-' . $concilia->day)->format('Ymd'),8);
                        $RowHorapago=str_pad(Carbon::parse($concilia->year . '-' . $concilia->month . '-' . $concilia->day)->format('hms'),6);
                        $RowPartida=str_pad($concilia->partida,5,"0",STR_PAD_LEFT);
                        $RowConsepto=str_pad(mb_convert_encoding(substr($concilia->concepto,0,120), "Windows-1252", "UTF-8"),120);
                        $RowFolio=str_pad($concilia->Folio,20,"0",STR_PAD_LEFT);
                        $RowTotalpago=str_pad(str_replace(".","",$concilia->importe_concepto) ,13,"0",STR_PAD_LEFT);
                        $RowReferencia=str_pad($concilia->referencia,30,"0",STR_PAD_LEFT);                         
                        $RowOrigen=str_pad("027",3,"0",STR_PAD_LEFT);  
                        $RowMedio_pago=str_pad($concilia->banco_id,3,"0",STR_PAD_LEFT);//pendiente                                 
                        $RowDatoAdicional1=str_pad('',30,"0",STR_PAD_LEFT);//pendiente
                        $RowDatoAdicional2=str_pad($concilia->auxiliar_2,15,"0",STR_PAD_LEFT);//pendiente
                        $RowCuentaPago=str_pad($concilia->cuenta_banco,30,"0",STR_PAD_LEFT);
                        $RowAlias=str_pad($concilia->cuenta_alias,6,"0",STR_PAD_LEFT); 
                        $cadena=$RowReferencia.$RowFolio.$RowOrigen.$RowMedio_pago.$RowTotalpago.$RowClaveltramite.$RowPartida.$RowConsepto.$RowFechaDis.$RowHoraDis.$RowFechapago.$RowHorapago.$RowCuentaPago.$RowAlias.$RowDatoAdicional1.$RowDatoAdicional2;
                        File::append($Directorio,$cadena."\r\n");
            }
        }
    }

}
