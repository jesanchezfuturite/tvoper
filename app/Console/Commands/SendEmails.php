<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use File;
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
use App\Repositories\RespuestatransaccionRepositoryEloquent;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendEmails:EmailGrid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de correo';

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
    protected $cortesolicituddb;
    protected $respuestatransacciondb;

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
        CortesolicitudRepositoryEloquent $cortesolicituddb,
        RespuestatransaccionRepositoryEloquent $respuestatransacciondb
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
        $this->cortesolicituddb=$cortesolicituddb;
        $this->respuestatransacciondb=$respuestatransacciondb;


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->SendEmailTransaccion();
    }
    private function SendEmailTransaccion()
    {
        $this->SendEmial_referencia();
        $this->SendEmial_pagado();
        //$this->SendEmial_proceso();
    }
    private function SendEmial_referencia(){
        $findTransaccion=$this->oper_transaccionesdb->findWhere(['estatus'=>'60','email_referencia'=>null]);      
        foreach ($findTransaccion as $k) {
             $correo='';
             $nombre='';
             $url='';
             $referencia=$k->referencia;
             $id=$k->id_transaccion_motor;
             $findtramite=$this->tramitedb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findtramite as $e) {
                $correo=$e->email;
                $nombre=$e->nombre.' '.$e->apellido_paterno;
             //$nombre='';
             //$correo='juancarlos96.15.02@gmail.com';             
            }
            $findRespuesta=$this->respuestatransacciondb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findRespuesta as $r) {
                $url=json_decode($r->json_respuesta);
            }
            //log::info($url->url_recibo);
            $message="Se ha generado la Referencia: ".$referencia."/n"."URL: ".$url->url_recibo;
            $enviar=$this->SendGridMail($nombre,$correo,$message);
            if($enviar==202)
            {
                $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_referencia'=>'1'],['id_transaccion_motor'=>$id]);
            }else{
                $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_referencia'=>'0'],['id_transaccion_motor'=>$id]);
            }
        }

    }
    private function SendEmial_pagado(){
        $findTransaccion=$this->oper_transaccionesdb->findWhere(['estatus'=>'0','email_pago'=>null]);       
        foreach ($findTransaccion as $k) {
             $correo='';
             $nombre='';
             $id=$k->id_transaccion_motor;
             $findtramite=$this->tramitedb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findtramite as $e) {
             //$correo=$e->email;
            $correo='juancarlos96.15.02@gmail.com';
             $nombre=$e->nombre.' '.$e->apellido_paterno;
            }
            $message="Se ha realizado el PAGO";
            $enviar=$this->SendGridMail($nombre,$correo,$message);
            if($enviar==202)
            {
                $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'1'],['id_transaccion_motor'=>$id]);
            }else{
                $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'0'],['id_transaccion_motor'=>$id]);
            }
        }

    }
    private function SendGridMail($email_name,$email_address,$message)
    {
        //$message="Mensaje Prueba";
        if($email_address==''){
            $res=404;
        }else{
        $email_from=env('MAIL_FROM_ADDRESS');
        $email_from_name=env('MAIL_FROM_NAME');
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($email_from, $email_from_name);
        $email->setSubject("Mensaje Prueba");
        $email->addTo($email_address,$email_name);
        $email->addContent("text/plain", $message);
        
        $sendgrid = new \SendGrid(getenv('MAIL_API_KEY'));
        try {
        $response = $sendgrid->send($email);        
        } catch (Exception $e) {
             $res=404;
            log::info($e->getMessage() );
        }
        //log::info($response->statusCode());
        $res=$response->statusCode();
        }
        return $res;
    }
    ////adjuntar imagen
    /*$att1 = new \SendGrid\Mail\Attachment();
        $att1->setContent(file_get_contents(storage_path('app/archivo.txt')));
        $att1->setType("application/octet-stream");
        $att1->setFilename(basename(storage_path('app/archivo.txt')));
        $att1->setDisposition("attachment");
        $email->addAttachment($att1);*/

}
