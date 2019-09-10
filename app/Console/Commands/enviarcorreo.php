<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class enviarcorreo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviarcorreo:correo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $subject = "Asunto del correo";
         $data = [
       'link' => 'https'
     ];
        $for = "juancarlos96.15.02@gmail.com";
        Mail::send('email',$data, function($msj) use($subject,$for){
            $msj->subject($subject);
            $msj->to($for);
        });
    }
}
