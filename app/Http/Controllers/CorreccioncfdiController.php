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
                $reg = $this->encabezado->findWhere(['rfc_receptor'=>$request->rfc,['fecha_transaccion','>=',date('Y').'-01-01']],['folio_unico','folio_pago','fecha_transaccion','estatus_generacion','estatus_documento','total']);
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
	 * @param POST request Folio Unico
     * Return result from Folio Unico query.
     *
     * @return table with data.
     */
    public function searchfoliounico(Request $request)
    {
    	if($request->isMethod('post'))
    	{
    		try {
    			$reg = $this->encabezado->findWhere(['folio_unico'=>$request->fu,['fecha_transaccion','>=',date('Y').'-01-01']],['folio_unico','folio_pago','fecha_transaccion','estatus_generacion','estatus_documento','total']);
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
            if($request->edit == 'header') {

                if(!$request->post('id') || !$request->post('metodo_pago'))
                    return json_encode([]);
                
                try {

                    $up = $this->encabezado->updateByIdCFDI(['idcfdi_encabezados'=>$request->id],['metodo_de_pago'=>$request->metodo_pago]);

                    return json_encode($request);                
                } 
                catch (\Exception $e) 
                {
                    return json_encode($e);
                }
            }
            elseif($request->edit == 'detail') {
                
                if(!$request->post('ids'))
                    return false;

                foreach ($request->ids as $k => $v) {

                    if((int)$v < 0){
                        $data = [
                            "folio_unico"=>$request->fun[$k],
                            "cantidad"=>$request->can[$k],
                            "unidad"=>$request->uni[$k],
                            "concepto"=>$request->con[$k],
                            "precio_unitario"=>$request->pre[$k],
                            "importe"=>$request->imp[$k],
                            "partida"=>$request->par[$k],
                            "fecha_registro"=>$request->fec[$k]
                        ];

                        try {
                            $info = $this->detalle->create($data);
                            
                        } catch (\Exception $e) {
                            Log::info('Error(1) al guardar registros en cfdi_detalle_t '.$e->getMessage());
                        }
                    }
                    elseif((int)$v > 0){

                        try {
                            $upd = $this->detalle->updateByIdCFDI(
                                ['idcfdi_detalle'=>$request->ids[$k]],
                                ['concepto'=>$request->con[$k],'precio_unitario'=>$request->pre[$k],'importe'=>$request->imp[$k],'partida'=>$request->par[$k]]
                            );
                            
                        } catch (\Exception $e) {
                            Log::info('Error(2) al actualizar registros en cfdi_detalle_t '.$e->getMessage());
                        }
                    }
                }
            }
            else
            {
                return false;                
            }
            
        }
    }
}
