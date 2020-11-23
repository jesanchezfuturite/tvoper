<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalcampotypeRepositoryEloquent;
use App\Repositories\PortalcamporelationshipRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;
use App\Repositories\EgobiernopartidasRepositoryEloquent;
// add
use App\Repositories\PortalcamposagrupacionesRepositoryEloquent;
use App\Repositories\PortalreglaoperativaRepositoryEloquent;
use App\Repositories\PortalcostotramitesRepositoryEloquent;
use App\Repositories\PortalsubsidiotramitesRepositoryEloquent;
use App\Repositories\UmahistoryRepositoryEloquent;

class PortaltramitesauxController extends Controller
{
    //

	protected $tramites;
	protected $campos;
	protected $camtip;
	protected $camrel;
	protected $tiposer;

	protected $costotramitedb;
	protected $subsidiotramitedb;
	protected $umadb;
	protected $partidas;
	protected $reglas;
	protected $files;
	protected $agrupaciones;

    public function __construct(

    	PortalcampoRepositoryEloquent $campos,
    	PortalcampotypeRepositoryEloquent $campotipos,
    	PortalcamporelationshipRepositoryEloquent $camposrel,
    	EgobiernotiposerviciosRepositoryEloquent $tiposer,
    	PortalcostotramitesRepositoryEloquent $costotramitedb,
    	PortalsubsidiotramitesRepositoryEloquent $subsidiotramitedb,
    	UmahistoryRepositoryEloquent $umadb,
			EgobiernopartidasRepositoryEloquent $partidas,
			PortalreglaoperativaRepositoryEloquent $reglas,
			PortalcamposagrupacionesRepositoryEloquent $agrupaciones

    )
    {
    	$this->middleware('auth');
    	$this->tiposer = $tiposer;
    	$this->campos = $campos;
    	$this->camtip = $campotipos;
    	$this->camrel = $camposrel;
    	$this->costotramitedb = $costotramitedb;
    	$this->subsidiotramitedb = $subsidiotramitedb;
    	$this->umadb = $umadb;
			$this->partidas = $partidas;
			$this->reglas = $reglas;
			$this->files = config('impuestos');
			$this->agrupaciones = $agrupaciones;
    }


    /**
     * 	Lista los tramites disponibles por catalogo
	 *
	 *	@param NULL datos iniciales de catalogo
	 *
	 *	@return json catalogo con ids
    */
    public function index()
    {

    	return view('portal/admincampos');
    }

	public function listarTramites()
	{
		$sr = $this->tiposer->findWhere([['id_gpm','>=','1']]);

		$response = array();

		try {

			foreach ($sr as $k => $v) {
				$response[] = array(
					'id' => $v['Tipo_Code'],
					'desc' => $v['Tipo_Descripcion']
				);
			}

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar servicios: '.$e->getMessage());
		}

		return json_encode($response);
	}

	/**
     * 	Lista los campos disponibles por catalogo
	 *
	 *	@param NULL datos iniciales de catalogo
	 *
	 *	@return json catalogo con ids
    */

	public function listarCampos()
	{
		$cp = $this->campos->all();

		$response = array();

		try {

			foreach ($cp as $k => $v) {
				$response[] = array(
					'id' => $v['id'],
					'desc' => $v['descripcion'],
					'st' => $v['status']
				);
			}

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar campos: '.$e->getMessage());
		}

		return json_encode($response);
	}


	/**
     * 	Lista los tipos de campo disponibles por catalogo
	 *
	 *	@param NULL datos iniciales de catalogo
	 *
	 *	@return json catalogo con ids
    */

	public function listarTipoCampos()
	{
		$tc = $this->camtip->all();

		$response = array();

		try {

			foreach ($tc as $k => $v) {
				$response[] = array(
					'id' => $v['id'],
					'desc' => $v['descripcion']
				);
			}

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());
		}

		return json_encode($response);
	}

	/**
     * Listar relacion de campos para un tramite
	 *
	 *	@param Request POST
	 *
	 *	@return json resultado por ID
    */

	public function listarRelacion(Request $request)
	{
		$rel=array();
		try {

			// $rel = $this->camrel->findWhere(['tramite_id' => $request->tramiteid]);
			$rel = $this->camrel->searchRelation($request->tramiteid);
			Log::info($rel);
		} catch (\Exception $e) {
			Log::info('Error Tramites - listar campos relacion: '.$e->getMessage());
		}

		return json_encode($rel);
	}

	/**
     * 	Edita el campo del tramite
	 *
	 *	@param Request POST
	 *
	 *	@return ??
    */

	public function editarTramite(Request $request)
	{

		try {

			foreach ($request->campoid as $k => $v) {

				$in = array('tramite_id'=>$request->tramiteid,'campo_id'=>$v,'tipo_id'=>$request->tipoid[$k],'caracteristicas'=>$request->caracteristicas[$k]);
			}

			$this->camrel->where('id',$request->id)->update($in);

			return response()->json(["Code" => "200","Message" => "campo actualizado"]);

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());

			return response()->json(["Code" => "400","Message" => "Error al editar el campo"]);
		}

	}

	/**
     * 	Borrar el campo del tramite
	 *
	 *	@param Request POST
	 *
	 *	@return ??
    */

	public function eliminarTramite(Request $request)
	{

		try {

			$this->camrel->where('id',$request->id)->delete();

			return response()->json(["Code" => "200","Message" => "Campo eliminado"]);

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());

			return response()->json(["Code" => "400","Message" => "Error al eliminar el campo"]);
		}

	}

	/**
     * 	Guarda el tramite creado con campos y caracteristicas
	 *
	 *	@param Request POST
	 *
	 *	@return ??
    */

	public function guardaTramite(Request $request)
	{

		try {

			foreach ($request->campoid as $k => $v) {

				$in[] = array('tramite_id'=>$request->tramiteid,'campo_id'=>$v,'tipo_id'=>$request->tipoid[$k],'caracteristicas'=>$request->caracteristicas[$k]);
			}

			$this->camrel->insert($in);

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());
		}

	}
	/****************************** COSTOS / SUBSIDIOS *******************************/
	public function Viewtipopagocosto()
    {
        return view('portal/tipopagocostos');
    }
  public function findTramites()
    {
    	$response=array();
    	$response=$this->camrel->findTramite();

    	return json_encode($response);
    }
  public function findCostos()
  {
  	$response=array();

  	$response=$this->costotramitedb->findCostotramites();
  	//dd($response);
  	return json_encode($response);
  }
  public function insertCostos(Request $request)
  {
  	try {

  		$this->costotramitedb->create(['tramite_id'=>$request->tramite,'tipo'=>$request->tipo,'costo'=>$request->costo,'costo_fijo'=>$request->fijo,'minimo'=>$request->minimo,'maximo'=>$request->maximo,'valor'=>$request->valor,'reglaoperativa_id'=>$request->regla_id,'vigencia'=>$request->vigencia,'status'=>'1']);
  		return response()->json(["Code" => "200","Message" => "Success"]);

		} catch (\Exception $e) {
			Log::info('Error PortaltramitesauxController - insertCostos: '.$e->getMessage());
			return response()->json(["Code" => "400","Message" => "Error al obtner insertar"]);
		}
  }
  public function updateCostos(Request $request)
  {
  	try {
  		//log::info($request);
  		$this->costotramitedb->update(['tramite_id'=>$request->tramite,'tipo'=>$request->tipo,'costo'=>$request->costo,'costo_fijo'=>$request->fijo,'minimo'=>$request->minimo,'maximo'=>$request->maximo, 'valor'=>$request->valor, 'reglaoperativa_id'=>$request->regla_id,'vigencia'=>$request->vigencia,],$request->id);

  		return response()->json(["Code" => "200","Message" => "Registro Actualizado."]);

		} catch (\Exception $e) {
			Log::info('Error PortaltramitesauxController - updateCostos: '.$e->getMessage());
			return response()->json(["Code" => "400","Message" => "Error al actualizar"]);
		}
  }
  public function updateStatusCostos(Request $request)
  {
  	try {
  		//log::info($request);
  		$this->costotramitedb->update(['status'=>'0'],$request->id);

  		return response()->json(["Code" => "200","Message" => "Registro Eliminado."]);

		} catch (\Exception $e) {
			Log::info('Error PortaltramitesauxController - updateStatusCostos: '.$e->getMessage());
			return response()->json(["Code" => "400","Message" => "Error al actualizar"]);
		}
  }
    public function findValorcuota()
    {
    	try
    	{
    		$response=array();
    		$date = Carbon::now();
        	$date = $date->format('Y');
    		$findUMA=$this->umadb->findWhere(['year'=>$date]);
        	if($findUMA->count()==0)
        	{
            	$date=$date-1;
           	 	$findUMA=$this->umadb->findWhere(['year'=>$date]);
        	}
        	//log::info($findUMA);
        	foreach ($findUMA as $u) {
            	$response=array('cuota_costo' =>$u->daily);
        	}
        	return json_encode($response);
        } catch (\Exception $e) {
			Log::info('Error PortaltramitesauxController - findValorcuota: '.$e->getMessage());
			return response()->json(["Code" => "400","Message" => "Error al consultar"]);
		}
    }
     public function updateSubsidio(Request $request)
    {
    	try {
    		if($request->id==''){
    			$this->subsidiotramitedb->create(['tramite_id'=>$request->tramite,'costo_id'=>$request->costo_id,'cuotas'=>$request->cuotas,'id_partida'=>$request->partida,'oficio'=>$request->oficio, 'limite_cuotas'=>$request->limite_cuotas]);

				return response()->json(["Code" => "200","Message" => "Registro Guardado."]);
    		}else{
    			$this->subsidiotramitedb->update(['tramite_id'=>$request->tramite,'costo_id'=>$request->costo_id,'cuotas'=>$request->cuotas,'id_partida'=>$request->partida, 'oficio'=>$request->oficio, 'limite_cuotas'=>$request->limite_cuotas],$request->id);
    			return response()->json(["Code" => "200","Message" => "Registro Actualizado."]);
    		}


		} catch (\Exception $e) {
			Log::info('Error PortaltramitesauxController - updateSubsidio: '.$e->getMessage());
			return response()->json(["Code" => "400","Message" => "Error al actualizar"]);
		}
    }

		public function addCaracteristics(Request $request){
			try{
				$id = $request->id;
				$nombre = $request->nombre;
				$valor = $request->valor;
				// $nombre = 'Adriana';
				// $valor = 'ad';


				$registro = $this->camrel->findWhere(['id' => $id]);
				// $registro = $this->camrel->findWhere(['id' =>17]);

				foreach ($registro as $reg) {
					$caract = $reg['caracteristicas'];
					$car = json_decode($caract);
					$req = $car->required;
					$c = $car->opciones;

					$c[] = array(
						$valor => $nombre
					);

					$caracteristicas = array(
						'required' => $req,
						'opciones'	=> $c
					);

				}

				$res = json_encode($caracteristicas);

				$update = $this->camrel->update(['caracteristicas'=>$res], $id);

				return response()->json([
					"Code" => "200",
					"Message" => "Se agrego correctamente"
				]);

			}catch(\Exception $e){
				Log::info('Error PortaltramitesauxController - addCaracteristics: '.$e->getMessage());
				return response()->json([
					"Code" => "400",
					"Message" => "Error al agregar"
				]);
			}
		}

		public function listarPartidas()
    {
			$sr = $this->partidas->get();

			$response = array();

			try {

				foreach ($sr as $k => $v) {
					$response[] = array(
						'id' => $v['id_partida'],
						'desc' => $v['descripcion']
					);
				}

			} catch (\Exception $e) {
				Log::info('Error Tramites - listar partidas: '.$e->getMessage());
			}

			return json_encode($response);
    }

		public function getReglas(){

			$data = $this->files;
			$name = array();
			foreach ($data as $key => $value) {
				$file = $key;

				$name [] = array(
					'name' => $file,
				);
			}

			//$data = $this->reglas->where('status',1)->get();

			return json_encode($name);
		}

		public function listarAgrupacion(){
			$data = $this->agrupaciones->all();

			return json_encode($data);
		}
		public function guardarAgrupacion(Request $request){
			$descripcion = $request->descripcion;

			try{
				$save = $this->agrupaciones->create(['descripcion'=>$descripcion]);

				return response()->json(["Code" => "200","Message" => "Registro Guardado."]);

			}catch(\Exception $e){
				Log::info('Error Tramites - guardar Agrupacion: '.$e->getMessage());
			}

		}

		public function viewConfiguracion(){
			return view("portal/configuraciontramite");
		}

}
