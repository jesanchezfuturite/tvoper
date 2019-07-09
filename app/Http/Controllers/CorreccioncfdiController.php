<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\CfdiEncabezadosRepositoryEloquent;

class CorreccioncfdiController extends Controller
{
    //
    protected $encabezado;

    public function __construct(CfdiEncabezadosRepositoryEloquent $encabezado)
    {
    	$this->middleware('auth');

    	$this->encabezado = $encabezado;
    }

    /**
     * Show multiple tools to update or create cfdi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    	// try {
    	
    	// 	$enc = $this->encabezado->findWhere(['folio_unico'=>'180000000000006317559222904211'],['rfc_receptor','fecha_registro','metodo_de_pago']);

    	// 	if ($enc->count()) {
	    // 		foreach ($enc as $key => $value) {
	    // 			dd($value->rfc_receptor,$value->fecha_registro,$value->metodo_de_pago);
	    // 		}
    	// 	}

    		
    	// } catch (\Exception $e) {
    	// 	dd($e->getMessage());
    	// }

    	return view('cfditool/cfdicorreccion');

    }

    /**
	 *
	 * @param POST request RFC
     * Return result from RFC query.
     *
     * @return table with data.
     */
    public function searchrfc(Request $request)
    {
    	if($request->isMethod('post'))
    	{
    		try {
    			$enc = $this->encabezado->findWhere(['rfc_receptor'=>$request->rfc,['fecha_transaccion','>=',date('Y').'-01-01']],['folio_unico','folio_pago','fecha_transaccion','total']);

                
    			
    			return json_encode($enc);
    			
    		} catch (\Exception $e) {
    			return json_encode($e);
    		}
    	}
    }
}
