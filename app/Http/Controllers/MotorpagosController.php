<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\EgobiernodiasferiadosRepositoryEloquent;

class MotorpagosController extends Controller
{
    
	protected $diasferiadosdb;

    // In this method we ensure that the user is logged in using the middleware


    public function __construct( 
    	EgobiernodiasferiadosRepositoryEloquent $diasferiadosdb
     )
    {
        $this->middleware('auth');

        $this->diasferiadosdb = $diasferiadosdb;
    }

    /**
     * Muestra la vista inicial en donde se enlistan los dias feriados configurados en egobierno.
     *
	 * @param NULL because it's the initial view in the app
	 *
	 *
	 *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function diasferiados()
    {
    	try
    	{

    		$info = $this->diasferiadosdb->all();

    	}catch( \Exception $e ){
    		Log::info('Error Method diasferiados: '.$e->getMessage());
    	}

    	$response = array();

    	foreach($info as $i)
    	{
    		$response []= array(
    			"anio" 	=> $i->Ano,
    			"mes" 	=> $i->Mes,
    			"dia"	=> $i->Dia
    		);
    	}

    	return view('motorpagos/diasferiados', [ "saved_days" => $response ]);
    }
	public function insertDiasFeriados(Request $request)
	{
		$response = array();
		try
    	{
			
			$anio = $request->anio;$mes = $request->mes;$dia = $request->dia;			
			$info2 = $this->diasferiadosdb->create(['Ano' => $anio,'Mes' => $mes,'Dia' => $dia] );
    		
    	}catch( \Exception $e ){
    		Log::info2('Error Method diasferiados: '.$e->getMessage());
    	}
		
    	$info = $this->diasferiadosdb->all();
			

    	foreach($info as $i)
    	{
    		$response []= array(
    			"anio" 	=> $i->Ano,
    			"mes" 	=> $i->Mes,
    			"dia"	=> $i->Dia
    		);
    	}
		return view('motorpagos/diasferiados', [ "saved_days" => $response ]);

    	
	}
	public function deleteDiasFeriados(Request $request)
	{
		try
    	{
			
			$info2 = $this->diasferiadosdb->deleteWhere([
				'Ano'=>'2019'
				'Mes'=>'10',
				'Dia'=>'15',
			]);
    		$info = $this->diasferiadosdb->all();

    	}catch( \Exception $e ){
    		Log::info('Error Method diasferiados: '.$e->getMessage());
    	}

    	$response = array();

    	foreach($info as $i)
    	{
    		$response []= array(
    			"anio" 	=> $i->Ano,
    			"mes" 	=> $i->Mes,
    			"dia"	=> $i->Dia
    		);
    	}

    	return view('motorpagos/diasferiados', [ "saved_days" => $response ]);
	}
    /**
     * Muestra la vista para capturar nuevos metodos de pago y el listado de los que ya estan capturados
     *
	 * @param NULL because it's the initial view in the app
	 *
	 *
	 *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function crudmetodospago()
    {
    	
    	return view('motorpagos/metodospago');
    }
    /**
     * Muestra el listado de bancos y la relacion de cada una de sus cuentas
     *
	 * @param NULL because it's the initial view in the app
	 *
	 *
	 *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bancos()
    {

    	/* aqui hay que obtener cuales bancos se tienen registrados en el sistema */ 
    	
    	return view('motorpagos/bancos');
    }
    /**
     * Esta herramienta es operativa y sirve para modificar el estatus de una transaccion
     *
	 * @param NULL because it's the initial view in the app
	 *
	 *
	 *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cambiarstatustransaccion()
    {
    	
    	return view('motorpagos/statustransaccion');
    }

    /**
     * Esta herramienta es operativa y sirve para configurar los parametros para permitir el pago de servicios
     *
     * @param NULL because it's the initial view in the app
     *
     *
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function pagotramite()
    {
        
        return view('motorpagos/pagotramite');
    }

}
