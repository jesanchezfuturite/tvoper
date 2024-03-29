<?php

namespace App\Exports;

use App\Entities\UsersPortal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromView, ShouldAutoSize
{
    // use Exportable;

    protected $ids;

    function __construct($ids) {
           $this->ids = $ids;
    }

    public function view(): View
    {
        $users = UsersPortal::from("portal.users as u")
        ->leftjoin("portal.config_user_notary_offices as config", "u.id", "=", "user_id")
        ->leftjoin("portal.notary_offices as not", "config.notary_office_id", "=", "not.id")
        ->leftjoin("portal.catalog_user_roles as r", "r.id", "=", "u.role_id")
        ->select("not.sat_constancy_file", "not.notary_constancy_file", "not.notary_number",
         "u.id as id_usuario", "u.role_id", "u.config_id", 
         "u.name", "u.mothers_surname", "u.fathers_surname", "u.curp",
         "u.rfc","u.phone","u.status",
         "r.description as role",
         "u.username", "u.email")
         ->whereIn("u.id", $this->ids)
         ->get();        
        return view('reportes.usuariosExcel', [
            'users' => $users
        ]);
    }

    
}