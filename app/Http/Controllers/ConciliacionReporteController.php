<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Processedregisters;

class ConciliacionReporteController extends Controller
{
    public function getYear(){
        $year = Processedregisters::select("year")->distinct()->orderBy("year")->get()->toArray();
        return $year;
    }

    public function getMonth(){
        $month = Processedregisters::select("month")->distinct()->orderBy("month")->get()->toArray();
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
    public function index()
    {
        return view("conciliacion/conciliacionreporte");
    }
}
