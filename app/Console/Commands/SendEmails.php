<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Dompdf\Dompdf;
use Dompdf\Options;

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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
        //$this->SendEmial();
        $this->SendEmial_pagado();
        //$this->email_template();
    }
    private function SendEmial_referencia(){
        $fecha=Carbon::now();
        $fechaIn=$fecha->format('dmY');
        $path1=storage_path('app/pdf/');
        if (!File::exists($path1))
        {
          File::makeDirectory($path1);
        }   
        $findTransaccion=$this->oper_transaccionesdb->ConsultaCorreo(['estatus'=>'60','email_referencia'=>null])->paginate(10);             
        foreach ($findTransaccion as $k) {
             $correo='';
             $enviar='404';
             $nombre='';
             $url='';
             $url_recibo='';
             $fecha=Carbon::parse($k->fecha_transaccion);
             $id_servicio='';
             $referencia=$k->referencia;
             $id=$k->id_transaccion_motor;
             $findtramite=$this->tramitedb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findtramite as $e) {
              $correo=$e->email;
              if($e->nombre=='')
              {
                $nombre=$e->razon_social; 
              }else{
                  $nombre=$e->nombre.' '.$e->apellido_paterno;
              }
                $id_servicio=$e->id_tipo_servicio;
             //$correo='juancarlos96.15.02@gmail.com';             
            }
            $findRespuesta=$this->respuestatransacciondb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findRespuesta as $r) {
                $url=json_decode($r->json_respuesta);
            }
            $findServicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=> $id_servicio]);
            foreach ($findServicio as $s) {
              $servicio=$s->Tipo_Descripcion;
            }
            if($url==""){
                $url_recibo="#";

            }else{
                $url_recibo=$url->url_recibo;
            }
            if($correo=='')
            {
              $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_referencia'=>'0'],['id_transaccion_motor'=>$id]); 
              }else{
                $fecha_txt ='Realizado el: ' . $fecha->format('d-m-Y');
                $encabezado='Hemos recibido tu solicitud de pago';
                $subencabezado='Por favor observa las instrucciones respecto a las formas de pago';
                $transaccion_txt='Transaccion número: ' .(string)$id;
                $url_txt='Formato de pago: ' .(string)$url_recibo;
                $referencia_txt='Referencia de Pago: ' .(string)$referencia;
                $servicio_txt='Servicio: ' .(string)$servicio;
                $banco_txt='';
                $footer_txt='<p>¿Necesitas asistencia? Contáctanos</p><p>Llámanos : (81) 2033-2420</p><p>Escríbenos un mail: egobierno@nuevoleon.gob.mx</p>';
                $options= new Options();
                $options->set('isHtml5ParserEnabled',true);
                $options->set('isRemoteEnabled',true);

                $dompdf = new DOMPDF($options);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->set_option('dpi', '160');
                //$dompdf->setPaper('A2', 'portrait');
                $dompdf->load_html( file_get_contents($url_recibo) );
                $dompdf->render();
                $output=$dompdf->output();
                $pdf=$path1.'Formato_Pago_'.$id.'_'.$fechaIn.'.pdf';
                if (File::exists($pdf))
                {
                  File::delete($pdf);
                }        
                File::put($pdf,$output);
                
                $valida_=filter_var($correo, FILTER_VALIDATE_EMAIL);
                //log::info($valida_);
                if($valida_!==false)
                  {
                    $enviar=$this->SendEmial($id,$nombre,$correo,$encabezado,$subencabezado,$transaccion_txt,$url_txt,$referencia_txt,$fecha_txt,$servicio_txt,$pdf,$banco_txt,$footer_txt);
                  }else{
                    //$updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'0'],['id_transaccion_motor'=>$id]);
                  }
                if (File::exists($pdf))
                {
                  File::delete($pdf);
                } 
                if($enviar=='202')
                {
                  $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_referencia'=>'1'],['id_transaccion_motor'=>$id]);
                }else{
                  $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_referencia'=>'0'],['id_transaccion_motor'=>$id]);
                }
              }
        }

    }
    private function SendEmial_pagado(){
      
        $fecha=Carbon::now();
        $fechaIn=$fecha->format('dmY');
        $path1=storage_path('app/pdf/');
        if (!File::exists($path1))
          {
            File::makeDirectory($path1);
          }  
        $findTransaccion=$this->oper_transaccionesdb->ConsultaCorreo(['estatus'=>'0','email_pago'=>null])->paginate(10);
        //log::info($findTransaccion);       
        foreach ($findTransaccion as $k) {
             $correo='';
             $enviar='404';
             $nombre='';
             $url='';
             $url_recibo='';
             $fecha='';
             $id_servicio='';
             $banco=$k->banco;
             $referencia=$k->referencia;
             $id=$k->id_transaccion_motor;
             $findtramite=$this->tramitedb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findtramite as $e) {
             $correo=$e->email;
              //$correo='juancarlos96.15.02@gmail.com';
             if($e->nombre=='')
              {
                $nombre=$e->razon_social; 
              }else{
                  $nombre=$e->nombre.' '.$e->apellido_paterno;
              }
             
             $id_servicio=$e->id_tipo_servicio;
            }
            $findRespuesta=$this->respuestatransacciondb->findWhere(['id_transaccion_motor'=>$id]);
            foreach ($findRespuesta as $r) {
                $url=json_decode($r->json_respuesta);
            }
            $findServicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=> $id_servicio]);
            foreach ($findServicio as $s) {
              $servicio=$s->Tipo_Descripcion;
            }
            if($url==""){
                $url_recibo="#";

            }else{
                $url_recibo=$url->url_recibo;
            }
            $encabezado='Tu pago se ha realizado con éxito';
            $subencabezado='';
            $transaccion_txt='Transaccion número: ' .(string)$id;
            $url_txt='Recibo de pago: https://egobierno.nl.gob.mx/egob/recibopago.php?folio='.(string)$id;
            $referencia_txt='Referencia Bancaria: ' .(string)$referencia;
            $servicio_txt='Servicio: ' .(string)$servicio;
            $banco_txt='Banco receptor del pago: '.$banco;
            $footer_txt='<p>**Teléfono de atención 20 33 24 20 en horario de 8:30 a 16:30 de Lunes a Viernes. Por favor conserve este correo y/o recibo de pago descargable de la liga adjunta para cualquier aclaración. Agradecemos su preferencia y lo invitamos a que siga disfrutando de los beneficios que este servicio brinda.</p>';
            if($correo=='')
            {

             $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'0'],['id_transaccion_motor'=>$id]); 
            }else{
                $options= new Options();
                $options->set('isHtml5ParserEnabled',true);
                $options->set('isRemoteEnabled',true);

                $dompdf = new DOMPDF($options);
                $dompdf->setPaper('A3', 'portrait');
                $dompdf->load_html( file_get_contents('https://egobierno.nl.gob.mx/egob/recibopago.php?folio='.(string)$id) );
                $dompdf->render();
                $output=$dompdf->output();
                $pdf=$path1.'Recibo_Pago_'.$id.'_'.$fechaIn.'.pdf';
                if (File::exists($pdf))
                {
                  File::delete($pdf);
                }        
                File::put($pdf,$output);
                $valida_= filter_var($correo, FILTER_VALIDATE_EMAIL);
                //log::info($valida_);
                if($valida_!==false)
                  {
                    $enviar=$this->SendEmial($id,$nombre,$correo,$encabezado,$subencabezado,$transaccion_txt,$url_txt,$referencia_txt,$fecha,$servicio_txt,$pdf,$banco_txt,$footer_txt);
                  }else{
                    $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'0'],['id_transaccion_motor'=>$id]);
                  }
                if (File::exists($pdf))
                {
                  File::delete($pdf);
                } 
              if($enviar=='202')
              {
                $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'1'],['id_transaccion_motor'=>$id]);
              }else{
                $updatetransaccion=$this->oper_transaccionesdb->updateEnvioCorreo(['email_pago'=>'0'],['id_transaccion_motor'=>$id]);
              }
            }
            
        }

    }
    public function SendEmial($folio,$nombre,$correo,$encabezado,$subencabezado,$transaccion,$url,$referencia,$fecha,$servicio,$pdf,$banco,$footer)
    {
         $mail = new PHPMailer(true);
         $response='202';
         $message=$this->plantillaEmail($encabezado,$subencabezado,$transaccion,$url,$referencia,$fecha,$servicio,$banco,$footer);
        //log::info($correo.'  '.$nombre.' '.$folio);
        try{
            
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            $mail->SMTPAuth =true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587'; 
            $mail->Username = 'noreply.tesoreria@gmail.com';
            $mail->Password = 'T3s0rer142020';
            $mail->setFrom('noreply.tesoreria@gmail.com', 'noreply tesoreria'); 
            $mail->Subject = 'GOBIERNO DEL ESTADO DE NUEVO LEÓN';
            $mail->MsgHTML($message);
           $mail->addAttachment($pdf);                     
            $mail->addAddress($correo, $nombre); 
            $mail->send();
        }catch(phpmailerException $e){
            log::info($e);
            $response='404';
        }
        return $response;
    }

    
    private function plantillaEmail($encabezado,$subencabezado,$transaccion,$url,$referencia,$fecha,$servicio,$banco,$footer)
    {
        $email='<!doctype html><html><head><meta name="viewport" content="width=device-width" /><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Egobierno</title><style> 
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; 
      }
      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }
      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px;
          vertical-align: top; 
      }
      .body {
        background-color: #f6f6f6;
        width: 100%; 
      }
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 780px;
        padding: 10px;
        width: 780px; 
      }
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 680px;
        padding: 10px; 
      }
      .main {
        background: #ffffff;
        border-radius: 3px;
        width: 100%; 
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 15px; 
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; 
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; 
      }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; 
      }
      .btn-primary table td {
        background-color: #3498db; 
      }

      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; 
      }
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }

      .align-right {
        text-align: right; 
      }

      .align-left {
        text-align: left; 
      }

      .clear {
        clear: both; 
      }

      .mt0 {
        margin-top: 0; 
      }

      .mb0 {
        margin-bottom: 0; 
      }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; 
      }

      .powered-by a {
        text-decoration: none; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #bebebe;
        margin: 20px 0; 
      }
      @media only screen and (max-width: 620px) {
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; 
        }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; 
        }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; 
        }
        table[class=body] .content {
          padding: 0 !important; 
        }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; 
        }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; 
        }
        table[class=body] .btn table {
          width: 100% !important; 
        }
        table[class=body] .btn a {
          width: 100% !important; 
        }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; 
        }
      }
      @media all {
        .ExternalClass {
          width: 100%; 
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; 
        }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; 
        }
        #MessageViewBody a {
          color: inherit;
          text-decoration: none;
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit;
          line-height: inherit;
        }
        .btn-primary table td:hover {
          background-color: #34495e !important; 
        }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; 
        } 
      }
    </style>
  </head>
  <body class="">  
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <table role="presentation" class="main">
              <tr>
                <td class="wrapper">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                       <center><h2><strong>'.$encabezado.'</strong></h2></center> 
                       <center><h3>'.$subencabezado.'</h3></center> 
                       <div style="text-align:right;"> <p>'.$fecha.'</p></div>
                       <div style="text-align:left"> <p>'.$transaccion.'</p></div>
                       <hr style="color:#000;">             
                        <br>
                        <p>Resumen de pago: </p>
                        <p>'.$referencia.' </p>                        
                        <p>'.$servicio.' </p>
                        <p>'.$banco.'</p>
                        <br>
                        <!--<p>'.$url.'</p>-->
                        <br>
                        <br>
                        '.$footer.'
                         <br> <br>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                  <tbody >
                                    <tr> </td>
                                     <!-- <td whidth="100%" align="center"> <a href="'.$url.'" target="_blank">Ver Recibo</a> </td>-->
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
           <!-- <div class="footer">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr><td class="content-block"><span class="apple-link">Emial Prueba</span></td></tr><tr> </tr>
              </table>
            </div>-->
          </div></td><td>&nbsp;</td></tr></table></body></html>
    ';
    return $email;
    }
}
