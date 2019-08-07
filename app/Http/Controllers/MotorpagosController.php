<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use App\Repositories\EgobiernodiasferiadosRepositoryEloquent;
use App\Repositories\limitereferenciaRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;
use App\Repositories\MetodopagoRepositoryEloquent;

class MotorpagosController extends Controller
{
    
	protected $diasferiadosdb;
    protected $limitereferenciadb;
    protected $bancodb;
    protected $cuentasbancodb;
    protected $metodopagodb;

    // In this method we ensure that the user is logged in using the middleware


    public function __construct( 
    	EgobiernodiasferiadosRepositoryEloquent $diasferiadosdb,
        limitereferenciaRepositoryEloquent $limitereferenciadb,
        BancoRepositoryEloquent $bancodb,
        MetodopagoRepositoryEloquent $metodopagodb,
        CuentasbancoRepositoryEloquent $cuentasbancodb
     )
    {
        $this->middleware('auth');

        $this->diasferiadosdb = $diasferiadosdb;
        $this->limitereferenciadb=$limitereferenciadb;
        $this->bancodb=$bancodb;
        $this->metodopagodb=$metodopagodb;
        $this->cuentasbancodb=$cuentasbancodb;
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
        $info = $this->bancodb->all();
        $responseinfo = array();

        foreach($info as $i)
        {
            $responseinfo []= array(
                "id"=>$i->id,
                "nombre" => $i->nombre  
            );
        }
    	return view('motorpagos/bancos',[ "saved_banco" => $responseinfo ]);
    }
    public function insertBanco(Request $request)
    {
        // identify the name of the file 
        $uploadedFile = $request->file('file');
        $fecha = $request->fechaIn; $nombre = $request->nombre;
        $status = $request->estatus; 
        // get the filename 
        $fileName = $uploadedFile->getClientOriginalName(); 
        // check if is a valid file
       // save the file in the storage folder
            try
            {
               $response = $uploadedFile->storeAs('Image_Banco/',$fileName);
                $info2 = $this->bancodb->create(['nombre' => $nombre,'url_logo' => 'Image_Banco/'.$fileName,'status' => $status,'created_at'=>$fecha,'updated_at'=>$fecha] ); 
        
            }catch( \Exception $e ){
                dd($e->getMessage());
                Log::info2('Error Method diasferiados: '.$e->getMessage());
            }
            # return to the view with the status file uploaded
           
        
        $info = $this->bancodb->all();
        $responseinfo = array();

        foreach($info as $i)
        {
            $responseinfo []= array(
                "id"=>$i->id,
                "nombre" => $i->nombre  
            );
        }
        return json_encode($responseinfo);

    }
     public function findBanco(Request $request)
    {

        $id=$request->id;
        $response = array();  
        $info = $this->bancodb->findWhere(['id' => $id]);
        foreach($info as $i)
        {
            $response []= array(              
                "status" => $i->status,
            );
        }
        return json_encode($response);
        
    }
    public function findCuentasBanco(Request $request)
    {
        $metodpago;
        $id=$request->id;
        $response = array();  
        $info = $this->cuentasbancodb->findWhere(['banco_id' => $id]);
        foreach($info as $i)
        {
             $info2 = $this->metodopagodb->findWhere(['id' => $i->metodopago_id]);
             foreach($info2 as $ii)
                {
                    $metodpago=$ii->nombre;
                }
            $response []= array(              
                "id" => $i->id,
                "banco_id" => $i->banco_id,
                "metodopago" => $metodpago,               
                "beneficiario" => $i->beneficiario,
                 "status" => $i->status,  
                "monto_min" => $i->monto_min,
                "monto_max" => $i->monto_max
            );
        }
        return json_encode($response);
        
    }
     public function findCuenta_edit(Request $request)
    {       
        $id=$request->id;
        $response = array();  
        $info = $this->cuentasbancodb->findWhere(['id' => $id]);
        foreach($info as $i)
        {             
            $response []= array(              
                "id" => $i->id,
                "banco_id" => $i->banco_id,
                "metodopago" => $metodpago_id,               
                "beneficiario" => $i->beneficiario,
                "monto_min" => $i->monto_min,
                "monto_max" => $i->monto_max
            );
        }
        return json_encode($response);        
    }

    public function insertCuentasBanco(Request $request)
    {
        $banco_id=$request->banco_id;
        $metodopago=$request->metodopago;
        $beneficiario=$request->beneficiario;
        $monto_min=$request->monto_min;
        $monto_max=$request->monto_max;
        $fechaIn=$request->fechaIn;
   
        try{  
          $info = $this->cuentasbancodb->create(['banco_id' => $banco_id,'metodopago_id' => $metodopago,'beneficiario' => $beneficiario,'status'=>'1','monto_min'=>$monto_min,'monto_max'=>$monto_max,'created_at'=>$fechaIn,'updated_at'=>$fechaIn] );
        
        }catch( \Exception $e ){
            Log::info('Error Method insertCuentasBanco: '.$e->getMessage());
        }      
    }
    public function updateCuentasBanco(Request $request)
    {
        
        $metodopago=$request->metodopago;
        $beneficiario=$request->beneficiario;
        $monto_min=$request->monto_min;
        $monto_max=$request->monto_max;
        $fechaIn=$request->fechaIn;
   
        try{  
          $info = $this->cuentasbancodb->update('metodopago_id' => $metodopago,'beneficiario' => $beneficiario,'monto_min'=>$monto_min,'monto_max'=>$monto_max,'updated_at'=>$fechaIn],$id );
        
        }catch( \Exception $e ){
            Log::info('Error Method insertCuentasBanco: '.$e->getMessage());
        }      
    }
    public function findMetodopago()
    {
         $response = array();  
        $info = $this->metodopagodb->all();
        foreach($info as $i)
        {
            $response []= array(              
                "id" => $i->id,
                "nombre" => $i->nombre,
            );
        }
        return json_encode($response);
    }
    public function DesactivaCuentaBanco(Request $request)
    {
        $response="false";
        try
        {   
            $id = $request->id;
            $status = $request->status;
            $info2 = $this->cuentasbancodb->update(['status' => $status],$id);
            $response="true";
        }catch( \Exception $e ){
            Log::info2('Error Method limitereferencia: '.$e->getMessage());
            $response="false";
        }
        //return view('motorpagos/diasferiados', [ "saved_days" => $response ]);

        return $response;
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
    }

    public function deleteLimiteReferencia(Request $request) 
    {
        try
        {
            $id = $request->id;
            $info2 = $this->limitereferenciadb->deleteWhere([
                "id" => $id
            ]);
            
        }catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        }
        $info = $this->limitereferenciadb->all();
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
        return json_encode($response);
        //return view('motorpagos/diasferiados', [ "saved_days" => $response ]);
    }
    public function insertLimiteReferencia(Request $request)
    {
        $response = array();
        try
        {            
            $descripcion = $request->descripcion;
            $periodicidad = $request->periodicidad;
            $vencimiento = $request->vencimiento;           
            $fecha = $request->fecha;           
            $info2 = $this->limitereferenciadb->create(['descripcion' => $descripcion,'periodicidad' => $periodicidad,'vencimiento' => $vencimiento,'created_at' => $fecha,'updated_at' => $fecha] );
            
        }catch( \Exception $e ){
            Log::info2('Error Method limitereferencia: '.$e->getMessage());
        }
        
        $info = $this->limitereferenciadb->all();            

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
        //return view('motorpagos/diasferiados', [ "saved_days" => $response ]);

        return json_encode($response);
    }
     public function updateLimiteReferencia(Request $request)
    {
        $response = array();
        try
        {   $id = $request->id;          
            $descripcion = $request->descripcion;
            $periodicidad = $request->periodicidad;
            $vencimiento = $request->vencimiento;           
            $fecha = $request->fecha;           
                      
            $info2 = $this->limitereferenciadb->update(['descripcion' => $descripcion,'periodicidad' => $periodicidad,'vencimiento' => $vencimiento,'updated_at' => $fecha],$id);
            
        }catch( \Exception $e ){
            Log::info2('Error Method limitereferencia: '.$e->getMessage());
        }
        
        $info = $this->limitereferenciadb->all();            

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
        //return view('motorpagos/diasferiados', [ "saved_days" => $response ]);

        return json_encode($response);
    }
    public function FindLimiteReferencia(Request $request)
    {
        $id=$request->id;
        $response = array();  
        $info = $this->limitereferenciadb->findWhere(['id' => $id]);            

        foreach($info as $i)
        {
            $response []= array(
               "id" => $i->id,
                "descripcion" => $i->descripcion,
                "periodicidad" => $i->periodicidad,
                "vencimiento" => $i->vencimiento
                
            );
        }
        //return view('motorpagos/diasferiados', [ "saved_days" => $response ]);

        return json_encode($response);
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
