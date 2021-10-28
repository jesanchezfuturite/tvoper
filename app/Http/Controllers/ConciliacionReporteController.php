<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Processedregisters;
use DB;

class ConciliacionReporteController extends Controller
{
    public function getYear(){
        $year = Processedregisters::select("year")->distinct()->orderBy("year")->get()->toArray();
        return $year;
    }

    public function getMonth(){
        $month = Processedregisters::select("month", DB::raw('(CASE 
        WHEN month = 1 THEN "Enero" 
        WHEN month = 2 THEN "Febrero"
        WHEN month = 3 THEN "Marzo" 
        WHEN month = 4 THEN "Abril" 
        WHEN month = 5 THEN "Mayo" 
        WHEN month = 6 THEN "Junio" 
        WHEN month = 7 THEN "Julio" 
        WHEN month = 8 THEN "Agosto" 
        WHEN month = 9 THEN "Septiembre" 
        WHEN month = 10 THEN "Octubre" 
        WHEN month = 11 THEN "Noviembre" 
        WHEN month = 12 THEN "Diciembre"  
        END) AS month'))
        ->distinct()->orderBy("month")->get()->toArray();
        return $month;
    }

    public function getDays($month, $year){
        $days = Processedregisters::select("day")
        ->where("month", $month)
        ->where("year", $year)
        ->distinct()->orderBy("day")->get()->toArray();
        return $days;
    }

    public function getFilename(){
        $filename =  config('conciliacion.conciliacion_conf');
       
        return $filename;
    }

    public function getDataConciliacion(Request $r){
        $data = Processedregisters::where("day", $r->day)
        ->where("month", $r->month)
        ->where("year", $r->year)
        ->where('filename', 'like', '%' . $r->filename . '%')
        ->get()->toArray();
        return json_encode($data);
    }
}
