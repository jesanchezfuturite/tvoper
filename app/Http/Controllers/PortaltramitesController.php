<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\PortalcampoRepositoryEloquent;

class PortaltramitesController extends Controller
{
    //

	protected $campos;

    public function __construct(
    	PortalcampoRepositoryEloquent $campos
    )
    {
    	$this->campos = $campos;
    }


    /*
	 *  listFields
	 *
	 *
	 *
	 *
    */

	public function listFields()
	{
		$cmp = $this->campos->all();

		$response = array();

		try{
	    foreach ($cmp as $t) {
	      $response []=array(
	        'id_campo'=> $t->id,
	        'campo' => $t->descripcion,
	      );
	    }

	  }catch(\Exception $e){
	    Log::info('Error Operacion - ver Tramites: '.$e->getMessage());
	  }

		return view('portal/fieldtramites', ['data'=> $response]);
	}

	public function newField(Request $request){

	}

	public function editField(Request $request){

	}

}
