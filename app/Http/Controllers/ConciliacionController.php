<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class ConciliacionController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth');
    }


    /**
     * Show multiple tools to update or create cfdi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */    

    public function index()
    {
    	return view('conciliacion/loadFile');
    }
}
