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
use App\Repositories\TiporeferenciaRepositoryEloquent;
use App\Repositories\EgobiernostatusRepositoryEloquent;
use App\Repositories\EgobiernotransaccionesRepositoryEloquent;
use App\Repositories\TransaccionesRepositoryEloquent;
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\ClasificadorRepositoryEloquent;


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
    protected $tiporeferenciadb;
    protected $statusdb;
    protected $transaccionesdb;
    protected $oper_transaccionesdb;
    protected $partidasdb;
    protected $clasificadordb;
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
        EntidadtramiteRepositoryEloquent $entidadtramitedb,
        TiporeferenciaRepositoryEloquent $tiporeferenciadb,
        EgobiernostatusRepositoryEloquent $statusdb,
        EgobiernotransaccionesRepositoryEloquent $transaccionesdb,
        TransaccionesRepositoryEloquent $oper_transaccionesdb,
        EgobiernopartidasRepositoryEloquent $partidasdb,
        ClasificadorRepositoryEloquent $clasificadordb

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
        $this->tiporeferenciadb=$tiporeferenciadb;
        $this->statusdb=$statusdb;
        $this->transaccionesdb=$transaccionesdb;
        $this->oper_transaccionesdb=$oper_transaccionesdb;
        $this->partidasdb=$partidasdb;
        $this->clasificadordb=$clasificadordb;
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
         $imageData = base64_encode(file_get_contents($uploadedFile->getRealPath()));
        // $string = implode(array_map("string", $imageData));
        // check if is a valid file
       // save the file in the storage folder
        try
            { 
                
               $response = $uploadedFile->storeAs('Image_Banco/',$fileName);
                $info2 = $this->bancodb->create(['nombre' => $nombre,'imagen'=>$imageData,'url_logo' => 'Image_Banco/'.$fileName,'status' => $status,'created_at'=>$fecha,'updated_at'=>$fecha] ); 
               
        
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
       
        $info = $this->tiposerviciodb->all();
        foreach($info as $i)
        {
            $response []= array(
               "id" => $i->Tipo_Code,
                "nombre" => $i->Tipo_Descripcion,
                "Origen_URL" => $i->Origen_URL,
                "GpoTrans_Num" => $i->GpoTrans_Num,
                "id_gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia_id" => $i->tiporeferencia_id,
                "limitereferencia_id" => $i->limitereferencia_id
            );
        }

        return json_encode($response);
        
    }
     public function findTipoServicioAllWhere()
    {       
        $responseentidad = array();  
        $entidadtramite=$this->entidadtramitedb->all();
         foreach($entidadtramite as $ii)
        {
            $responseentidad []= array(
                $ii->tipo_servicios_id
            );
        }
        $info = $this->tiposerviciodb->findWhereNotIn('Tipo_Code',$responseentidad);
        foreach($info as $i)
        {
            $response []= array(
               "id" => $i->Tipo_Code,
                "nombre" => $i->Tipo_Descripcion,
                "Origen_URL" => $i->Origen_URL,
                "GpoTrans_Num" => $i->GpoTrans_Num,
                "id_gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia_id" => $i->tiporeferencia_id,
                "limitereferencia_id" => $i->limitereferencia_id
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
            $buscapagotramite=$this->pagotramitedb->findWhere(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$Id_tiposervicio]);
            if($buscapagotramite->count()==0){
                $info = $this->pagotramitedb->create(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$Id_tiposervicio,'descripcion'=>'----','fecha_inicio'=>'0000-00-00 00:00:00','fecha_fin'=>'0000-00-00 00:00:00','created_at'=>$date,'updated_at'=>$date]);
                $response="true";
            }else{
                $response="false";
            }
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
                "nombre" =>$i->nombre,
                "clave"=>$i->clave
                );
            }
       return json_encode($response);
    }
     public function findEntidadAll(Request $request)
    {   
        $id=$request->id;    
        $response = array();  
        $info = $this->entidadtramitedb->findWhere(['entidad_id'=>$id]);
        foreach($info as $i)
        {
            $findServicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$i->tipo_servicios_id]);
           
           foreach($findServicio as $ii)
            { 
                $response []= array(
                "id"=>$ii->Tipo_Code,              
                "nombre" => $ii->Tipo_Descripcion
                );
            }
        }
        
        return json_encode($response);
        
    }

     public function insertentidad(Request $request)
    {
        $nombre=$request->nombre;

        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');        
        $clave;
        $response = "false";
        $variable=true;
        while ($variable) {
            $clave=str_random(40);
            $entidadFind=$this->entidaddb->findWhere(['clave'=>$clave]);
            if($entidadFind->count() == 0)
            {
                $variable=false;
            }
        }  
        try{   
       $info = $this->entidaddb->create(['nombre'=>$nombre,'clave'=>$clave,'created_at'=>$date,'updated_at'=>$date]);
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
        
        //log::info(gettype($checkedsAll));
        //try{
            foreach($checkedsAll as $i) 
            {             
                //log::info($i);
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
    public function updateTipoServicioArray(Request $request)
    {
        
        $id=$request->id;
        $tiporeferencia=$request->tiporeferencia;
        $limitereferencia=$request->limitereferencia;
         Log::info($id);   
        $response = "false";
        try{ 
        foreach ($id as $i) {         
            $info=$this->tiposerviciodb->updateMenuByName(['tiporeferencia_id'=>$tiporeferencia,'limitereferencia_id'=>$limitereferencia],['Tipo_Code'=>$i]);
         } 
            $response="true";
        }catch( \Exception $e ){
            Log::info('Error Method updateTipoServicioArray: '.$e->getMessage());
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
   
    /* Modulo Tipo Servicio */
    /*  */
    /*  */
    /*  */

    public function tiposervicio()
    {
        $info=$this->tiposerviciodb->all();
        $response = array();
        $limitereferencia= "";
        $tiporeferencia="";
        $nombreentidad="";
        foreach ($info as $i) 
        {
            $infotiporeferencia=$this->tiporeferenciadb->findWhere(['id'=>$i->tiporeferencia_id]);
             if($infotiporeferencia->count() == 0)
            {
                 $tiporeferencia="Sin Registro";
            }
            else{
                foreach ($infotiporeferencia as $ii) 
                {
                   $tiporeferencia=$ii->fecha_condensada;
                }
            }
            $infolimitereferencia=$this->limitereferenciadb->findWhere(['id'=>$i->limitereferencia_id]);
             if($infolimitereferencia->count() == 0)
            {
                $limitereferencia="Sin Registro";
            }
            else{
                foreach ($infolimitereferencia as $iii) 
                {
                    $limitereferencia=$iii->descripcion." ".$iii->periodicidad." ".$iii->vencimiento;
                }
            }
            $infoentidadtramite=$this->entidadtramitedb->findWhere(['tipo_servicios_id'=>$i->Tipo_Code]);
             if($infoentidadtramite->count() == 0)
            {
                 $nombreentidad="Sin / Asignar";
            }
            else{
                foreach ($infoentidadtramite as $key) 
                {
                     $infoentidad=$this->entidaddb->findWhere(['id'=>$key->entidad_id]);
                      foreach ($infoentidad as $ent) 
                    {
                        $nombreentidad=$ent->nombre;
                    }
                }
            }
             $response []= array(
                "entidad"=>$nombreentidad,
               "Tipo_Code" => $i->Tipo_Code,
                "Tipo_Descripcion" => $i->Tipo_Descripcion,
                "Origen_URL" => $i->Origen_URL,
                "GpoTrans_Num" => $i->GpoTrans_Num,
                "id_gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia_id" => $tiporeferencia,
                "limitereferencia_id" => $limitereferencia
            );
        }


        return view('motorpagos/tiposervicio',['response'=>$response]);

    }

    public function findTipoServicioWhere(Request $request)
    {
       
        $info=$this->tiposerviciodb->all();
        $response = array();
        $limitereferencia;
        $tiporeferencia;
        $descripcion;
        $url;
        $gpoTrans;
        $id_gpm;
        $descripcion_gpm;
        $nombreentidad="";
        foreach ($info as $i) 
        {
           $infotiporeferencia=$this->tiporeferenciadb->findWhere(['id'=>$i->tiporeferencia_id]);
             if($infotiporeferencia->count() == 0)
            {
                 $tiporeferencia="Sin Registro";
            }
            else{
                foreach ($infotiporeferencia as $ii) 
                {
                   $tiporeferencia=$ii->fecha_condensada;
                }
            }
            $infolimitereferencia=$this->limitereferenciadb->findWhere(['id'=>$i->limitereferencia_id]);
             if($infolimitereferencia->count() == 0)
            {
                $limitereferencia="Sin Registro";
            }
            else{
                foreach ($infolimitereferencia as $iii) 
                {
                    $limitereferencia=$iii->descripcion." ".$iii->periodicidad." ".$iii->vencimiento;
                }
            }
            $infoentidadtramite=$this->entidadtramitedb->findWhere(['tipo_servicios_id'=>$i->Tipo_Code]);
             if($infoentidadtramite->count() == 0)
            {
                 $nombreentidad="Sin / Asignar";
            }
            else{
                foreach ($infoentidadtramite as $key) 
                {
                     $infoentidad=$this->entidaddb->findWhere(['id'=>$key->entidad_id]);
                      foreach ($infoentidad as $ent) 
                    {
                        $nombreentidad=$ent->nombre;
                    }
                }
            }
             $response []= array(
                "entidad"=>$nombreentidad,
               "id" => $i->Tipo_Code,
                "descripcion" => $i->Tipo_Descripcion,
                "origen" => $i->Origen_URL,
                "gpo" => $i->GpoTrans_Num,
                "id_gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia" => $tiporeferencia,
                "limitereferencia" => $limitereferencia
            );
        }

        return json_encode($response);

    }
    public function findTipoServicio_whereId(Request $request)
    {
         $id=$request->id;
        $info=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$id]);
        foreach ($info as $i) 
        {
             $response []= array(
               "Tipo_Code" => $i->Tipo_Code,
                "descripcion" => $i->Tipo_Descripcion,
                "origen" => $i->Origen_URL,
                "gpo" => $i->GpoTrans_Num,
                "gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia" => $i->tiporeferencia_id,
                "limitereferencia" => $i->limitereferencia_id
            );
        }
        return json_encode($response);
    }
    public function insertTipoServicio(Request $request)
    {
        $descripcion=$request->descripcion;
        $url=$request->url;
        $gpoTrans=$request->gpoTrans;
        $id_gpm=$request->id_gpm;
        $descripcion_gpm=$request->descripcion_gpm;
        $tiporeferencia=$request->tiporeferencia;
        $limitereferencia=$request->limitereferencia;
        $response="false";
       

             $info=$this->tiposerviciodb->create(['Tipo_Descripcion'=>$descripcion,'Origen_URL'=>$url,'GpoTrans_Num'=>$gpoTrans,'id_gpm'=>$id_gpm,'descripcion_gpm'=>$descripcion_gpm,'tiporeferencia_id'=>$tiporeferencia,'limitereferencia_id'=>$limitereferencia]);
             $response="true";
        
        return  $response;
    }
    public function updateTipoServicio(Request $request)
    {
        $descripcion=$request->descripcion;
        $url=$request->url;
        $gpoTrans=$request->gpoTrans;
        $id_gpm=$request->id_gpm;
        $descripcion_gpm=$request->descripcion_gpm;
        $tiporeferencia=$request->tiporeferencia;
        $limitereferencia=$request->limitereferencia;
        $id=$request->id;
        $response="false";
    
             $info=$this->tiposerviciodb->updateMenuByName(['Tipo_Descripcion'=>$descripcion,'Origen_URL'=>$url,'GpoTrans_Num'=>$gpoTrans,'id_gpm'=>$id_gpm,'descripcion_gpm'=>$descripcion_gpm,'tiporeferencia_id'=>$tiporeferencia,'limitereferencia_id'=>$limitereferencia],['Tipo_Code'=>$id]);
             $response="true";
      
        return  $response;
    }public function deleteTipoServicio(Request $request) 
    {
        $id=$request->id;
        $response="false";
        try
        {            
            $info2 = $this->tiposerviciodb->deleteWhere(['Tipo_Code'=>$id]);
            $response="true";
        }catch( \Exception $e ){
            Log::info('Error Method deleteTipoServicio: '.$e->getMessage());
            $response="false";
        }
        return $response;
    }
    public function limitereferenciaFindAll()
    {
       
        $response = array();
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
        return json_encode($response);
    }
    public function tiporeferenciaFindAll()
    {
       
        $response = array();
        $info = $this->tiporeferenciadb->all();
        foreach($info as $i)
        {
            $response []= array(
                "id" => $i->id,
                "fecha_condensada" => $i->fecha_condensada,
                "digito_verificador" => $i->digito_verificador,
                "longitud" => $i->longitud,
                "origen" => $i->origen,
                "dias_vigencia" => $i->dias_vigencia
            );
       }
        return json_encode($response);
    }

    /**----------------------------ESTATUS TRANSACCION---------------------------**/

      public function cambiarstatustransaccion()
    {
        return view('motorpagos/statustransaccion');
    }
    public function statusFindAll()
    {
       
        $response = array();
        $info = $this->statusdb->all();
        foreach($info as $i)
        {
            $response []= array(
                "id" => $i->Status,
                "nombre" => $i->Descripcion
                );
       }
        return json_encode($response);
    }
    public function transaccionesFindWhere(Request $request)
    {
       //egob_transaccion
        $folio=$request->folio;
        $response = array();
        $find_egob = $this->transaccionesdb->findWhere(['idTrans'=>$folio]);
        $Status;
        $bd_tabla;
        if($find_egob->count() >0)
        {
            $bd_tabla="egob_transaccion";
            foreach($find_egob as $i)
            {
            $infoStatus = $this->statusdb->findWhere(['Status'=>$i->Status]);
                foreach($infoStatus as $ii)
                {
                $Status=$ii->Descripcion;
                }
                if($infoStatus->count() == 0)
                {
                $Status="Sin Estatus";
                }
                $response []= array(
                "id" => $i->idTrans,
                "referencia" =>$i->idTrans,
                "status" => $Status,
                "importe" => $i->TotalTramite,
                "fecha" => $i->fechatramite." ".$i->HoraTramite,
                "bd_tb" =>$bd_tabla
                );
            }
        }
        $find_oper_referencia = $this->oper_transaccionesdb->findWhere(['referencia'=>$folio]);
        if($find_oper_referencia->count() >0)
        {
            $bd_tabla="oper_transaccion";
            foreach ($find_oper_referencia as $i)
            { 
            $infoStatus = $this->statusdb->findWhere(['Status'=>$i->estatus]);
            foreach($infoStatus as $ii)
            {
                $Status=$ii->Descripcion;
            }
            if($infoStatus->count() == 0)
            {
                $Status="Sin Estatus";
            }
               $response []= array(
                "id" => $i->id_transaccion_motor,
                "referencia"=>$i->referencia,
                "status"=>$Status,
                "importe"=>$i->importe_transaccion,
                "fecha"=>$i->fecha_transaccion,
                "bd_tb" =>$bd_tabla
                
                );
            }
        }
         $find_oper_idmotor = $this->oper_transaccionesdb->findWhere(['id_transaccion_motor'=>$folio]);
        if($find_oper_idmotor->count() >0)
        {
            $bd_tabla="oper_transaccion";
            foreach ($find_oper_idmotor as $i)
            { 
            $infoStatus = $this->statusdb->findWhere(['Status'=>$i->estatus]);
            foreach($infoStatus as $ii)
            {
                $Status=$ii->Descripcion;
            }
            if($infoStatus->count() == 0)
            {
                $Status="Sin Estatus";
            }
               $response []= array(
                "id" => $i->id_transaccion_motor,
                "referencia"=>$i->id_transaccion_motor,
                "status"=>$Status,
                "importe"=>$i->importe_transaccion,
                "fecha"=>$i->fecha_transaccion,
                "bd_tb" =>$bd_tabla
                
                );
            }
        }
        $find_oper_idtransaccion = $this->oper_transaccionesdb->findWhere(['id_transaccion'=>$folio]);
        if($find_oper_idtransaccion->count() >0)
        {
            $bd_tabla="oper_transaccion";
            foreach ($find_oper_idtransaccion as $i)
            { 
            $infoStatus = $this->statusdb->findWhere(['Status'=>$i->estatus]);
            foreach($infoStatus as $ii)
            {
                $Status=$ii->Descripcion;
            }
            if($infoStatus->count() == 0)
            {
                $Status="Sin Estatus";
            }
               $response []= array(
                "id" => $i->id_transaccion_motor,
                "referencia"=>$i->id_transaccion,
                "status"=>$Status,
                "importe"=>$i->importe_transaccion,
                "fecha"=>$i->fecha_transaccion,
                "bd_tb" =>$bd_tabla
                
                );
        
            }    
        }
        return json_encode($response);
    }
    public function transaccionesFindWhereStatus(Request $request)
    {
       
        $folio=$request->folio;
        $response = array();
        $info = $this->transaccionesdb->findWhere(['idTrans'=>$folio]);
        $Status;
        foreach($info as $i)
        {            
            $response []= array(
                "status" => $i->Status
                
            );
       }
        return json_encode($response);
    }
    public function updateTransaccionStatus(Request $request)
    {
        $folio=$request->folio;
        $status=$request->status;      
        $response = "false";
        try{   
         $info = $this->transaccionesdb->updateStatus(['Status'=>$status],['idTrans'=>$folio]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
    public function transaccionesFindWhereStatus_oper(Request $request)
    {
        $id=$request->id;       
        $response=array();
       
         $info = $this->oper_transaccionesdb->findWhere(['id_transaccion_motor'=>$id]);
        foreach ($info as $i)
        {                 
               $response []= array(
                "id" => $i->id_transaccion_motor,                
                "status"=>$i->estatus
                
            );
        }
        
        return json_encode($response);
    }
    public function transaccionesFindWhereReferencia_oper(Request $request)
    {
        $folio=$request->folio;       
        $response=array();
        $Status;
         $info = $this->oper_transaccionesdb->findWhere(['referencia'=>$folio]);
        foreach ($info as $i)
        { 
                $infoStatus = $this->statusdb->findWhere(['Status'=>$i->estatus]);
            foreach($infoStatus as $ii)
            {
                $Status=$ii->Descripcion;
            }
            if($infoStatus->count() == 0)
            {
                $Status="Sin Estatus";
            }
               $response []= array(
                "id" => $i->id_transaccion_motor,
                "referencia"=>$i->referencia,
                "status"=>$Status,
                "importe"=>$i->importe_transaccion,
                "fecha"=>$i->fecha_transaccion
                
            );
        }
        
        return json_encode($response);
    }
    public function updateTransaccionStatus_oper(Request $request)
    {
        $folio=$request->folio;
        $status=$request->status;      
        $response = "false";
        try{   
         $info = $this->oper_transaccionesdb->updateTransacciones(['estatus'=>$status],['id_transaccion_motor'=>$folio]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
    /************ DETALLE PAGO TRMAITE *************/
    public function detallepagotramite()
    {
        return view('motorpagos/detallepagotramite');
    }
    public function findCuentasBancoAll(Request $request)
    {
        $Id_entidad=$request->Id_entidad;
        $servicio;
        $idpagotramite;
        $nombrebanco;
        $metodopago;
        $response=array(); 
        $oper_entidadtramite=$this->entidadtramitedb->findWhere(['entidad_id'=>$Id_entidad]);
        foreach ($oper_entidadtramite as $i) {
           
            $tiposervicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$i->tipo_servicios_id]);
            foreach ($tiposervicio as $ii) {
               $servicio=$ii->Tipo_Descripcion;
            }
            $oper_pagotramite=$this->pagotramitedb->findWhere(['tramite_id'=>$i->tipo_servicios_id]);
            foreach ($oper_pagotramite as $key) {
                 $idpagotramite=$key->id;
                $oper_cuentasbanco=$this->cuentasbancodb->findWhere(['id'=>$key->cuentasbanco_id]);

                foreach ($oper_cuentasbanco as $cuenta) {
                    $oper_banco=$this->bancodb->findWhere(['id'=>$cuenta->banco_id]);
                        foreach ($oper_banco as $ban) {
                        $nombrebanco=$ban->nombre;
                        }
                    $oper_metodopago=$this->metodopagodb->findWhere(['id'=>$cuenta->metodopago_id]);
                        foreach ($oper_metodopago as $metodo) {
                          $metodopago=$metodo->nombre;
                        }
                    $response []= array(
                    "id"=> $idpagotramite,                    
                    "servicio" => $servicio,
                    "banco"=>$nombrebanco,
                    "beneficiario"=>$cuenta->beneficiario,
                    "metodopago"=>$metodopago,
                    "monto_max"=>$cuenta->monto_max,
                    "monto_min"=>$cuenta->monto_min                
                    );
                }                
            }            
        }
        return json_encode($response);
    }

    /*********************PARTIDAS******************///
    public function partidas()
    {
        return view('motorpagos/partidas');
    }
    public function partidasInsert(Request $request)
    {
        $idpartida=$request->idpartida;
        $idservicio=$request->idservicio;
        $descripcion=$request->descripcion;
        $response = "false";
        try{  
        $findpartida=$this->partidasdb->findWhere(['id_partida'=>$idpartida]);
            if($findpartida->count()==0)
            {
            $insertpartidas=$this->partidasdb->create(['id_servicio'=>$idservicio,'id_partida'=>$idpartida,'descripcion'=>$descripcion]);
            $response = "true";
            }else{
                $response = "false";
            }
        } catch( \Exception $e ){
            Log::info('Error Method partidasInsert: '.$e->getMessage());
        $response = "false";
        }
       return $response;

    }
    public function partidasFindAll()
    {   
        $response= array();
        $servicio;
        $partidasfind=$this->partidasdb->all();
        foreach ($partidasfind as $part) {
            $serviciofind=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$part->id_servicio]);
            foreach ($serviciofind as $serv) {
                $servicio=$serv->Tipo_Descripcion;
            }
            $response []= array(
                'id_partida' => $part->id_partida, 
                'id_servicio' => $part->id_servicio, 
                'servicio' => $servicio, 
                'descripcion' => $part->descripcion 

            );
        }
        return json_encode($response);
    }
    public function partidasFindWhere(Request $request)
    {
        $response= array();
        $idpartida=$request->idpartida;
         $findpartida=$this->partidasdb->findWhere(['id_partida'=>$idpartida]);
         foreach ($findpartida as $part) {
            $response []= array(
                'id_partida' => $part->id_partida, 
                'id_servicio' => $part->id_servicio,
                'descripcion' => $part->descripcion 

            );
         }
         return json_encode($response);
    }
    public  function partidasUpdate(Request $request)
    {
        $idpartida=$request->idpartida;
        $idservicio=$request->idservicio;
        $descripcion=$request->descripcion;
        $response = "false";
        try{ 

        $updatepartidas=$this->partidasdb->updatePartida(['id_servicio'=>$idservicio,'descripcion'=>$descripcion],['id_partida'=>$idpartida]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method partidasUpdate: '.$e->getMessage());
            $response = "false";
        }
       return $response;
    }
    public function partidasDeleted(Request $request)
    {
         $idpartida=$request->idpartida;
         $response = "false";
        try{   
        $deletedpartidas=$this->partidasdb->deleteWhere(['id_partida'=>$idpartida]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method partidasDeleted: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
    public function clasificador()
    {
        return view('motorpagos/clasificador');
    } 
    public function clasificadorInsert(Request $request)
    {
       
        $identidad=$request->identidad;
        $descripcion=$request->descripcion;
        $response = "false";
        try{
            $insertclasificador=$this->clasificadordb->create(['entidad_id'=>$identidad,'descripcion'=>$descripcion]);
            $response = "true";
            
        } catch( \Exception $e ){
            Log::info('Error Method clasificadorInsert: '.$e->getMessage());
        $response = "false";
        }
       return $response;

    }
    public function clasificadorFindAll()
    {   
        $response= array();
        $entidad;
        $clasificadorfind=$this->clasificadordb->all();
        foreach ($clasificadorfind as $clas) {
            $entidadfind=$this->entidaddb->findWhere(['id'=>$clas->entidad_id]);
            foreach ($entidadfind as $enti) {
                $entidad=$enti->nombre;
            }
            $response []= array(
                'id' => $clas->id, 
                'entidad' => $entidad, 
                'descripcion' => $clas->descripcion 

            );
        }
        return json_encode($response);
    }
    public function clasificadorFindWhere(Request $request)
    {
        $response= array();
        $id=$request->id;
         $findclasificador=$this->clasificadordb->findWhere(['id'=>$id]);
         foreach ($findclasificador as $enti) {
            $response []= array(
                'id' => $enti->id, 
                'entidad_id' => $enti->entidad_id,
                'descripcion' => $enti->descripcion 

            );
         }
         return json_encode($response);
    }
    public  function clasificadorUpdate(Request $request)
    {
        $identidad=$request->identidad;
        $id=$request->id;
        $descripcion=$request->descripcion;
        $response = "false";
        try{ 

        $updateclasificador=$this->clasificadordb->update(['entidad_id'=>$identidad,'descripcion'=>$descripcion],$id);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method clasificadorUpdate: '.$e->getMessage());
            $response = "false";
        }
       return $response;
    }
    public function clasificadorDeleted(Request $request)
    {
         $id=$request->id;
         $response = "false";
        try{   
        $deletedclasificador=$this->clasificadordb->deleteWhere(['id'=>$id]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method clasificadorDeleted: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
    public function tiporeferencia()
    {
        return view('motorpagos/tiporeferencia');
    }
    public function tiporeferenciaInsert(Request $request)
    {
       
        $descripcion=$request->descripcion;
        $origen=$request->origen;
        $diasvigencia=$request->diasvigencia;
        $digitoverificador=$request->digitoverificador;
        $longitud=$request->longitud;
        $response = "false";
        try{
            $inserttiporeferencia=$this->tiporeferenciadb->create(['fecha_condensada'=>$descripcion,'digito_verificador'=>$digitoverificador,'longitud'=>$longitud,'origen'=>$origen,'dias_vigencia'=>$diasvigencia]);
            $response = "true";
            
        } catch( \Exception $e ){
            Log::info('Error Method tiporeferenciaInsert: '.$e->getMessage());
        $response = "false";
        }
       return $response;

    }
    
    public function tiporeferenciaFindWhere(Request $request)
    {
        $response= array();
        $id=$request->id;
         $findtiporeferencia=$this->tiporeferenciadb->findWhere(['id'=>$id]);
         foreach ($findtiporeferencia as $tipo) {
            $response []= array(
                'id' => $tipo->id, 
                'fecha_condensada' => $tipo->fecha_condensada,
                'digito_verificador' => $tipo->digito_verificador,
                'longitud' => $tipo->longitud,
                'origen' => $tipo->origen,
                'dias_vigencia' => $tipo->dias_vigencia 

            );
         }
         return json_encode($response);
    }
    public  function tiporeferenciaUpdate(Request $request)
    {       
        $id=$request->id;  
        $descripcion=$request->descripcion;
        $origen=$request->origen;
        $diasvigencia=$request->diasvigencia;
        $digitoverificador=$request->digitoverificador;
        $longitud=$request->longitud;
        $response = "false";
        try{ 

        $updatetiporeferencia=$this->tiporeferenciadb->update(['fecha_condensada'=>$descripcion,'digito_verificador'=>$digitoverificador,'longitud'=>$longitud,'origen'=>$origen,'dias_vigencia'=>$diasvigencia],$id);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method clasificadorUpdate: '.$e->getMessage());
            $response = "false";
        }
       return $response;
    }
    public function tiporeferenciaDeleted(Request $request)
    {
         $id=$request->id;
         $response = "false";
        try{   
        $deletedtiporeferencia=$this->tiporeferenciadb->deleteWhere(['id'=>$id]);
         $response = "true";
        } catch( \Exception $e ){
            Log::info('Error Method clasificadorDeleted: '.$e->getMessage());
        $response = "false";
        }
       return $response;
    }
    public function serviciosFindWhereID(Request $request)
    {
        $id_entidad=$request->id_entidad;
        $response=array();
         $infoentidadtramite=$this->entidadtramitedb->findWhere(['entidad_id'=>$id_entidad]);
             if($infoentidadtramite->count()> 0)
            {
                 foreach ($infoentidadtramite as $key) 
                {
                     $tiposervicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$key->tipo_servicios_id]);
                      foreach ($tiposervicio as $tipo) 
                    {                        
                        $response []= array(
                        "id" => $tipo->Tipo_Code,
                        "descripcion" => $tipo->Tipo_Descripcion 
                        );
                    }
                }
            }  
        return json_encode($response);
    }

}
