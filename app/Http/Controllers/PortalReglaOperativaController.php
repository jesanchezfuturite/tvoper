<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Repositories\PortalreglaoperativaRepositoryEloquent;
use App\Repositories\PortalreglaoperativacamposRepositoryEloquent;
use App\Repositories\PortalcampoRepositoryEloquent;

class PortalReglaOperativaController extends Controller
{
    //
    protected $reglaoperativa;
    protected $ro_cmps;
    protected $campos;

      public function __construct(
        PortalreglaoperativaRepositoryEloquent $reglaoperativa,
        PortalreglaoperativacamposRepositoryEloquent $ro_cmps,
        PortalcampoRepositoryEloquent $campos
        )
      {
        $this->middleware('auth');
        $this->reglaoperativa = $reglaoperativa;
        $this->ro_cmps = $ro_cmps;
      	$this->campos = $campos;
      }

      public function index()
      {
      	return view('');
      }

      public function getReglas(){
        try {
          $reglas = $this->reglaoperativa->get();

    		} catch (\Exception $e) {
    			Log::info('Error Tramites - listar campos: '.$e->getMessage());
    		}
        return json_encode($reglas);
      }
}
