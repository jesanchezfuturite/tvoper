<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\CfdiEncabezadosRepositoryEloquent;

use App\Repositories\CfdiDetalleRepositoryEloquent;

class CorreccioncfdiController extends Controller
{
    //
    protected $encabezado;
    protected $detalle;

    public function __construct(CfdiEncabezadosRepositoryEloquent $encabezado,CfdiDetalleRepositoryEloquent $detalle)
    {
    	$this->middleware('auth');

    	$this->encabezado = $encabezado;
        $this->detalle = $detalle;
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
    			$reg = $this->encabezado->findWhere(['rfc_receptor'=>$request->rfc,['fecha_transaccion','>=',date('Y').'-01-01']],['folio_unico','folio_pago','fecha_transaccion','total']);
    			return json_encode($reg);
    			
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
                $enc = $this->encabezado->findWhere(['folio_unico'=>$request->fu],['idcfdi_encabezados','folio_unico','folio_pago','fecha_transaccion','total','metodo_de_pago','forma_de_pago']);
                
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
     * Return result from Detalle query.
     *
     * @return data from Detalle.
     */
    public function detalle(Request $request)
    {
        if($request->isMethod('get'))
        {
            try {
                $det = $this->detalle->findWhere(['folio_unico'=>$request->fu]);
                
                return json_encode($det);
                
            } 
            catch (\Exception $e) 
            {
                return json_encode($e);
            }
        }
    }

    /**
     *
     * @param GET request type of edition
     * Return result from edition.
     *
     * @return data from edition.
     */
    public function edit(Request $request)
    {
        if($request->isMethod('post'))
        {
            if($request->post('edit') == 'header')
            {
                try {
                    
                    if(!$request->post('id') || !$request->post('metodo_pago'))
                        return json_encode([]);

                    $up = $this->encabezado->updateByIDCFDI(['idcfdi_encabezados'=>$request->post('id')],['metodo_de_pago'=>$request->post('metodo_pago')]);

                    return json_encode($request->post());                
                } 
                catch (\Exception $e) 
                {
                    return json_encode($e);
                }

            }
            elseif($request->post('edit') == 'detail')
            {
                try {
                    return json_encode($request->post());                
                } 
                catch (\Exception $e) 
                {
                    return json_encode($e);
                }
            }
            else
            {
                return json_encode([]);                
            }
            
        }
    }
}
