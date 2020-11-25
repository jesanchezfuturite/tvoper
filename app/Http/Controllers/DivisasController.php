<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DivisasRepositoryEloquent;

class DivisasController extends Controller
{
    protected $divisas;
    
    public function __construct(
        DivisasRepositoryEloquent $divisas
        
       )
       {
         $this->divisas = $divisas;
   
       }
       public function getDivisas(){
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL,"https://session-api-pr-21.herokuapp.com/divisas"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $listDivisas = curl_exec($ch);

        curl_close($ch);  
        return $listDivisas;
       }
       public function saveDivisas(Request $request){

       }
}
