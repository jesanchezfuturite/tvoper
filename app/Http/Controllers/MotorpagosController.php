<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\EgobiernodiasferiadosRepositoryEloquent;
use App\Repositories\limitereferenciaRepositoryEloquent;

class MotorpagosController extends Controller
{
    
	protected $diasferiadosdb;
    protected $limitereferenciadb;

    // In this method we ensure that the user is logged in using the middleware


    public function __construct( 
    	EgobiernodiasferiadosRepositoryEloquent $diasferiadosdb,
        limitereferenciaRepositoryEloquent $limitereferenciadb
     )
    {
        $this->middleware('auth');

        $this->diasferiadosdb = $diasferiadosdb;
        $this->limitereferenciadb=$limitereferenciadb;
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
		//return view('motorpagos/diasferiados', [ "saved_days" => $response ]);

    	return json_encode($response);
	}
	public function deleteDiasFeriados(Request $request) 
	{
		try
    	{
				$anio = $request->anio;$mes = $request->mes;$dia = $request->dia;
			$info2 = $this->diasferiadosdb->deleteWhere([

				'Ano'=>$anio,
				'Mes'=>$mes,
				'Dia'=>$dia

			]);
    		
    	}catch( \Exception $e ){
    		Log::info('Error Method diasferiados: '.$e->getMessage());
    	}
        $info = $this->diasferiadosdb->all();
    	$response = array();

    	foreach($info as $i)
    	{
    		$response []= array(
    			"anio" 	=> $i->Ano,
    			"mes" 	=> $i->Mes,
    			"dia"	=> $i->Dia
    		);
    	}
return json_encode($response);
    	//return view('motorpagos/diasferiados', [ "saved_days" => $response ]);
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


    public function limitereferencia()
    {
        try
        {

            $info = $this->limitereferenciadb->all();

        }catch( \Exception $e ){
            Log::info('Error Method diasferiados: '.$e->getMessage());
        }

        $response = array();

        foreach($info as $i)
        {
            $response []= array(
                "id" => $i->id,
                "descripcion" => $i->descripcion,
                "periodicidad" => $i->periodicidad,
                "vencimiento" => $i->vencimiento,
                "created_at" => $i->created_at,
                "updated_at" => $i->updated_at

            );
        }
        return view('motorpagos/limitereferencia',[ "saved_days" => $response ]);

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
