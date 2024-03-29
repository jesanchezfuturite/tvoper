<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use File;
use Illuminate\Support\Str;
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
use App\Repositories\EgobiernotipopagoRepositoryEloquent;
use App\Repositories\TramitesRepositoryEloquent;
use App\Repositories\EgobfoliosRepositoryEloquent;

/******/
use App\Repositories\EgobiernonominaRepositoryEloquent;
use App\Repositories\ContdetalleisanRepositoryEloquent;
use App\Repositories\ContdetalleishRepositoryEloquent;
use App\Repositories\ContdetalleisopRepositoryEloquent;
use App\Repositories\ContdetalleisnprestadoraRepositoryEloquent;
use App\Repositories\ContdetalleisnretenedorRepositoryEloquent;
use App\Repositories\ContdetalleretencionesRepositoryEloquent;
use App\Repositories\ContdetimpisopRepositoryEloquent;
use App\Repositories\ProcessedregistersRepositoryEloquent;
use App\Repositories\FamiliaRepositoryEloquent;
use App\Repositories\FamiliaentidadRepositoryEloquent;
use App\Repositories\InpcRepositoryEloquent;
use App\Repositories\RecargonominaRepositoryEloquent;
/*******/
use App\Repositories\ConceptsCalculationRepositoryEloquent;
use App\Repositories\ConceptsubsidiesRepositoryEloquent;
use App\Repositories\UmahistoryRepositoryEloquent;
use App\Repositories\CurrenciesRepositoryEloquent;
use App\Repositories\ApplicableSubjectRepositoryEloquent;


use App\Entities\PortalSolicitudesTicket;

use App\Entities\Transacciones;
use DB;
use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalConfigUserNotaryOfficeRepositoryEloquent;



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
    protected $tipopagodb;
    protected $tramitedb;
    protected $foliosdb;

    protected $nominadb;
    protected $detalleisandb;
    protected $detalleishdb;
    protected $detalleisopdb;
    protected $detalleisnprestadoradb;
    protected $detalleisnretenedordb;
    protected $detalleretencionesdb;
    protected $detimpisopdb;
    protected $processdb;
    protected $familiadb;
    protected $familiaentidaddb;
    protected $inpcdb;
    protected $recargonominadb;

    protected $conceptscalculationdb;
    protected $conceptsubsidiesdb;
    protected $umahistorydb;
    protected $currenciesdb;
    protected $applicablesubjectdb;
    protected $campo;

    protected $configUserNotary;

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
        ClasificadorRepositoryEloquent $clasificadordb,
        EgobiernotipopagoRepositoryEloquent $tipopagodb,
        TramitesRepositoryEloquent $tramitedb,
        EgobfoliosRepositoryEloquent $foliosdb,
        EgobiernonominaRepositoryEloquent $nominadb,      
        ContdetalleisanRepositoryEloquent $detalleisandb,
        ContdetalleishRepositoryEloquent $detalleishdb,
        ContdetalleisopRepositoryEloquent $detalleisopdb,
        ContdetalleisnprestadoraRepositoryEloquent $detalleisnprestadoradb,
        ContdetalleisnretenedorRepositoryEloquent $detalleisnretenedordb,
        ContdetalleretencionesRepositoryEloquent $detalleretencionesdb,
        ContdetimpisopRepositoryEloquent $detimpisopdb,
        ProcessedregistersRepositoryEloquent $processdb,
        FamiliaRepositoryEloquent $familiadb,
        FamiliaentidadRepositoryEloquent $familiaentidaddb,
        InpcRepositoryEloquent $inpcdb,
        RecargonominaRepositoryEloquent $recargonominadb,
        ConceptsCalculationRepositoryEloquent $conceptscalculationdb,
        ConceptsubsidiesRepositoryEloquent $conceptsubsidiesdb,
        UmahistoryRepositoryEloquent $umahistorydb,
        CurrenciesRepositoryEloquent $currenciesdb,
        ApplicableSubjectRepositoryEloquent $applicablesubjectdb,
        PortalcampoRepositoryEloquent $campo,
        PortalConfigUserNotaryOfficeRepositoryEloquent $configUserNotary

    )
    {
        // $this->middleware('auth');

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
        $this->tipopagodb=$tipopagodb;
        $this->tramitedb=$tramitedb;
        $this->foliosdb=$foliosdb;
        $this->nominadb=$nominadb;
        $this->detalleisandb=$detalleisandb;
        $this->detalleishdb=$detalleishdb;
        $this->detalleisopdb=$detalleisopdb;
        $this->detalleisnprestadoradb=$detalleisnprestadoradb;
        $this->detalleisnretenedordb=$detalleisnretenedordb;
        $this->detalleretencionesdb=$detalleretencionesdb;
        $this->detimpisopdb=$detimpisopdb;
        $this->processdb=$processdb;
        $this->familiadb=$familiadb;
        $this->familiaentidaddb=$familiaentidaddb;
        $this->inpcdb=$inpcdb;
        $this->recargonominadb=$recargonominadb;
        $this->conceptscalculationdb=$conceptscalculationdb;
        $this->conceptsubsidiesdb=$conceptsubsidiesdb;
        $this->umahistorydb=$umahistorydb;
        $this->currenciesdb=$currenciesdb;
        $this->applicablesubjectdb=$applicablesubjectdb;
        $this->campo=$campo;
        $this->configUserNotary = $configUserNotary;
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
    		$info = $this->diasferiadosdb->findWhere(["tipo"=>"E"]);
    	}catch( \Exception $e ){
    		Log::info('Error Method diasferiados: '.$e->getMessage());
    	}
    	return view('motorpagos/diasferiados', [ "saved_days" => $info ]);
    }
	public function insertDiasFeriados(Request $request)
	{
		$response = array();
		try
    	{			
			$fecha=Carbon::parse($request->fecha);
            $findDias=$this->diasferiadosdb->findWhere(['Ano'=>$fecha->format('Y'),'Mes'=>$fecha->format('m'),'Dia'=>$fecha->format('d'),'tipo'=>$request->tipo]);
            if($findDias->count()>0)
            {
                 return response()->json([
                    "Code" => "400",
                    "Message" => "Ya se encuentra registrado"
                ]);
            }
            $info = $this->diasferiadosdb->create([
                'Ano'=>$fecha->format('Y'),
                'Mes'=>$fecha->format('m'),
                'Dia'=>$fecha->format('d'),
                'tipo'=>$request->tipo
            ]);    
            return response()->json([
                "Code" => "200",
                "Message" => "Guardado correctamente"
            ]);		
    	}catch( \Exception $e ){
    		Log::info('Error Method diasferiados: '.$e->getMessage());
            return response()->json([
            "Code" => "400",
            "Message" => "Error al guardar"
            ]);
    	}		
	}
	public function deleteDiasFeriados(Request $request) 
	{
		try
    	{
			$info = $this->diasferiadosdb->deleteWhere([
				'Ano'=>$request->ano,
				'Mes'=>$request->mes,
				'Dia'=>$request->dia,
                'tipo'=>$request->tipo
			]);
    		return response()->json([
            "Code" => "200",
            "Message" => "Eliminado correctamente"
            ]);
    	}catch( \Exception $e ){
    		Log::info('Error Method diasferiados: '.$e->getMessage());
            return response()->json([
            "Code" => "400",
            "Message" => "Error al eliminar dia feriado"
            ]);
    	}
	}
    public function findDiasFeriados(Request $request) 
    {
        try
        {
            $info = $this->diasferiadosdb->findWhere(['tipo'=>$request->tipo]);
            return json_encode($info);
            
        }catch( \Exception $e ){
            Log::info('Error Method findDiasFeriados: '.$e->getMessage());
            return response()->json(["Code" => "400","Message" => "Error al buscar dias feriados"]);
        }
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
    public function updateBancoImagen(Request $request)
    {
       
        // identify the name of the file 
        $uploadedFile = $request->file('file');
        $id=$request->id;
        $fileName = $uploadedFile->getClientOriginalName(); 
         $imageData = base64_encode(file_get_contents($uploadedFile->getRealPath()));
        $response="false";
        try
        {
               $buscaimg=$this->bancodb->findWhere(['id'=>$id]);
               foreach ($buscaimg as $k) {
                   File::delete(storage_path('app/'.$k->url_logo));                   
                   $responsed= $uploadedFile->storeAs('Image_Banco/',$fileName);
               }
                $info2 = $this->bancodb->update(['imagen'=>$imageData,'url_logo' => 'Image_Banco/'.$fileName],$id);
                $response="true";              
        
        }catch( \Exception $e ){
                dd($e->getMessage());
                Log::info2('Error Method updateBancoImagen: '.$e->getMessage());
                $response="false";
        }
        return $response;

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
                "conciliacion"=>$i->conciliacion,
                "imagen"=>$i->imagen
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

            /*Actualiza todos los estatus relacionados con la cuenta en pagotramite referente a todos los tramites*/
            $updatStatus=$this->pagotramitedb->updateStatus(['cuentasbanco_id'=>$id],['estatus' => $status]);

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
        $response=array();   
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
        $option=$request->option;
        /*atributos cuentas Banco*/        
        $beneficiario;
        $metodopago;
        $monto_min;
        $montop_max;
        /*end*/
        log::info($option);
        $responseTipoServicio = array();  
        if($option=="portramites"){      
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
        }else{
            $infoCuentasBanco=$this->entidadtramitedb->consultaCuenstasBanco(['entidad_id'=>$idTiposervicio],$idBanco);
            foreach($infoCuentasBanco as $i)
            {
                $responseTipoServicio []= array(
                    "id"=>$i->cuentasbanco_id,              
                    "metodopago" => $i->nombre,
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
        $option=$request->option;
        $entidad=$request->entidad;
        $fechaActual=Carbon::now();
        $date=$fechaActual->format('Y-m-d h:i:s');
        $response = "false";
        try{ 
            $response="true";
            if($option=="soloentidad"){

                $findEntidadTram=$this->entidadtramitedb->findWhere(['entidad_id'=>$entidad]);
                foreach ($findEntidadTram as $e) {

                   $findCuentasBanco=$this->pagotramitedb->findWhere(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$e->tipo_servicios_id]);
                   if($findCuentasBanco->count()==0)
                   {
                    $info = $this->pagotramitedb->create(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$e->tipo_servicios_id,'descripcion'=>'----','estatus'=>'1','fecha_inicio'=>'0000-00-00 00:00:00','fecha_fin'=>'0000-00-00 00:00:00','created_at'=>$date,'updated_at'=>$date]);
                   }
                }
            } else{
                $buscapagotramite=$this->pagotramitedb->findWhere(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$Id_tiposervicio]);
                if($buscapagotramite->count()==0){
                    $info = $this->pagotramitedb->create(['cuentasbanco_id'=>$Id_Banco,'tramite_id'=>$Id_tiposervicio,'descripcion'=>'----','estatus'=>'1','fecha_inicio'=>'0000-00-00 00:00:00','fecha_fin'=>'0000-00-00 00:00:00','created_at'=>$date,'updated_at'=>$date]);
                    
                }else{
                    $response="false";
                }
            }
            
        }
            catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
            $response="false";            
        }
        return $response;
    }
    function updateStatusPagoTramite(Request $request)
    {
        $id=$request->id;
        $actual;
        $nuevo;
        $response="false";
        try{
            $buscaEstatus=$this->pagotramitedb->findWhere(['id'=>$id]);
            foreach ($buscaEstatus as $e) {
                $actual=$e->estatus;
            }
            
            if($actual==1)
            {
                $nuevo=0;
                $response="inactivo";
            }
            else{
                $nuevo=1;
                $response="activo";

            }
            $updateEstatus=$this->pagotramitedb->update(['estatus'=>$nuevo],$id);                  

        } catch( \Exception $e ){
            Log::info('Error Method limitereferencia: '.$e->getMessage());
        $response = "false";
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
        $option=$request->option;
        $entidad=$request->entidad;
        $response = array();  
        if($option=="soloentidad"){
            $info = $this->entidadtramitedb->consultaPagoTramite(['entidad_id'=>$entidad],$id);
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
        }else{
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
        }
         

       return json_encode($response);
    }
    public function updatePagoTramite(Request $request)
    {
        $id=$request->id;
        $descripcion=$request->descripcion;
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $entidad=$request->entidad;
        $option=$request->option;
        $response = "false";
        $date = Carbon::parse($fecha_inicio)->format('Y-m-d');
        $date2 = Carbon::parse($fecha_fin)->format('Y-m-d');
        try{ 
            if($option=="soloentidad"){
                $findEntidadTram=$this->entidadtramitedb->findWhere(['entidad_id'=>$entidad]);
                foreach ($findEntidadTram as $e) {
                    $findCuentas=$this->pagotramitedb->findWhere(['cuentasbanco_id'=>$id,'tramite_id'=>$e->tipo_servicios_id]);
                    foreach ($findCuentas as $c) {
                        $info = $this->pagotramitedb->update(['descripcion'=>$descripcion,'fecha_inicio'=>$date,'fecha_fin'=>$date2],$c->id);
                    }
                     
                }
            }else{
                $info = $this->pagotramitedb->update(['descripcion'=>$descripcion,'fecha_inicio'=>$date,'fecha_fin'=>$date2],$id);  
            }  
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
        $entidad=$request->entidad;
        $option=$request->option;
        $response = "false";
        try{
            if($option=="soloentidad")
            {
                $findEntidadTram=$this->entidadtramitedb->findWhere(['entidad_id'=>$entidad]);
                foreach ($findEntidadTram as $e) {
                    $findCuentas=$this->pagotramitedb->findWhere(['cuentasbanco_id'=>$id,'tramite_id'=>$e->tipo_servicios_id]);
                    foreach ($findCuentas as $c) {
                        $info = $this->pagotramitedb->deleteWhere(['id'=>$c->id]);
                    }
                     
                }

            }else{
                $info = $this->pagotramitedb->deleteWhere(['id'=>$id]);
            }
            
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
            Log::info('Error Method updateentidad: '.$e->getMessage());
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
         //Log::info($id);   
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
        $info=$this->tiposerviciodb->ServiciosfindAll();
        $response = array();
        /*$limitereferencia= "";
        $tiporeferencia="";
        $nombreentidad="";*/
        //log::info($info);
        foreach ($info as $i) 
        {
          /*  $infotiporeferencia=$this->tiporeferenciadb->fin(['id'=>$i->tiporeferencia_id]);
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
            }*/
             $response []= array(
                "Entidad"=>$i->Entidad,
                "Tipo_Code" => $i->Tipo_Code,
                "Tipo_Descripcion" => $i->Tipo_Descripcion,
                "Origen_URL" => $i->Origen_URL,
                "GpoTrans_Num" => $i->GpoTrans_Num,
                "id_gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia" => $i->fecha_condensada,
                "limitereferencia" => $i->descripcion
            );
        }


        return view('motorpagos/tiposervicio',['response'=>$response]);

    }

    public function findTipoServicioWhere()
    {
       
        $info=$this->tiposerviciodb->ServiciosfindAll();
        $response = array();        
        foreach ($info as $i) 
        {
           
            $response []= array(
                "id"=>$i->id,
                "Entidad"=>$i->Entidad,
                "Tipo_Code" => $i->Tipo_Code,
                "Tipo_Descripcion" => $i->Tipo_Descripcion,
                "Origen_URL" => $i->Origen_URL,
                "GpoTrans_Num" => $i->GpoTrans_Num,
                "id_gpm" => $i->id_gpm,
                "descripcion_gpm" => $i->descripcion_gpm,
                "tiporeferencia" => $i->fecha_condensada,
                "limitereferencia" => $i->descripcion,
                "id_entidadtramite" => $i->id_entidadtramite,
                "id_entidadfamilia" => $i->id_entidadfamilia
            );
        }

        return json_encode($response);

    }
    public function findTipoServicio_whereId(Request $request)
    {
        $id=$request->id;
        $id_entidadtramite=$request->id_entidadtramite;        
        $entidad="";
        $familia="";
        $info=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$id]);
        
        if($id_entidadtramite <>"null" || $id_entidadtramite<>null)
        {
            $findentidad=$this->entidadtramitedb->findWhere(['id'=>$id_entidadtramite]);
            foreach ($findentidad as $k) {
                $entidad=$k->entidad_id;
            }
            $findFamilia=$this->familiaentidaddb->findWhere(['entidad_id'=>$entidad]);
            foreach ($findFamilia as $e) {
                $familia=$e->familia_id;
            }
        }        
        
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
                "limitereferencia" => $i->limitereferencia_id,
                "familia_id"=>$familia,
                "entidad_id"=>$entidad
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
        $entidad=$request->entidad;
        $response="false";
        $info=$this->tiposerviciodb->create(['Tipo_Descripcion'=>$descripcion,'Origen_URL'=>$url,'GpoTrans_Num'=>$gpoTrans,'id_gpm'=>$id_gpm,'descripcion_gpm'=>$descripcion_gpm,'tiporeferencia_id'=>$tiporeferencia,'limitereferencia_id'=>$limitereferencia]);
             $response="true";
        $id=$info->id;
        if($entidad !== 'limpia')
        {
            $findentidad=$this->entidadtramitedb->findWhere(['entidad_id'=>$entidad,'tipo_servicios_id'=>$id]);
            if($findentidad->count()==0)
            {
                $insertEntidad=$this->entidadtramitedb->create(['entidad_id'=>$entidad,'tipo_servicios_id'=>$id]);
            }
        }

        
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
        $entidad_id=$request->entidad_id;
        $id=$request->id;
        $response="false";
        $id_entidadtramite=$request->id_entidadtramite;
        $info=$this->tiposerviciodb->updateMenuByName(['Tipo_Descripcion'=>$descripcion,'Origen_URL'=>$url,'GpoTrans_Num'=>$gpoTrans,'id_gpm'=>$id_gpm,'descripcion_gpm'=>$descripcion_gpm,'tiporeferencia_id'=>$tiporeferencia,'limitereferencia_id'=>$limitereferencia],['Tipo_Code'=>$id]);
        $findentidad=$this->entidadtramitedb->findWhere(['tipo_servicios_id'=>$id,'entidad_id'=>$entidad_id]);
        if($id_entidadtramite==null || $id_entidadtramite=="null")
        {
            if($entidad_id<>"limpia" || $entidad_id<>null || $entidad_id<>"null"){
                $insertentidatram=$this->entidadtramitedb->create(['tipo_servicios_id'=>$id,'entidad_id'=>$entidad_id]);
            }
        }else{
            
            $updateEntidad=$this->entidadtramitedb->update(['entidad_id'=>$entidad_id],$id_entidadtramite);
           
        }
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
        $descripcion;
        $idpagotramite;
        $nombrebanco;
        $metodopago;
        $cuentas;
        $cuenta_id;
        $servicio;
        $estatus;
        $banco_id;

        $response=array(); 
        $oper_entidadtramite=$this->entidadtramitedb->findWhere(['entidad_id'=>$Id_entidad]);
        foreach ($oper_entidadtramite as $i) {
            $id_tiposervicio=$i->tipo_servicios_id;

            $tiposervicio=$this->tiposerviciodb->findWhere(['Tipo_Code'=>$i->tipo_servicios_id]);
            foreach ($tiposervicio as $ii) {
               $descripcion=$ii->Tipo_Descripcion;
            }
            $oper_pagotramite=$this->pagotramitedb->findWhere(['tramite_id'=>$i->tipo_servicios_id]);
            foreach ($oper_pagotramite as $key) {
                 $idpagotramite=$key->id;
                 $estatus=$key->estatus;
                $oper_cuentasbanco=$this->cuentasbancodb->findWhere(['id'=>$key->cuentasbanco_id]);

                foreach ($oper_cuentasbanco as $cuenta) {
                    $cuenta_id=$cuenta->id;
                    $banco_id=$cuenta->banco_id;
                    $oper_banco=$this->bancodb->findWhere(['id'=>$cuenta->banco_id]);
                        foreach ($oper_banco as $ban) {
                        $nombrebanco=$ban->nombre;
                        }
                    $oper_metodopago=$this->metodopagodb->findWhere(['id'=>$cuenta->metodopago_id]);
                        foreach ($oper_metodopago as $metodo) {
                          $metodopago=$metodo->nombre;
                        }

                   
                    
                    $beneficiario=json_decode($cuenta->beneficiario);
                    foreach ( $beneficiario as $b) {
                       $cuentas=$b->cuenta;
                       $servicio=$b->servicio;
                   }
                    $response []= array(
                    "id"=> $idpagotramite,
                    "entidad_id"=>$Id_entidad,
                    "id_tiposervicio"=>$id_tiposervicio,                    
                    "descripcion" => $descripcion,
                    "banco_id"=>$banco_id,
                    "banco"=>$nombrebanco,
                    "id_cuenta"=>$cuenta_id,
                    "cuenta"=>$cuentas,
                    "servicio"=>$servicio,
                    "metodopago"=>$metodopago,
                    "monto_max"=>$cuenta->monto_max,
                    "monto_min"=>$cuenta->monto_min,
                    "status" =>$estatus               
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
        $partida=$request->partida;
        $response = "false";
        try{ 

        $updatepartidas=$this->partidasdb->updatePartida(['id_servicio'=>$idservicio,'descripcion'=>$descripcion,'id_partida'=>$partida],['id_partida'=>$idpartida]);
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
    public function consultaTransacciones()
    {

        $servicios = $this->findTipoServicioAll();
        $status =  $this->statusFindAll();
        return view('motorpagos/consultatramites', ["servicios" => json_decode($servicios), "status"=>json_decode($status )]);
    }
    public function consultaTransaccionesEgob(Request $request)
    {
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $rfc=$request->rfc;
        $response=array(); 
        $fechaActual=Carbon::now();


        if((int)$fecha_inicio==(int)"1")
        {
            
            $fechaAterior=Carbon::now()->subDays(1);
            $fecha_inicio=$fechaAterior->format('Y-m-d');
            $fecha_fin=$fechaActual->format('Y-m-d');
        }
        if((int)$fecha_inicio==(int)"3")
        {
            $fechaAterior=Carbon::now()->subDays(3);
            $fecha_inicio=$fechaAterior->format('Y-m-d');
            $fecha_fin=$fechaActual->format('Y-m-d');
        }
        if($rfc=="")
        {                
            $transaccion=$this->transaccionesdb->consultaTransacciones($fecha_inicio,$fecha_fin);
            if($transaccion<>null)
            {
                $response=$this->responseTrasaccionesEgob($transaccion,$response);
            }
        //log::info($transaccion->count());
        }else{
            if($fecha_inicio=="" && $fecha_fin=="")
            {
                 $fechaIn=Carbon::now()->subYears(1);
                    $fechaIn=$fechaIn->format('Y');
                    $fechaIn=$fechaIn.'-01-01';
                    $fechaFin=$fechaActual->format('Y-m-d');
                   // log::info($fechaIn.' - '.$fechaFin.' - '.$rfc);
                $transaccion=$this->foliosdb->consultaRFCegob(['CartKey1'=>$rfc],$fechaIn,$fechaFin);
                if($transaccion<>null)
                {
                    $response=$this->responseTrasaccionesEgob($transaccion,$response);
                }
                $transaccionFolio=$this->transaccionesdb->consultaTransaccionesFolio($rfc);
                //log::info($transaccionFolio);
                if($transaccionFolio<>null)
                {
                    $response=$this->responseTrasaccionesEgob($transaccionFolio,$response);
                }
            }else{
                $transaccion=$this->transaccionesdb->consultaTransaccionesWhere($fecha_inicio,$fecha_fin,['folios.CartKey1'=>$rfc]);
                if($transaccion<>null)
                {
                    $response=$this->responseTrasaccionesEgob($transaccion,$response);
                }
                $transaccion=$this->transaccionesdb->consultaTransaccionesWhere($fecha_inicio,$fecha_fin,['transacciones.idTrans'=>$rfc]);
                if($transaccion<>null)
                {
                    $response=$this->responseTrasaccionesEgob($transaccion,$response);
                }
            }            
        }
        
        
        return json_encode($response);
        
    }
    private function responseTrasaccionesEgob($transaccion,$response)
    {
        if($transaccion<>null){
            foreach ($transaccion as $trans){
                $familia='';
                $entidad='';
                $findDeclarado=null;
                $declarado_anio="Aplica";
                $declarado_mes= "";
                //$findConcilia=$this->processdb->findWhere(['transaccion_id'=>$trans->idTrans]);
                $estatus_C="";
                /*$findEntidad=$this->entidadtramitedb->consultaEntidadTramite($trans->tiposervicio_id);
                if($findEntidad<>null){
                    foreach ($findEntidad as $f) {
                        $familia=$f->familia;
                        $entidad=$f->entidad;
                    }
                } */
            
                if($trans->transaccion_id==null)
                {
                    $estatus_C='No Procesado'; 
                }else{
                    $estatus_C='Procesado';
                }
                if((int)$trans->tiposervicio_id==(int)"3")
                {
                    $findDeclarado=$this->nominadb->findWhere(['idtran'=>$trans->idTrans]); 
                    foreach ($findDeclarado as $e) {
                        $declarado_anio=$e->anodec;
                        $declarado_mes=$e->mesdec;
                    }                  
                }elseif((int)$trans->tiposervicio_id==(int)"13")
                {
                    $findDeclarado=$this->detalleisandb->findWhere(['idTrans'=>$trans->idTrans]);
                    foreach ($findDeclarado as $e) {
                        $declarado_anio=$e->anio_1;
                        $declarado_mes=$e->mes_1;
                    }
                }else{

                    if((int)$trans->tiposervicio_id==(int)"14")
                    {
                        $findDeclarado=$this->detalleishdb->findWhere(['idTrans'=>$trans->idTrans]);                    
                    }
                    if((int)$trans->tiposervicio_id==(int)"15")
                    {
                        $findDeclarado=$this->detalleisopdb->findWhere(['idTrans'=>$trans->idTrans]);                    
                    }
                    if((int)$trans->tiposervicio_id==(int)"23")
                    {
                        $findDeclarado=$this->detalleisnprestadoradb->findWhere(['idtrans'=>$trans->idTrans]);                    
                    }
                    if((int)$trans->tiposervicio_id==(int)"24")
                    {
                        $findDeclarado=$this->detalleisnretenedordb->findWhere(['idtrans'=>$trans->idTrans]);         
                    }
                    if((int)$trans->tiposervicio_id==(int)"25")
                    {
                        $findDeclarado=$this->detimpisopdb->findWhere(['idTrans'=>$trans->idTrans]);                    
                    }                   
                    if($findDeclarado<>null)
                    {
                        foreach ($findDeclarado as $e) {
                            $declarado_anio=$e->anio;
                            $declarado_mes=$e->mes;
                        }
                    }   
                }       
            
                switch ($declarado_mes) {
                    case '1':
                        $declarado="ENERO";                    
                        break;
                    case '2':
                        $declarado="FEBRERO";                    
                        break;
                    case '3':
                        $declarado="MARZO";                    
                        break;
                    case '4':
                        $declarado="ABRIL";                    
                        break;
                    case '5':
                        $declarado="MAYO";                    
                        break;
                    case '6':
                        $declarado="JUNIO";                    
                        break;
                    case '7':
                        $declarado="JULIO";                    
                        break;
                    case '8':
                        $declarado="AGOSTO";                    
                        break;
                    case '9':
                        $declarado="SEPTIEMBRE";                    
                        break;
                    case '10':
                        $declarado="OCTUBRE";                    
                        break;
                    case '11':
                        $declarado="NOVIEMBRE";                    
                        break;
                    case '12':
                        $declarado="NOVIEMBRE";                    
                        break;                                    
                    default:
                        $declarado="No";
                        break;
                }
                $response []= array(
                    'Estatus'=>$trans->status,
                    'RFC'=>$trans->rfc,
                    'Transaccion'=>$trans->idTrans,                        
                    'Familia'=>$trans->familia,
                    'Entidad'=>$trans->entidad,
                    'Tramite'=>$trans->tiposervicio,
                    'Contribuyente'=>$trans->TitularTC,
                    'Inicio_Tramite'=>$trans->fechatramite." ".$trans->HoraTramite,
                    'Banco'=>$trans->BancoSeleccion,
                    'Tipo_Pago'=>$trans->tipopago,
                    'Total_Tramite'=>$trans->TotalTramite,
                    'Declarado'=>$declarado." ".$declarado_anio,
                    'estatus'=>$estatus_C
                );                 
                
            }
        }
        return $response;
    }
    public function consultaTransaccionesOper(Request $request)
    {
        
        $rfc=$request->rfc;        
        $familia=$request->familia;        
        $fecha_inicio=$request->fecha_inicio.' 00:00:00';
        $fecha_fin=$request->fecha_fin.' 23:59:59';
        $response=array();
        //log::info('inicio');
        $fechaActual=Carbon::now();
        if((int)$fecha_inicio==(int)"1")
        {           
            $fechaAterior=Carbon::now()->subDays(1);
            $fecha_inicio=$fechaAterior->format('Y-m-d').' 00:00:00';
            $fecha_fin=$fechaActual->format('Y-m-d').' 23:59:59';
        }
        if((int)$fecha_inicio==(int)"3")
        {           
            $fechaAterior=Carbon::now()->subDays(3);
            $fecha_inicio=$fechaAterior->format('Y-m-d').' 00:00:00';
            $fecha_fin=$fechaActual->format('Y-m-d').' 23:59:59';            
        }       
        if($rfc=="" && $familia=='0')
        {
         $transaccion=$this->oper_transaccionesdb->consultaTransacciones($fecha_inicio,$fecha_fin); 
            if($transaccion<>null){
                $response=$this->reponseTransacciones($transaccion,$response);
            }      
        }else{
            if($fecha_inicio==" 00:00:00" && $fecha_fin==" 23:59:59")
            {
                $fechaIn=$fechaActual->subYears(1);
                $fechaIn=$fechaIn->format('Y');
                $fechaIn=$fechaIn.'-01-01 00:00:00';
                $fechaFin=$fechaActual->format('Y-m-d').' 23:59:59';
                $transaccion=$this->tramitedb->consultaRFCoper(['rfc'=>$rfc],$fechaIn,$fechaFin);
                if($transaccion<>null){
                    $response=$this->reponseTransacciones($transaccion,$response);
                }
                $transaccionplaca=$this->tramitedb->consultaRFCoper(['auxiliar_2'=>$rfc],$fechaIn,$fechaFin);
               //log::info($rfc.$transaccionplaca);
                 if($transaccionplaca<>null){
                    $response=$this->reponseTransacciones($transaccionplaca,$response);
                }
                $findFolio=$this->oper_transaccionesdb->consultaFolioTransacciones($rfc,$fechaIn,$fechaFin);
                //log::info($findFolio);
                 if($findFolio<>null){
                    $response=$this->reponseTransacciones($findFolio,$response);
                }
            }else{
                if($rfc!=""){
                    $transaccion=$this->oper_transaccionesdb->consultaTransaccionesWhere($fecha_inicio,$fecha_fin,['oper_tramites.rfc'=>$rfc]);
                    if($transaccion<>null){
                        $response=$this->reponseTransacciones($transaccion,$response);
                    } 
                    $transaccion=$this->oper_transaccionesdb->consultaTransaccionesWhere($fecha_inicio,$fecha_fin,['oper_tramites.auxiliar_2'=>$rfc]);
                    if($transaccion<>null){
                        $response=$this->reponseTransacciones($transaccion,$response);
                    } 
                    $transaccion=$this->oper_transaccionesdb->consultaTransaccionesWhere($fecha_inicio,$fecha_fin,['oper_transacciones.id_transaccion_motor'=>$rfc]);
                    if($transaccion<>null){
                        $response=$this->reponseTransacciones($transaccion,$response);
                    }
                }
                if($familia!='0'){
                    $transaccion=$this->oper_transaccionesdb->consultaTransaccionesWhere($fecha_inicio,$fecha_fin,['oper_familia.id'=>$familia]);
                    if($transaccion<>null){
                        $response=$this->reponseTransacciones($transaccion,$response);
                     
                    }
                }
            }
        }    
        //log::info($transaccion);
         return json_encode($response);
        
    }
    private function reponseTransacciones($transacciones,$response)
    {
        if($transacciones<>null){
        foreach ($transacciones as $trans) {
            //$findConcilia=$this->processdb->findWhere(['referencia'=>$trans->referencia]);
            $estatus_C="np";
            if($trans->id==null)
                {
                   $estatus_C="No Procesado"; 
                }else{                   
                       $estatus_C='Procesado';                  
                }
            
                $response []= array(
                    'Estatus'=>$trans->status,
                    'RFC'=>$trans->rfc,
                    'Folio'=>$trans->id_transaccion_motor,
                    'Transaccion'=>$trans->idTrans,
                    'Familia'=>$trans->familia,
                    'Entidad'=>$trans->entidad,
                    'Tramite'=>$trans->tiposervicio,
                    'Contribuyente'=>$trans->nombre." ".$trans->apellido_paterno,
                    'Inicio_Tramite'=>$trans->fecha_transaccion,
                    'Banco'=>$trans->BancoSeleccion,
                    'Tipo_Pago'=>$trans->tipopago,
                    'Total_Tramite'=>$trans->TotalTramite,
                    'estatus'=>$estatus_C
                    );                    
               
            }
        }    
        return $response;
    }
    public function consultaTransaccionesGpm(Request $request)
    {      
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $response=array();
        //log::info($rfc);
       
         $transaccion=$this->transaccionesdb->consultaContr($fecha_inicio,$fecha_fin);
        //log::info($transaccion);      
        if($transaccion<>null){
            foreach ($transaccion as $trans) {            
                $response []= array(
                    'id_transaccion'=>$trans->id_transaccion,
                    'id_transaccion_entidad'=>$trans->id_transaccion_entidad,
                    'TotalTramite'=>$trans->TotalTramite,
                    'fechaTramite'=>$trans->fechaTramite,
                    'horaTramite'=>$trans->horaTramite,
                    'id_tramite'=>$trans->id_tramite,
                    'id_tramite_entidad'=>$trans->id_tramite_entidad,
                    'importe_tramite'=>$trans->importe_tramite,
                    'Tipo_Descripcion'=>$trans->Tipo_Descripcion
                ); 
            }                   
        }
        return json_encode($response);
    }
    public function updateConciliaBanco(Request $request)
    {
        $id=$request->id;
        $estatus;
        $nuevoEstatus;
        $response="false";
        try{
            $verificaStatus=$this->bancodb->findWhere(['id'=>$id]);
            foreach ($verificaStatus as $k) {
                $estatus=$k->conciliacion;
            }
            if($estatus==1)
            {
                $nuevoEstatus=0;  
            }else{
                $nuevoEstatus=1;
            }
            $updateStatus=$this->bancodb->update(['conciliacion'=>$nuevoEstatus],$id);
            $response="true";
        } catch( \Exception $e ){
            Log::info('Error Method clasificadorDeleted: '.$e->getMessage());
        $response = "false";
        }
       return $response;

    }

    public function familia()
    {   
        $response=array();
        $findFamilia=$this->familiadb->All();
        foreach ($findFamilia as $e) {
           $response []= array(
           'id'=>$e->id,
           'nombre'=>$e->nombre
            );
        }

        return view('motorpagos/familia', [ "familia" => $response ]);

    }
    public function familiaInsert(Request $request)
    {
        $nombre=$request->nombre;
        $val=false;
        $busca=strtolower($nombre);
        $response="false";
        try{
        $findFamilia=$this->familiadb->all();
        foreach ($findFamilia as $a){
            if($busca==strtolower($a->nombre))
                {
                    $val=true;
                }
        }        
        if($val)
        {
            $response="false";
        }else{
            
            $insert=$this->familiadb->create(['nombre'=>$nombre]);
            //log::info($insert->id);
            $response="true";
        }

        } catch( \Exception $e ){
            Log::info('Error Method clasificadorUpdate: '.$e->getMessage());
            $response = "false";
        }
        return $response;
    }
    public function familiafindAll()
    {
        $response=array();
        $findFamilia=$this->familiadb->All();
        foreach ($findFamilia as $e) {
           $response []= array(
           'id'=>$e->id,
           'nombre'=>$e->nombre
            );
        }
         return json_encode($response);
    }
    public function familiaentidadFindwhere(Request $request)
    {
        $response=array();
        $familia_id=$request->familia_id;

        $findFamiliaEntidad=$this->familiaentidaddb->findFamilia($familia_id);
        foreach ($findFamiliaEntidad as $k) {
           $response []= array(
            'id' => $k->id, 
            'familia' => $k->familia, 
            'entidad' => $k->entidad, 
            'familia_id' => $k->familia_id, 
            'entidad_id' => $k->entidad_id
            );
        }
        return json_encode($response);
    }
    public function familientidadInsert(Request $request)
    {
        $familia_id=$request->familia_id;
        $entidad_id=$request->entidad_id;
        $response="false";
        $findFamiliaEntidad=$this->familiaentidaddb->findWhere(['familia_id'=>$familia_id,'entidad_id'=>$entidad_id]);

        if($findFamiliaEntidad->count()==0)
        {
            $insert=$this->familiaentidaddb->create(['familia_id'=>$familia_id,'entidad_id'=>$entidad_id]);
            $response="true";
        }else{
            $response="false";
        }
        return $response;

    }
    public function familientidadUpdate(Request $request)
    {
        $id=$request->id;
        $familia_id=$request->familia_id;
        $entidad_id=$request->entidad_id;
        $response="false";
        $findFamiliaEntidad=$this->familiaentidaddb->findWhere(['familia_id'=>$familia_id,'entidad_id'=>$entidad_id]);

        if($findFamiliaEntidad->count()==0)
        {
            $insert=$this->familiaentidaddb->update(['entidad_id'=>$entidad_id],$id);
            $response="true";
        }else{
            $response="false";
        }
        return $response;

    }
    public function familientidadDeleted(Request $request)
    {
        $id=$request->id;
        $response="false";
        try{
            $insert=$this->familiaentidaddb->deleteWhere(['id'=>$id]);
            $response="true";
        } catch( \Exception $e ){
            Log::info('Error Method familientidadDeleted: '.$e->getMessage());
            $response = "false";
        }
        return $response;

    }
    public function familiaFindWhere(Request $request)
    {
        $id=$request->id;
        $response=array();
        try{
            $findFamilia=$this->familiadb->findWhere(['id'=>$id]);

            foreach ($findFamilia as $e) {
                $response []= array(
                    'id' =>  $e->id,
                    'nombre' =>  $e->nombre
                );
            }
        } catch( \Exception $e ){
            Log::info('Error Method familientidadDeleted: '.$e->getMessage());
           
        }
        return json_encode($response);

    }
    public function familiaUpdate(Request $request)
    {
        $id=$request->id;
        $familia=$request->familia;
        $response="false";
        try{
            $findFamilia=$this->familiadb->update(['nombre'=>$familia],$id);

            $response="true";
        } catch( \Exception $e ){
            Log::info('Error Method familientidadDeleted: '.$e->getMessage());
           $response="false";
        }
        return $response;

    }
    public function inpc()
    {
        return view('motorpagos/inpc');
    }
    public function inpcFindAll()
    {
        $response=array();
        $mes='';
        $findAll=$this->inpcdb->all();
        foreach ($findAll as $i) {
            switch ($i->mes) {
                case '1':
                    $mes="ENERO";                    
                    break;
                case '2':
                    $mes="FEBRERO";                    
                    break;
                case '3':
                    $mes="MARZO";                    
                    break;
                case '4':
                    $mes="ABRIL";                    
                    break;
                case '5':
                    $mes="MAYO";                    
                    break;
                case '6':
                    $mes="JUNIO";                    
                    break;
                case '7':
                    $mes="JULIO";                    
                    break;
                case '8':
                    $mes="AGOSTO";                    
                    break;
                case '9':
                    $mes="SEPTIEMBRE";                    
                    break;
                case '10':
                    $mes="OCTUBRE";                    
                    break;
                case '11':
                    $mes="NOVIEMBRE";                    
                    break;
                case '12':
                    $mes="DICIEMBRE";                    
                    break;                                    
                default:
                    $mes="---";
                    break;
            }
            $response []= array( 
            'id'=>$i->id,
            'anio'=>$i->ano,
            'mes'=>$mes,
            'indice'=>$i->indice
        );
        }
        return json_encode($response);
    }
    public function inpcInsert(Request $request)
    {
        $response=array();
        $anio=$request->anio;
        $mes=$request->mes;
        $indice=$request->indice;
        try{
            $find=$this->inpcdb->findWhere(['ano'=>$anio,'mes'=>$mes]);
            if($find->count()==0)
                {
                    $update=$this->inpcdb->create(['ano'=>$anio,'mes'=>$mes,'indice'=>$indice]);
                    $response=["Code" => "200", "Message" => "Guardado con éxito"];
                }else{
                    $response=["Code" => "400", "Message" => "Ya se encuentra año/mes"];
                }           

        } catch( \Exception $e ){
            Log::info('Error Method inpcInsert: '.$e->getMessage());
            $response=["Code" => "400", "Message" => "Error al Guardar"];
        }
        return response()->json($response);
    }
    public function inpcUpdate(Request $request)
    {
        $response=array();
        $id=$request->id;
        $anio=$request->anio;
        $mes=$request->mes;
        $indice=$request->indice;
        try{
            $findIn=$this->inpcdb->findWhere(['id'=>$id]);
            foreach($findIn as $k) {
               if($k->ano==$anio && $k->mes==$mes)
                {
                    $update=$this->inpcdb->update(['ano'=>$anio,'mes'=>$mes,'indice'=>$indice],$id);  
                    $response=["Code" => "200", "Message" => "Actualizado con éxito"];
                }else{
                    $findInpc=$this->inpcdb->findWhere(['ano'=>$anio,'mes'=>$mes]);
                    if($findInpc->count()==0)
                    {
                        $update=$this->inpcdb->update(['ano'=>$anio,'mes'=>$mes,'indice'=>$indice],$id); 
                        $response=["Code" => "200", "Message" => "Actualizado con éxito"];
                    }else{
                        $response=["Code" => "400", "Message" => "Ya se encuentra año/mes"];
                    }
                }
            }
            
            
        } catch( \Exception $e ){
            Log::info('Error Method inpcUpdate: '.$e->getMessage());
            $response=["Code" => "400", "Message" => "Error al Guardar"];
        }
        return response()->json($response);
    }
     public function inpcDeleted(Request $request)
    {
        $response='false';
        $id=$request->id;
        
        try{
            $update=$this->inpcdb->deleteWhere(['id'=>$id]);
            $response='true';
        } catch( \Exception $e ){
            Log::info('Error Method inpcDeleted: '.$e->getMessage());
            $response = "false";
        }
        return $response;
    }
    public function inpcFindWhere(Request $request)
    {
        $response=array();
        $id=$request->id;
        $find=$this->inpcdb->findWhere(['id'=>$id]);
        foreach ($find as $i) {
          $response []= array( 
            'id'=>$i->id,
            'anio'=>$i->ano,
            'mes'=>$i->mes,
            'indice'=>$i->indice
            );
        }
        return json_encode($response);
    }

    public function recargosNomina()
    {
        return view('motorpagos/recargosnomina');
    }
    public function recargosFindAll()
    {
        $response=array();
        $mes='';
        $findAll=$this->recargonominadb->all();
        foreach ($findAll as $i) {
            switch ($i->mes) {
                case '1':
                    $mes="ENERO";                    
                    break;
                case '2':
                    $mes="FEBRERO";                    
                    break;
                case '3':
                    $mes="MARZO";                    
                    break;
                case '4':
                    $mes="ABRIL";                    
                    break;
                case '5':
                    $mes="MAYO";                    
                    break;
                case '6':
                    $mes="JUNIO";                    
                    break;
                case '7':
                    $mes="JULIO";                    
                    break;
                case '8':
                    $mes="AGOSTO";                    
                    break;
                case '9':
                    $mes="SEPTIEMBRE";                    
                    break;
                case '10':
                    $mes="OCTUBRE";                    
                    break;
                case '11':
                    $mes="NOVIEMBRE";                    
                    break;
                case '12':
                    $mes="DICIEMBRE";                    
                    break;                                    
                default:
                    $mes="---";
                    break;
            }
            $response []= array( 
            'id'=>$i->id,
            'anio'=>$i->ano,
            'mes'=>$mes,
            'vencido'=>$i->vencido,
            'requerido'=>$i->requerido
        );
        }
        return json_encode($response);
    }
    public function recargosInsert(Request $request)
    {
        $anio=$request->anio;
        $mes=$request->mes;
        $vencido=$request->vencido;
        $requerido=$request->requerido;
        $response=array();
        try{
            $find=$this->recargonominadb->findWhere(['ano'=>$anio,'mes'=>$mes]);
            if($find->count()==0)
                {
                    $update=$this->recargonominadb->create(['ano'=>$anio,'mes'=>$mes,'vencido'=>$vencido,'requerido'=>$requerido]);
                    $response=["Code" => "200", "Message" => "Guardado con éxito"];
                }else{
                    $response=["Code" => "400", "Message" => "Ya se encuentra año/mes"];
                }           

        } catch( \Exception $e ){
            Log::info('Error Method recargosInsert: '.$e->getMessage());
             $response=["Code" => "400", "Message" => "Error al Guardar"];
        }
        return response()->json($response);
    }
    public function recargosUpdate(Request $request)
    {
        $id=$request->id;
        $anio=$request->anio;
        $mes=$request->mes;
        $vencido=$request->vencido;
        $requerido=$request->requerido;
        $response=array();
        try{
            $findP=$this->recargonominadb->findWhere(["id"=>$id]);
            foreach ($findP as $k) {
                if($k->ano==$anio && $k->mes==$mes)
                {
                    $update=$this->recargonominadb->update(['ano'=>$anio,'mes'=>$mes,'vencido'=>$vencido,'requerido'=>$requerido],$id);
                    $response=["Code" => "200", "Message" => "Actualizado con éxito"];
                }else{
                    $findPartida=$this->recargonominadb->findWhere(['ano'=>$anio,'mes'=>$mes]);
                    if($findPartida->count()==0)
                    {
                        $update=$this->recargonominadb->update(['ano'=>$anio,'mes'=>$mes,'vencido'=>$vencido,'requerido'=>$requerido],$id);
                        $response=["Code" => "200", "Message" => "Actualizado con éxito"];
                    }else{
                        $response=["Code" => "400", "Message" => "Ya se encuentra año/mes"];
                    }
                }
            }
        } catch( \Exception $e ){
            Log::info('Error Method recargosUpdate: '.$e->getMessage());
            $response=["Code" => "400", "Message" => "Error al Actualizar"];
        }
        return response()->json($response);
    }
     public function recargosDeleted(Request $request)
    {
        $response='false';
        $id=$request->id;
        
        try{
            $update=$this->recargonominadb->deleteWhere(['id'=>$id]);
            $response='true';
        } catch( \Exception $e ){
            Log::info('Error Method recargosDeleted: '.$e->getMessage());
            $response = "false";
        }
        return $response;
    }
    public function recargosFindWhere(Request $request)
    {
        $response=array();
        $id=$request->id;
        $find=$this->recargonominadb->findWhere(['id'=>$id]);
        foreach ($find as $i) {
          $response []= array( 
            'id'=>$i->id,
            'anio'=>$i->ano,
            'mes'=>$i->mes,
            'vencido'=>$i->vencido,
            'requerido'=>$i->requerido
            );
        }
        return json_encode($response);
    }

    public function umaHistory()
    {
        return view('motorpagos/uma');
    }
    public function umaHistoryFindAll()
    {
        $response=array();
        $findAll=$this->umahistorydb->all();
        foreach ($findAll as $e) {
            $response []=array(
                'id' =>$e->id ,
                'dia' =>$e->daily ,
                'mes' =>$e->monthly ,
                'anio' =>$e->yearly ,
                'year' =>$e->year,
                'fecha_inicio' =>$e->fecha_inicio,
                'fecha_fin' =>$e->fecha_fin
            );
        }
        return json_encode($response);

    }
     public function umaHistoryFindWhere(Request $request)
    {
        $id=$request->id;
        $response=array();
        $UmafindWhere=$this->umahistorydb->findWhere(['id'=>$id]);
        foreach ($UmafindWhere as $e) {
            $response []=array(
                'id' =>$e->id ,
                'dia' =>$e->daily ,
                'mes' =>$e->monthly ,
                'anio' =>$e->yearly ,
                'year' =>$e->year,
                'fecha_inicio' =>$e->fecha_inicio,
                'fecha_fin' =>$e->fecha_fin 
            );
        }
        return json_encode($response);

    }
    public function umaHistoryInsert(Request $request)
    {
        $dia=$request->dia;
        $mes=$request->mes;
        $anio=$request->anio;
        $year=$request->year;
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $response='false';
        try{
        $UmaInsert=$this->umahistorydb->create(['daily'=>$dia,'monthly'=>$mes,'yearly'=>$anio,'year'=>$year,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);
        $response='true';
        } catch( \Exception $e ){
            Log::info('Error Method umaHistoryInsert: '.$e->getMessage());
            $response = 'false';
        }
        return $response;

    }
    public function umaHistoryUpdate(Request $request)
    {
        $id=$request->id;
        $dia=$request->dia;
        $mes=$request->mes;
        $anio=$request->anio;
        $year=$request->year;        
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;

        $response='false';
        try{
        $UmaUpdate=$this->umahistorydb->update(['daily'=>$dia,'monthly'=>$mes,'yearly'=>$anio,'year'=>$year,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin],$id);
        $response='true';
        } catch( \Exception $e ){
            Log::info('Error Method umaHistoryUpdate: '.$e->getMessage());
            $response = "false";
        }
        return $response;

    }
    public function umaHistoryDeleted(Request $request)
    {
        $id=$request->id;        
        $response='false';
        try{
        $UmaDeleted=$this->umahistorydb->deleteWhere(['id'=>$id]);
        $response='true';
        } catch( \Exception $e ){
            Log::info('Error Method umaHistoryUpdate: '.$e->getMessage());
            $response = "false";
        }
        return $response;

    }
    public function subsidioFindWhere(Request $request)
    {
        $response=array();
        $id_tramite=$request->id_tramite;
        $findSubsidio=$this->conceptsubsidiesdb->findWhere(['id_procedure'=>$id_tramite]);
        foreach ($findSubsidio as $e) {
            $response []= array(
                'id' =>$e->id, 
                'totaldespues' =>$e->total_after_subsidy, 
                'moneda' =>$e->currency_total , 
                'descripcion' =>$e->subsidy_description , 
                'decretoficio' =>$e->no_subsidy , 
                'formato' =>$e->format, 
                'total' =>$e->total_max_to_apply , 
                'id_partida' =>$e->id_budget_heading , 
                'uma_type' =>$e->uma_type ,
                'uma_type_after_subsidy' =>$e->uma_type_after_subsidy , 
                'tipopersona' =>$e->person_to_apply,
                'fecha_inicio'=>$e->fecha_inicio,
                'fecha_fin'=>$e->fecha_fin 
            );
        }
        return json_encode($response);
    }
    public function subsidioInsert(Request $request)
    {
        $response='false';
        $id_tramite=$request->id_tramite;
        $totaldespues=$request->totaldespues;
        $moneda=$request->moneda;
        $descripcion=$request->descripcion;
        $decretoficio=$request->decretoficio;
        $formato=$request->formato;
        $total=$request->total;
        $id_partida=$request->id_partida;
        $uma_type="ANUAL";
        $uma_type_after_subsidy="DIARIO";
        $tipopersona=$request->tipopersona;
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;

        try{
            $insert=$this->conceptsubsidiesdb->create(['id_procedure'=>$id_tramite,'total_after_subsidy'=>$totaldespues,'currency_total'=>$moneda,'subsidy_description'=>$descripcion,'no_subsidy'=>$decretoficio,'format'=>$formato,'total_max_to_apply'=>$total,'id_budget_heading'=>$id_partida,'uma_type'=>$uma_type,'uma_type_after_subsidy'=>$uma_type_after_subsidy,'person_to_apply'=>$tipopersona,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);
            $response = "true";

         } catch( \Exception $e ){
            Log::info('Error Method subsidioInsert: '.$e->getMessage());
            $response = "false";
        }
        return $response;

    }
    public function subsidioUpdate(Request $request)
    {
        $response='false';
        $id=$request->id;
        $id_tramite=$request->id_tramite;
        $total=$request->total;
        $moneda=$request->moneda;
        $descripcion=$request->descripcion;
        $decretoficio=$request->decretoficio;
        $formato=$request->formato;
        //log::info($formato);
        $totaldespues=$request->totaldespues;
        $id_partida=$request->id_partida;
        $uma_type="ANUAL";
        $uma_type_after_subsidy="DIARIO";
        $tipopersona=$request->tipopersona;        
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;

        try{
            $insert=$this->conceptsubsidiesdb->update(['id_procedure'=>$id_tramite,'total_after_subsidy'=>$totaldespues,'currency_total'=>$moneda,'subsidy_description'=>$descripcion,'no_subsidy'=>$decretoficio,'format'=>$formato,'total_max_to_apply'=>$total,'id_budget_heading'=>$id_partida,'uma_type'=>$uma_type,'uma_type_after_subsidy'=>$uma_type_after_subsidy,'person_to_apply'=>$tipopersona,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin],$id);
            $response = "true";

         } catch( \Exception $e ){
            Log::info('Error Method subsidioUpdate: '.$e->getMessage());
            $response = "false";
        }
        return $response;

    }
    public  function currenciesFindAll()
    {
        $response=array();
        $find=$this->currenciesdb->all();
        foreach ($find as $k) {
            $response []= array(
                'id' =>$k->id , 
                'nombre' =>$k->name  
            );
        }
        return json_encode($response);

    }
    public function partidasWhere(Request $request)
    {
        $response= array();
        $id_tramite=$request->id_tramite;
         $findpartida=$this->partidasdb->findWhere(['id_servicio'=>$id_tramite]);
         foreach ($findpartida as $part) {
            $response []= array(
                'id_partida' => $part->id_partida, 
                'id_servicio' => $part->id_servicio,
                'descripcion' => $part->descripcion 

            );
         }
         return json_encode($response);
    }

    public function applicablesubjectFindAll()
    {
        $response=array();
        $find=$this->applicablesubjectdb->all();
        foreach ($find as $i) {
            $response []= array(
                'id' => $i->id, 
                'nombre' => $i->name, 
            );
        }
        return json_encode($response);
    }
    public function calculoconceptoFindWhere(Request $request)
    {
        $id=$request->id;
        $response=array();
        $findConcepts=$this->conceptscalculationdb->findWhere(['id_procedure'=>$id]);
        foreach ($findConcepts as $i) {
            $response []= array(
                'id' => $i->id,
                'applicablesubject' => $i->id_applicable_subject,
                'id_partida' => $i->id_budget_heading,
                'metodo' => $i->method,
                'total' => $i->total,
                'precio_max' => $i->max_price,
                'precio_min' => $i->min_price,
                'is_right' => $i->is_right,
                'percent' => $i->percent,
                'formula' => $i->formula,
                'expiration' => $i->expiration,
                'has_expiration' => $i->has_expiration,
                'is_creditable' => $i->is_creditable,
                'concept_to_apply' => $i->concept_to_apply,
                'data' => $i->data,
                'id_tramite' => $i->id_procedure,
                'cantidad' => $i->quantity,
                'nombreconcepto' => $i->name_concept,
                'has_lot' => $i->has_lot,
                'lot_equivalence' => $i->lot_equivalence,
                'moneda_total' => $i->currency_total,
                'moneda_formula' => $i->currency_formula,
                'moneda_max' => $i->currency_max,
                'moneda_min' => $i->currency_min,
                'currency_lot_equivalence' => $i->currency_lot_equivalence,
                'subsidy_description' => $i->subsidy_description,
                'no_subsidy' => $i->no_subsidy,
                'has_max' => $i->has_max,
                'round_total' => $i->round_total,
                'redondeo_millar' => $i->round_amount_thousand
            );
        }
        return json_encode($response);
    }
    public function calculoconceptoInsert(Request $request)
    {
        //$id=$request->id;
        $response='false';
        $applicablesubject=$request->applicablesubject; //
        $id_partida=$request->id_partida; ///
        $metodo=$request->metodo; ///
        $total=$request->total; ///
        $precio_max=$request->precio_max; //
        $precio_min=$request->precio_min; //
        $is_right="1";
        $percent=NULL;
        $formula=$request->formula;///
        $expiration=NULL;
        $has_expiration="0";
        $is_creditable="1";
        $concept_to_apply="0";
        $data=NULL;
        $id_tramite=$request->id_tramite; ///
        $cantidad=$request->cantidad;  ///
        $nombreconcepto=$request->nombreconcepto; ///
        $has_lot=$request->has_lot; ////
        $lot_equivalence='0';
        $moneda_total=$request->moneda_total;///
        $moneda_formula=$request->moneda_formula; //
        $moneda_max=$request->moneda_max; //
        $moneda_min=$request->moneda_min; //
        $currency_lot_equivalence=NULL;
        $subsidy_description=NULL;
        $no_subsidy=NULL;
        $has_max=$request->has_max;
        $round_total=NULL;
        $redondeo_millar=$request->redondeo_millar; ///
        try{
        $findConcepts=$this->conceptscalculationdb->create(['id_applicable_subject'=>$applicablesubject,'id_budget_heading'=>$id_partida,'method'=>$metodo,'total'=>$total,'max_price'=>$precio_max,'min_price'=>$precio_min,'is_right'=>$is_right,'percent'=>$percent,'formula'=>$formula,'expiration'=>$expiration,'has_expiration'=>$has_expiration,'is_creditable'=>$is_creditable,'concept_to_apply'=>$concept_to_apply,'data'=>$data,'id_procedure'=>$id_tramite,'quantity'=>$cantidad,'name_concept'=>$nombreconcepto,'has_lot'=>$has_lot,'lot_equivalence'=>$lot_equivalence,'currency_total'=>$moneda_total,'currency_formula'=>$moneda_formula,'currency_max'=>$moneda_max,'currency_min'=>$moneda_min,'currency_lot_equivalence'=>$currency_lot_equivalence,'subsidy_description'=>$subsidy_description,'no_subsidy'=>$no_subsidy,'has_max'=>$has_max,'round_total'=>$round_total,'round_amount_thousand'=>$redondeo_millar]);
        $response = "true";

         } catch( \Exception $e ){
            Log::info('Error Method calculoconceptoInsert: '.$e->getMessage());
            $response = "false";
        }
        return $response;
            
    }
    public function calculoconceptoUpdate(Request $request)
    {
        $id=$request->id;
        $response='false';
        $applicablesubject=$request->applicablesubject;
        $id_partida=$request->id_partida;
        $metodo=$request->metodo;
        $total=$request->total;
        $precio_max=$request->precio_max;
        $precio_min=$request->precio_min;
        $is_right="1";
        $percent=NULL;
        $formula=$request->formula;
        $expiration=NULL;
        $has_expiration="0";
        $is_creditable="1";
        $concept_to_apply="0";
        $data=NULL;
        $id_tramite=$request->id_tramite;
        $cantidad=$request->cantidad;
        $nombreconcepto=$request->nombreconcepto;
        $has_lot=$request->has_lot;
        $lot_equivalence='0';
        $moneda_total=$request->moneda_total;
        $moneda_formula=$request->moneda_formula;
        $moneda_max=$request->moneda_max;
        $moneda_min=$request->moneda_min;
        $currency_lot_equivalence=NULL;
        $subsidy_description=NULL;
        $no_subsidy=NULL;
        $has_max=$request->has_max;
        $round_total=NULL;
        $redondeo_millar=$request->redondeo_millar;
        try{
        $findConcepts=$this->conceptscalculationdb->update(['id_applicable_subject'=>$applicablesubject,'id_budget_heading'=>$id_partida,'method'=>$metodo,'total'=>$total,'max_price'=>$precio_max,'min_price'=>$precio_min,'is_right'=>$is_right,'percent'=>$percent,'formula'=>$formula,'expiration'=>$expiration,'has_expiration'=>$has_expiration,'is_creditable'=>$is_creditable,'concept_to_apply'=>$concept_to_apply,'data'=>$data,'id_procedure'=>$id_tramite,'quantity'=>$cantidad,'name_concept'=>$nombreconcepto,'has_lot'=>$has_lot,'lot_equivalence'=>$lot_equivalence,'currency_total'=>$moneda_total,'currency_formula'=>$moneda_formula,'currency_max'=>$moneda_max,'currency_min'=>$moneda_min,'currency_lot_equivalence'=>$currency_lot_equivalence,'subsidy_description'=>$subsidy_description,'no_subsidy'=>$no_subsidy,'has_max'=>$has_max,'round_total'=>$round_total,'round_amount_thousand'=>$redondeo_millar],$id);
        $response = "true";

         } catch( \Exception $e ){
            Log::info('Error Method calculoconceptoUpdate: '.$e->getMessage());
            $response = "false";
        }
        return $response;
            
    }
    public function ConsultaWS()
    {
        $data=array();
        $json=array();

        $url_token_ = env('API_URL_TOKEN');
        $url_token=$url_token_;
        $username = env('API_USERNAME');
        $password = env('API_PASSWORD');
        $client = new \GuzzleHttp\Client();     
        $request = $client->request('POST',$url_token,  [
            'form_params' => array(
            'username' => $username,
            'password' => $password 
            )
        ]);
        $response = $request->getBody()->getContents();
        $response=json_decode($response);
        $token=$response->token;
        //log::info('TOKEN: '.$token);
        $data []= array(
            'id_procedure' => "19",
            'isai'=> "35",
            'valor_catastral'=> "100000.00",
            'valor_de_operacion'=> "495000.00",
            'no_lotes'=> "",
            'id_applicable_subject'=> "1",
            'copia_tramite'=> null,
            'reingresar'=> null,
            'oficio'=> "AFV2020",
            'tipo_persona'=>"Fisica",
            'array_reingresar'=>[]
            );
        $json=array("data"=>$data);
        /***************REQUEST******/
        $url_procedure=env('API_URL_PROCESS_PROCEDURE'); 
        $request_procedure = $client->request('POST',$url_procedure,[
        'form_params' => array(
            'access_token' => $token, 
            'json'=>$json
            )
        ]);
        $response_procedure = $request_procedure->getBody()->getContents();
        //$response_procedure=json_decode($response_procedure);
        //log::info($response_procedure);

    }
    public function entidadfamilia(Request $request)
    {
        $response=array();
        $id=$request->id;
        $findEntidadFamilia=$this->familiaentidaddb->findWhere(['familia_id'=>$id]);
        foreach ($findEntidadFamilia as $f) {
            $findEntidad=$this->entidaddb->findWhere(['id'=>$f->entidad_id]);
            foreach ($findEntidad as $e) {
               $response []=array(
                'id'=>$e->id,
                'nombre'=>$e->nombre
               ); 
            }
        }
        return json_encode($response);
    }

    public function insertEntidadTramites(Request $request)
    {

    }
    public function consultaTransaccionesTramites(Request $request){ 
        $rfc=$request->rfc;        
        $familia=$request->familia;     
        $servicio=$request->servicio;  
        $status=$request->status;   
        $fecha_inicio=$request->fecha_inicio.' 00:00:00';
        $fecha_fin=$request->fecha_fin.' 23:59:59';
        $notaria=$request->notaria;
        $response=array();
        $fechaActual=Carbon::now();
        

        if((int)$fecha_inicio==(int)"1")
        {           
            $fechaAterior=Carbon::now()->subDays(1);
            $fecha_inicio=$fechaAterior->format('Y-m-d').' 00:00:00';
            $fecha_fin=$fechaActual->format('Y-m-d').' 23:59:59';
        }
        if((int)$fecha_inicio==(int)"3")
        {           
            $fechaAterior=Carbon::now()->subDays(3);
            $fecha_inicio=$fechaAterior->format('Y-m-d').' 00:00:00';
            $fecha_fin=$fechaActual->format('Y-m-d').' 23:59:59';            
        }       
      
        if($fecha_inicio==" 00:00:00" && $fecha_inicio==" 23:59:59")
        {
            $fecha_inicio=$fechaActual->subYears(1);
            $fecha_inicio=$fecha_inicio->format('Y');
            $fecha_inicio=$fecha_inicio.'-01-01 00:00:00';
            $fecha_inicio=$fechaActual->format('Y-m-d').' 23:59:59';
          
        }


        $solicitudes = PortalSolicitudesTicket::with("mensajes")
        ->with("configusers");

       
        $solicitudes->with(["configusers.notary"
            =>function ($q){
                if($notaria!=null){
                    $q->where('notary_number',$notaria);
                }         

            }
        ]);
      
        $solicitudes->with("configusers.notary.titular:id,name,fathers_surname,mothers_surname,rfc")        
        ->leftjoin('portal.solicitudes_tramite as tramite', 'solicitudes_ticket.id_transaccion', '=', 'tramite.id')       
        // ->leftjoin('portal.config_user_notary_offices', 'solicitudes_ticket.user_id', '=', 'config_user_notary_offices.user_id')
        // ->leftjoin('portal.notary_offices', 'config_user_notary_offices.notary_office_id', '=', 'notary_offices.id')
        ->leftjoin("operacion.oper_transacciones as operTrans", 'operTrans.id_transaccion_motor', '=', 'tramite.id_transaccion_motor')   
        ->leftjoin("operacion.oper_tramites as opertram", 'opertram.id_transaccion_motor', '=', 'operTrans.id_transaccion_motor')
        ->leftjoin('operacion.oper_entidad as opentidad','opentidad.id','=','operTrans.entidad')   
        
        ->leftjoin('operacion.oper_familiaentidad as opfamen','opfamen.entidad_id','=','opentidad.id')
        ->leftjoin('operacion.oper_familia as opf','opf.id','=','opfamen.familia_id')
        
        ->leftjoin('egobierno.tipo_servicios as tiposer','tiposer.Tipo_Code','=','opertram.id_tipo_servicio')
        ->leftjoin('egobierno.tipopago as tipopag','tipopag.TipoPago','=','operTrans.tipo_pago')
        ->leftjoin('egobierno.status as status','.status.Status','=','operTrans.estatus') 
        ->select(
            'status.Descripcion as status',
            'operTrans.id_transaccion as idTrans',
            'opentidad.nombre as entidad',
            'tiposer.Tipo_Descripcion as tiposervicio',
            'opertram.nombre',
            'opertram.apellido_paterno',
            'opertram.apellido_materno',
            'operTrans.fecha_pago as fecha_transaccion',
    
            'operTrans.banco as BancoSeleccion',
            'tipopag.Descripcion as tipopago',
            'operTrans.importe_transaccion as TotalTramite',
            'tiposer.Tipo_Code as tiposervicio_id',
            'operTrans.estatus as estatus_id',
            'opertram.rfc as rfc',
            'opf.nombre as familia',
            'operTrans.id_transaccion_motor as folio',            
            'solicitudes_ticket.id',
            // 'notary_offices.titular_id',
            // 'notary_offices.substitute_id',
            'solicitudes_ticket.user_id',
            'solicitudes_ticket.status as status_ticket',
            'tramite.id_transaccion_motor',
            'solicitudes_ticket.created_at as fecha_creacion',
            'solicitudes_ticket.info',
            // 'notary_offices.notary_number',
            'tramite.id_ticket as tickets_relacion',
            'solicitudes_ticket.doc_firmado', 
            'solicitudes_ticket.clave',
            'solicitudes_ticket.grupo_clave'
    
            
        )    
        ->groupBy("solicitudes_ticket.id")
        ->whereBetween('operTrans.fecha_transaccion',[$fecha_inicio,$fecha_fin]);
   
        if($familia!='0'){
           $solicitudes->where('opf.id', $familia);
           
        }

        if($servicio!=0){
            $solicitudes->where('tiposer.Tipo_Code', $servicio);
            
        }
 
        if($status!='null'){
            $solicitudes->where('operTrans.estatus', $status);            
        }
        $solicitudes=$solicitudes->get();
        
        $campos_catalogo = [];
        foreach ($solicitudes as $key => &$value) {      
            if(isset($value->info)){  
                $value->info = json_decode($value->info);
                if(isset($value->info->campos)){
                    $campos_catalogo = array_merge($campos_catalogo, array_keys((array)$value->info->campos));        
                    $campos_catalogo = array_unique($campos_catalogo);
                    $catalogo = DB::connection('mysql6')->table('campos_catalogue')->select('id', 'descripcion','alias')
                    ->whereIn('id', $campos_catalogo)->get()->toArray();           
            
                    $campos = [];
                    foreach($value->info->campos as $key2 => $val){
                        if(is_numeric($key2)){
                            $key2 = $catalogo[array_search($key2, array_column($catalogo, 'id'))]->descripcion;
                            $campos[$key2] = $val;
                        } 
                        $value->info->campos = $campos;
                    }
                    
                }    
            }
        }    
        
        return json_encode($solicitudes);

    }

    public function asignarClavesCatalogo($info){
        $informacion = json_decode($info);
        $campos = [];
        if(isset($informacion->campos)){
          foreach($informacion->campos as $key=>$value){
            if(is_numeric($key)){
              $catalogo= $this->campo->select('descripcion')->where('id',$key)->first();
              $campos[$catalogo->descripcion] = $value;
            }else{
              $campos[$key] = $value;
            }

          }
          $informacion->campos = $campos;
        }

        return $informacion;
    }

}
