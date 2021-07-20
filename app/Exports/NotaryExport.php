<?php

namespace App\Exports;
use DB;
use App\Entities\PortalNotaryOffices;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NotaryExport implements FromView
{
    // use Exportable;

    protected $ids;

    function __construct($ids) {
           $this->ids = $ids;
    }

    public function view(): View
    {
        
        $notaria = PortalNotaryOffices::from("portal.notary_offices as not")        
        ->leftjoin("portal.estados as edo", "not.federal_entity_id", "=", "edo.clave" )           
        ->select(
            "not.*", 
            "not.indoor-number as numero_int", 
            "edo.nombre as estado",
            DB::raw("(SELECT mun.nombre from portal.municipios as mun LEFT JOIN portal.estados as estado 
            on estado.clave= mun.clave_estado WHERE not.federal_entity_id=mun.clave_estado 
            and not.city_id=mun.clave) 
            as municipio")
        )->whereIn("not.id", $this->ids)->get();  
 
        return view('reportes.notariaExcel', [
            'notaria' => $notaria
        ]);
    }

    
}