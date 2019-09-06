<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use App\Repositories\IcvremotoreferenciaRepositoryEloquent;

class IcvrestserviceController extends Controller
{
    //
    protected $icv;

    public function __construct(
        IcvremotoreferenciaRepositoryEloquent $icv
    )
    {

        $this->icv = $icv;

    }

    public function icvconsultaplaca()
    {
    	$data = $this->icv->all();

    	dd($data);

    }


}
