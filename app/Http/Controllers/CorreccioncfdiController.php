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
    			
    		} 
            catch (\Exception $e) 
            {
    			return json_encode($e);
    		}
    	}
    }

    /**
     *
     * @param GET request Folio Unico
     * Return result from Encabezados query.
     *
     * @return data from Encabezados.
     */
    public function encabezado(Request $request)
    {
        if($request->isMethod('get'))
        {
            try {
                $enc = $this->encabezado->findWhere(['folio_unico'=>$request->fu],['folio_unico','folio_pago','fecha_transaccion','total','metodo_de_pago','forma_de_pago']);
                return json_encode($enc);
                
            } 
            catch (\Exception $e) 
            {
                return json_encode($e);
            }
        }
    }
}
