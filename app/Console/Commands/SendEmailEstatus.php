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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Entities\NotificacionEstatusAtencion;

class SendEmails extends Command
{
    protected $maxTries = 5;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailing:sendemailstatus';

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

    public function __construct(
    )
    {
         parent::__construct();        

        // $this->notificacion = new NotificacionEstatusAtencion();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendEmailNotificacionSolicitudes();
    }
   
    private function sendEmailNotificacionSolicitudes(){
      $pending = $this->pendientesEnvio();
      if($pending != 0){
          \Log::stack(["mailing"])->info("\n\nTRYING TO SEND ".count($pending)." MESSAGES");
          $proceso = $this->procesarEnvio($pending);
          // final del proceso
          $fin = $this->updateAnswers($proceso, $pending);
      }else{
          \Log::stack(['mailing'])->info("No hay envios pendientes");
          dd("No hay envios pendientes");
      }
    }

    private function pendientesEnvio(){
      $p = $this->notificacion->whereIn("sent", [0, 99])->where(function($q) {
          $q->where('tries', null)
          ->orWhere('tries', '<', $this->maxTries);
      })->get();
      
      if($p->count() > 0){
          $data = array();
          foreach($p as $info){
              $data[]= array(
                  "id"        => $info->id,
                  "to"        => $info->user,
                  "message"   => $info->message,
                  "logs"      => $info->logs,
                  "tries"     => $info->tries
              );
          }
          return $data;
      }else{
          return 0;
      }
  }

  /**
   * Envia los correos electronicos y regresa un arreglo con el estatus del envio. 
   * (sent = 0)
   * 
   * @param array con registros de la tabla mail_messages con sent = 0
   *
   * @return object
   */ 
  private function procesarEnvio($info){
      foreach($info as $i){
          $answer[$i["id"]] = $this->sendMailMessage($i["to"],$i["message"]);
      }
      return $answer;
  }

  /**
   * Este metodo es el que envia el correo electronico. 
   * (sent = 0)
   * 
   * @param array con registros de la tabla mail_messages con sent = 0
   *
   * @return 1 si se mando correctamente o 99 si no se pudo mandar
   */ 
  private function sendMailMessage($to,$data){
      $mail = new PHPMailer(true);
      $user = UsersPortal::where("email", $to)->first();
    
      $nombre =$user->name." ".$user->fathers_surname." ".$user->mothers_surname;
      try{
            
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        $mail->SMTPAuth =true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587'; 
        $mail->Username = 'karlacespedesgob@gmail.com';
        $mail->Password = 'cespedes2020';
        $mail->setFrom('karlacespedesgob@gmail.com', 'noreply tesoreria'); 
        $mail->Subject = 'GOBIERNO DEL ESTADO DE NUEVO LEÓN';
        $mail->MsgHTML($data);                    
        $mail->addAddress($to, $nombre); 
        $mail->send();

        echo "Send: {$to}\n";
        \Log::stack(['mailing'])->info("Send: {$to}\n");
        return [1];
    }catch(phpmailerException $e){
       echo "Error: {$to}\n";
          \Log::stack(['mailing'])->error("Error: {$to}.\n".$e->getMessage());
          return [99, $e->getMessage()];
    }

    
  }

  /**
   * Este actualiza la tabla cuando se intento realizar el envio. 
   * (sent = 0)
   * 
   * @param array con registros de la tabla mail_messages con sent = 0
   *
   * @return 1 si se mando correctamente o 99 si no se pudo mandar
   */ 
  private function updateAnswers($array, $actual){
      foreach($array as $i => $j){
          $data = [ "sent" => $j[0] ];
          if(isset($j[1])){
              $key = array_search($i, array_column($actual, 'id'));
              $logs = $actual[$key]['logs'] ? "{$actual[$key]['logs']}|" : "";
              $data["tries"] = $actual[$key]['tries'] ? intval($actual[$key]['tries']) + 1 : 1;
              $data["logs"] = $logs.$j[1];
          }else{
              $data["tries"] = null;
              $data["logs"] = null;
          }

          $affectedRows = $this->notificacion->where("id", $i)->update($data);
      }
  }
}
