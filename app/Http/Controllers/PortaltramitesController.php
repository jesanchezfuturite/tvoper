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

	protected $campos

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
		return view('portal.fieldtramites', []);
	}

}
