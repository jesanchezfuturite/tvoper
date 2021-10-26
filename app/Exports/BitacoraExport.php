<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BitacoraExport implements FromView, ShouldAutoSize
{
    // use Exportable;

    function __construct($data) {
           $this->data = $data;
    }

    public function view(): View
    {      
        return view('reportes.bitacora', ['data' => $this->data]);
    }

    
}