<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Repositories\EgobiernodiasferiadosRepositoryEloquent;
use App\Repositories\LimitereferenciaRepositoryEloquent;
use App\Repositories\BancoRepositoryEloquent;
use App\Repositories\CuentasbancoRepositoryEloquent;
use App\Repositories\MetodopagoRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\PagotramiteRepositoryEloquent;
use App\Repositories\EntidadRepositoryEloquent;
use App\Repositories\EntidadtramiteRepositoryEloquent;


class MotorpagosController extends Controller
{
    
	protected $diasferiadosdb;
    protected $limitereferenciadb;
    protected $bancodb;
    protected $cuentasbancodb;
    protected $metodopagodb;
    protected $tiposerviciodb;
    protected $pagotramitedb;
    protected $entidaddb;
    protected $entidadtramitedb;
    // In this method we ensure that the user is logged in using the middleware


    public function __construct( 
    	EgobiernodiasferiadosRepositoryEloquent $diasferiadosdb,
        limitereferenciaRepositoryEloquent $limitereferenciadb,
        BancoRepositoryEloquent $bancodb,
        MetodopagoRepositoryEloquent $metodopagodb,
        CuentasbancoRepositoryEloquent $cuentasbancodb,
        EgobiernotiposerviciosRepositoryEloquent $tiposerviciodb,
        PagotramiteRepositoryEloquent $pagotramitedb,
        EntidadRepositoryEloquent $entidaddb,
        EntidadtramiteRepositoryEloquent $entidadtramitedb
     )
    {
        $this->middleware('auth');

        $this->diasferiadosdb = $diasferiadosdb;
        $this->limitereferenciadb=$limitereferenciadb;
        $this->bancodb=$bancodb;
        $this->metodopagodb=$metodopagodb;
        $this->cuentasbancodb=$cuentasbancodb;
        $this->tiposerviciodb=$tiposerviciodb;
        $this->pagotramitedb=$pagotramitedb;
        $this->entidaddb=$entidaddb;
        $this->entidadtramitedb=$entidadtramitedb;

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
        $fecha = $request->fechaIn; 
        $nombre = $request->nombre;
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
                "status" => $i->status
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
    public function findCuentasBancoWhere(Request $request)
    {

        $id=$request->id;
        $metodopago=$request->metodopago;
        $response = array();  
        $info = $this->cuentasbancodb->findWhere(['banco_id' => $id,'metodopago_id'=>$metodopago]);
        foreach($info as $i)
        {             
            $response []= array(              
                "id" => $i->id,
                "banco_id" => $i->banco_id,
                "metodopago" => $i->metodopago_id,               
                "beneficiario" => $i->beneficiario, 
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
                "banco_id" => $i->banco_id,
                "metodopago_id" => $i->metodopago_id,               
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
        $response='false';
        $id=$request->id;
        $metodopago=$request->metodopago;
        $beneficiario=$request->beneficiario;
        $monto_min=$request->monto_min;
        $monto_max=$request->monto_max;
        $fechaIn=$request->fechaIn;
   
        try{  

          $info = $this->cuentasbancodb->update(
            [
                'metodopago_id' => $metodopago,
                'beneficiario' => $beneficiario,
                'monto_min'=>$monto_min,
                'monto_max'=>$monto_max,
                'updated_at'=>$fechaIn
            ],$id );
        $response="true";
        
        }catch( \Exception $e ){
            Log::info('Error Method insertCuentasBanco: '.$e->getMessage());
            $response='false';
        }    
        return $response;
    }
    public function findMetodopago()
    {
         $response = array();  
        $info = $this->metodopagodb->all();
        foreach($info as $i)
        {
            $response []= array(              
                "id" => $i->id,
                "nombre" => $i->nombre
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
    public function DesactivaBanco(Request $request)
    {
      $response = array();
        try
        {   
            $id = $request->id;
            $status =$request->status;
            $info2 = $this->bancodb->update(['status' => $status],$id);
            
        }catch( \Exception $e ){
            Log::info2('Error Method limitereferencia: '.$e->getMessage());            
        }
        $info = $this->bancodb->findWhere(['id' => $id]);
        foreach($info as $i)
        {             
            $response []= array( 
                "status" => $i->status
            );
        }
        return json_encode($response);
    }
    /*find todos los bancos agregados*/
    public function findBancoAll()
    {

       
        $response = array();  
        $info = $this->bancodb->findWhere(['status' => '1']);
        foreach($info as $i)
        {
            $response []= array(
                "id"=>$i->id,              
                "nombre" => $i->nombre
            );
        }
        return json_encode($response);
        
    }
    public function findBancoAllWhere()
    {
        $response = array();  
        $info = $this->bancodb->all();
        foreach($info as $i)
        {
            $response []= array(
                "id"=>$i->id,              
                "nombre" => $i->nombre
            );
        }
        return json_encode($response);
    }

    /* tipo servicio*/

    public function findTipoServicioAll()
    {       
        $response = array();  
        $info = $this->tiposerviciodb->all();
        foreach($info as $i)
        {
            $response []= array(
                "id"=>$i->Tipo_Code,              
                "nombre" => $i->Tipo_Descripcion
            );
        }
        return json_encode($response);
        
    }

    public function findTipoServicio(Request $request)
    {
        $idBanco=$request->idBanco;
        $idTiposervicio=$request->idTiposervicio;
        /*atributos cuentas Banco*/        
        $beneficiario;
        $metodopago;
        $monto_min;
        $montop_max;
        /*end*/
        $responseTipoServicio = array();        
        $infoCuentasBanco=$this->cuentasbancodb->findWhere(['banco_id'=>$idBanco]);
        foreach($infoCuentasBanco as $i)
        {
            $info2 = $this->metodopagodb->findWhere(['id' => $i->metodopago_id]);
             foreach($info2 as $iii)
                {
                    $metodopago=$iii->nombre;
                }
                $beneficiario=$i->beneficiario;
                $monto_min=$i->moto_min;
                $monto_max=$i->monto_max;

            $infoTipoServicio = $this->pagotramitedb->findWhere(['cuentasbanco_id'=>$i->id,'tramite_id'=>$idTiposervicio]);
             foreach($infoTipoServicio as $ii)
            {
                $responseTipoServicio []= array(
                "id"=>$ii->id,              
                "metodopago" => $metodopago,
                "beneficiario" => $i->beneficiario,
                "monto_min" => $i->monto_min,
                "monto_max" => $i->monto_max

                );
            }
            
        }
        return json_encode($responseTipoServicio);
    }

    public function insertPagoTramite(Request $request)
    {
        $Id_tiposervicio=$request->Id_tiposervicio;
        $Id_Banco=$request->Id_Banco;
        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');
        $response = "false";
        try{  
        $info = $this->pagotramitedb->create(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$Id_tiposervicio,'descripcion'=>'----','fecha_inicio'=>'0000-00-00 00:00:00','fecha_fin'=>'0000-00-00 00:00:00','created_at'=>$date,'updated_at'=>$date]);
            $response="true";
            }
            catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
            $response="false";            
        }
        return $response;
    }
    public function findPagoTramite(Request $request)
    {
        $id=$request->id;
        $response = array();   
        $info = $this->pagotramitedb->findWhere(['id'=>$id]);

           foreach($info as $i)
            {
                $date = Carbon::parse($i->fecha_inicio)->format('d/m/Y');
                $date2 = Carbon::parse($i->fecha_fin)->format('d/m/Y');
                $response []= array(              
                "descripcion" => $i->descripcion,
                "fecha_inicio" =>$date,
                "fecha_fin" => $date2

                );
            } 

       return json_encode($response);
    }
     public function findPagoTramiteWhere(Request $request)
    {
        $id=$request->id;
        $response = array();   
        $info = $this->pagotramitedb->findWhere(['id'=>$id]);

           foreach($info as $i)
            {
                $date = Carbon::parse($i->fecha_inicio)->format('d/m/Y');
                $date2 = Carbon::parse($i->fecha_fin)->format('d/m/Y');
                $response []= array(              
                "descripcion" => $i->descripcion,
                "fecha_inicio" =>$date,
                "fecha_fin" => $date2

                );
            } 

       return json_encode($response);
    }
    public function updatePagoTramite(Request $request)
    {
        $id=$request->id;
        $descripcion=$request->descripcion;
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $response = "false";
        $date = Carbon::parse($fecha_inicio)->format('Y-m-d');
        $date2 = Carbon::parse($fecha_fin)->format('Y-m-d');
        try{   
        $info = $this->pagotramitedb->update(['descripcion'=>$descripcion,'fecha_inicio'=>$date,'fecha_fin'=>$date2],$id);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }

       return $response;
    }
     public function deletePagoTramite(Request $request)
    {
        $id=$request->id;
        $response = "false";
        try{   
        $info = $this->pagotramitedb->deleteWhere(['id'=>$id]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }

       return $response;
    }



    /*ENTIDAD*/
    public function entidadView()
    {

        $response = array();   
        $info = $this->entidaddb->all();

           foreach($info as $i)
            {                
                $response []= array(              
                "id" => $i->id,
                "nombre" =>$i->nombre
                );
            } 

        return view('motorpagos/entidad',["viewEntidad"=>$response]);
         //return view('motorpagos/entidad',[ "viewEntidad" => $response ]);

    }
    public function findentidad()
    {

        $response = array();   
        $info = $this->entidaddb->all();

           foreach($info as $i)
            {                
                $response []= array(              
                "id" => $i->id,
                "nombre" =>$i->nombre
                );
            }
       return json_encode($response);
    }
    public function findentidadWhere(Request $request)
    {
        $id=$request->id;
        $response = array();   
        $info = $this->entidaddb->findWhere(['id'=>$id]);

           foreach($info as $i)
            {                
                $response []= array(              
                "id" => $i->id,
                "nombre" =>$i->nombre
                );
            }
       return json_encode($response);
    }
     public function insertentidad(Request $request)
    {
        $nombre=$request->nombre;

        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');
        $response = "false";
        try{   
       $info = $this->entidaddb->create(['nombre'=>$nombre,'created_at'=>$date,'updated_at'=>$date]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
     public function updateentidad(Request $request)
    {
        $id=$request->id;
        $nombre=$request->nombre;        
        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');
        $response = "false";
        try{   
       $info = $this->entidaddb->update(['nombre'=>$nombre,'updated_at'=>$date],$id);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
     public function deleteentidad(Request $request)
    {
        $id=$request->id;
        $response = "false";
        try{   
       $info = $this->entidaddb->deleteWhere(['id'=>$id]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }

    /*- Entidad Tramite-----------------------------------**/

    public function entidadtramiteView()
    {

        return view('motorpagos/entidadtramite');
        //,["viewEntidad"=>$response]
    }
    public function findtramiteEntidad(Request $request)
    {
        $id=$request->id;
        $response = array();
        $TipoServicio;   
        $info = $this->entidadtramitedb->findWhere(['entidad_id'=>$id]);
           foreach($info as $i)
            {  
                $info2 = $this->tiposerviciodb->findWhere(['Tipo_Code'=>$i->tipo_servicios_id]);
                foreach($info2 as $ii)
                { 
                    $TipoServicio=$ii->Tipo_Descripcion;
                }
                $response []= array(              
                "id" => $i->id,
                "tiposervicio" =>$TipoServicio
                );
            }
       return json_encode($response);
    }
    public function insertentidadtramite(Request $request)
    {
    
        $checkedsAll =json_decode($request->checkedsAll);
        
        $Id_entidad=$request->Id_entidad;
        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');     
        $contador=0;
        
           log::info(gettype($checkedsAll));
        //try{
            foreach($checkedsAll as $i) 
            {             
                log::info($i);
                $info2 = $this->entidadtramitedb->findWhere(['entidad_id'=>$Id_entidad,'tipo_servicios_id'=>$i]);
                
                if($info2->count() == 0)
                {
                $info = $this->entidadtramitedb->create(['entidad_id'=>$Id_entidad,'tipo_servicios_id'=>$i,'created_at'=>$date,'updated_at'=>$date]);
                    $contador=$contador+1;
                }
            }
       

       // }
           // catch( \Exception $e ){
            //Log::info('Error Method limitereferencia: '.$e->getMessage());
           // $contador=0;            
        //}
        return $contador;

    }
     public function updateentidadtramite(Request $request)
    {
        $id=$request->id;
        $Id_tiposervicio=$request->Id_tiposervicio;
        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');
        $response = "false";
        try{  
        $info = $this->entidadtramitedb->update(['tipo_servicios_id'=>$Id_tiposervicio,'updated_at'=>$date],$id);
            $response="true";
            }
            catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
            $response="false";            
        }
        return $response;

    }
    public function deleteentidadtramite(Request $request)
    {
        $id=$request->id;
        $response = "false";
        try{   
       $info = $this->entidadtramitedb->deleteWhere(['id'=>$id]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
     public function findtramiteEntidadWhere(Request $request)
    {
        $id=$request->id;
        $response = array();
        $info = $this->entidadtramitedb->findWhere(['entidad_id'=>$id]);
           foreach($info as $i)
            {  
                $response []= array(              
                "id" => $i->id,
                "tipo_servicios_id" =>$i->tipo_servicios_id
                );
            }
       return json_encode($response);
    }
    public function findtramiteEntidadWhereID(Request $request)
    {
        $id=$request->id;
        $response = array();
        $info = $this->entidadtramitedb->findWhere(['id'=>$id]);
           foreach($info as $i)
            {  
                $response []= array(              
                "id" => $i->id,
                "tipo_servicios_id" =>$i->tipo_servicios_id
                );
            }
       return json_encode($response);
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
