<?php
	
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\CfdiEncabezadosRepositoryEloquent;

use App\Repositories\CfdiDetalleRepositoryEloquent;

class ManualcfdiController extends Controller 
{
	public function __construct(CfdiEncabezadosRepositoryEloquent $encabezado,CfdiDetalleRepositoryEloquent $detalle)
	{
		$this->middleware('auth');

    	$this->encabezado = $encabezado;
        $this->detalle = $detalle;
	}


	/**
     * Show tools to create cfdi.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {	
    	$data['formaspago'] = [
    		'01' => 'Efectivo',
    		'02' => 'Cheque nominativo',
    		'03' => 'Transferencia electrónica de fondos',
    		'04' => 'Tarjeta de crédito',
    		'05' => 'Monedero electrónico',
    		'06' => 'Dinero electrónico',
    		'08' => 'Vales de despensa',
    		'12' => 'Dación en pago',
    		'13' => 'Pago por subrogación',
    		'14' => 'Pago por consignación',
    		'15' => 'Condonación',
    		'17' => 'Compensación',
    		'23' => 'Novación',
    		'24' => 'Confusión',
    		'25' => 'Remisión de deuda',
    		'26' => 'Prescripción o caducidad',
    		'27' => 'A satisfacción del acreedor',
    		'28' => 'Tarjeta de débito',
    		'29' => 'Tarjeta de servicios',
    		'30' => 'Aplicación de anticipos',
    		'31' => 'Intermediario pagos',
    		'99' => 'Por definir'
    	];
    	return view('cfditool/cfdimanual',$data);
    }
}