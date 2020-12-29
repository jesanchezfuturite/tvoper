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
use App\Repositories\PortaltramitecategoriaRepositoryEloquent;
use App\Repositories\PortaltramitecategoriarelacionRepositoryEloquent;

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
	protected $category;
	protected $relcat;

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
			PortalcamposagrupacionesRepositoryEloquent $agrupaciones,
			PortaltramitecategoriaRepositoryEloquent $category,
			PortaltramitecategoriarelacionRepositoryEloquent $relcat

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
			$this->category  = $category;
			$this->relcat = $relcat;
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
		$cp = $this->campos->findWhere(["status"=>"1"]);

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
			$rel = $this->camrel->searchRelation($request->tramiteid, $request->agrupacion_id);


			//Log::info($rel);
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
			$campoUp;
			$id_campo;

			$caract;
			$tipoCamp;

			$campo_id; $tipoid; $caracteristicas; $igual1; $igual2; $car;

			foreach ($request->campoid as $k => $v) {
				$tipoid=$request->tipoid[$k];
				$campo_id=$v;

				$caracteristicas=json_decode($request->caracteristicas[$k],true);				
			}
			//log::info($caracteristicas);
			$campoUp=$this->camrel->findWhere(['tramite_id'=>$request->tramiteid,'campo_id'=>$v]);
			foreach ($campoUp as $i) {
				$id_campo=$i->id;
				$caract= $i['caracteristicas'];
				$car= json_decode($caract,true);
				$tipoCamp=$i->tipo_id;
			}
			//log::info($caracteristicas);
			//log::info($car);
			//***************************//
			if($tipoCamp>=3 && $tipoCamp<=6)
			{
				$igual1=1;
			}else if($tipoCamp==1)
			{
				$igual1=2;
			}
			else{
				$igual1=3;
			}
			if($tipoid>=3 && $tipoid<=6)
			{
				$igual2=1;
			}else if($tipoid==1)
			{
				$igual2=2;
			}
			else{
				$igual2=3;
			}
			if($igual1==$igual2)
			{
				$caracteristicas=array_merge($car,$caracteristicas);
			}else if($tipoid>=3 && $tipoid<=6){
				$option=array('opciones' => []);
				$caracteristicas=array_merge($caracteristicas,$option);

			}else{
				$caracteristicas= $caracteristicas;
			}
			$caracteristicas= json_encode($caracteristicas);
			$in = array('tramite_id'=>$request->tramiteid,'campo_id'=>$campo_id,'tipo_id'=>$tipoid,'caracteristicas'=>$caracteristicas);
			if($id_campo==$request->id)
			{
				$this->camrel->where('id',$request->id)->update($in);
				return response()->json(["Code" => "200","Message" => "Campo actualizado"]);
			}else{
				if($campoUp->count()>0)
					{
						return response()->json(["Code" => "400","Message" => "El Campo ya existe."]);
					}else{
						$this->camrel->where('id',$request->id)->update($in);
						return response()->json(["Code" => "200","Message" => "Campo actualizado"]);
					}
			}

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
			$findCampo;
			foreach ($request->campoid as $k => $v) {

				$in[] = array('tramite_id'=>$request->tramiteid,'campo_id'=>$v,'tipo_id'=>$request->tipoid[$k],'orden'=>$request->orden,'agrupacion_id'=>$request->agrupacion_id,'caracteristicas'=>$request->caracteristicas[$k]);
				$findCampo=$this->camrel->findWhere(["tramite_id"=>$request->tramiteid,'campo_id'=>$v]);
			}
			if($findCampo->count()>0)
			{
				return response()->json(["Code" => "400","Message" => "El Campo ya existe."]);
			}else{
				$this->camrel->insert($in);
				return response()->json(["Code" => "200","Message" => "Registros Guardado."]);
			}

		} catch (\Exception $e) {
			Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());
			return response()->json(["Code" => "400","Message" => "Error al guardar el campo."]);
		}

	}

	public function guardarOrden(Request $request){

		try {
				$data = $request->data;

				foreach ($data as $d) {
					$id = $d['id'];

					$orden = $d['orden'];

					$save = $this->camrel->update(['orden'=>$orden], $id);

				}
				return response()->json(["Code" => "200","Message" => "Registros Actualizados."]);

		} catch (\Exception $e) {
			Log::info('Error Tramites - Guardar orden de campos: '.$e->getMessage());
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
  		$findCosto=$this->costotramitedb->findWhere(["tramite_id"=>$request->tramite,'status'=>'1']);
			if($findCosto->count()>0)
			{
				return response()->json(["Code" => "400","Message" => "El Tramite ya se encuentra Configurado."]);
			}
  		$this->costotramitedb->create(['tramite_id'=>$request->tramite,'tipo'=>$request->tipo,'tipo_costo_fijo'=>$request->tipo_costo_fijo,'costo'=>$request->costo,'costo_fijo'=>$request->fijo,'minimo'=>$request->minimo,'maximo'=>$request->maximo,'valor'=>$request->valor,'reglaoperativa_id'=>$request->regla_id,'vigencia'=>$request->vigencia,'status'=>'1']);
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
  		$id_find="";
  		$findCosto=$this->costotramitedb->findWhere(["id"=>$request->id]);
  		foreach ($findCosto as $e) {
  			$id_find=$e->tramite_id;
  		}
  		if($id_find==$request->tramite)
  		{
  			$this->costotramitedb->update(['tramite_id'=>$request->tramite,'tipo'=>$request->tipo, 'tipo_costo_fijo'=>$request->tipo_costo_fijo, 'costo'=>$request->costo,'costo_fijo'=>$request->fijo,'minimo'=>$request->minimo,'maximo'=>$request->maximo, 'valor'=>$request->valor, 'reglaoperativa_id'=>$request->regla_id,'vigencia'=>$request->vigencia,],$request->id);

  			return response()->json(["Code" => "200","Message" => "Registro Actualizado."]);
  		}else{
  			$findTramite=$this->costotramitedb->findWhere(['tramite_id'=>$request->tramite,'status'=>'1']);
  			if($findTramite->count()>0)
  			{
				return response()->json(["Code" => "400","Message" => "El Tramite ya se encuentra Configurado."]);
  			}else{
  				$this->costotramitedb->update(['tramite_id'=>$request->tramite,'tipo'=>$request->tipo, 'tipo_costo_fijo'=>$request->tipo_costo_fijo, 'costo'=>$request->costo,'costo_fijo'=>$request->fijo,'minimo'=>$request->minimo,'maximo'=>$request->maximo, 'valor'=>$request->valor, 'reglaoperativa_id'=>$request->regla_id,'vigencia'=>$request->vigencia,],$request->id);

  				return response()->json(["Code" => "200","Message" => "Registro Actualizado."]);
  			}
  		}
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
				$tipo = $request->tipo;
				// $nombre = 'Adriana';
				// $valor = 'ad';
			if($tipo==3 || $tipo==4 || $tipo==5 || $tipo==6)
			{
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
			}else if($tipo==1)
			{
				$registro = $this->camrel->findWhere(['id' => $id]);
				// $registro = $this->camrel->findWhere(['id' =>17]);
				foreach ($registro as $reg) {
					$caract = $reg['caracteristicas'];
					$car = json_decode($caract,true);
					$merg= array($nombre=>$valor);
					$car=array_merge($car,$merg);
				}
				$res =json_encode($car);
				//log::info($res);
				$update = $this->camrel->update(['caracteristicas'=>$res], $id);
			}else{
				return response()->json([
					"Code" => "200",
					"Message" => "No se puede agregar una caracteristica al tipo de campo"
				]);
			}
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

 	public function listarPartidas(){
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

		public function listarAgrupacion(Request $request){
			$tramite = $request->id_tramite;
			$data = $this->agrupaciones->where(['id_tramite' => $tramite])->orderBy('orden', 'ASC')->get();

			return json_encode($data);
		}
		public function guardarAgrupacion(Request $request){
			$descripcion = $request->descripcion;
			$tramite = $request->id_tramite;
			$tipo = $request->id_categoria;
			$orden = $request->orden;

			try{
				$existeAgrupacion = $this->agrupaciones->findWhere(['descripcion'=>$descripcion,'id_tramite'=>$tramite, 'id_categoria'=>$tipo]);
				if ($existeAgrupacion->count() == 0){
					$save = $this->agrupaciones->create(['descripcion'=>$descripcion,'id_tramite'=>$tramite, 'id_categoria'=>$tipo, 'orden'=>$orden]);
					return response()->json(["Code" => "200","Message" => "Registro Editado."]);
				}
				if($existeAgrupacion->count()>0){
					return response()->json(["Code" => "400","Message" => "Existe una Agrupacion con ese nombre."]);
				}				

				$existe = $this->relcat->where('tramite_id', $tramite)->where('categorias_id', $tipo)->get();
				if ($existe->count() == 0){
					$guardar = $this->relcat->create(['categorias_id'=>$tipo, 'tramite_id'=>$tramite]);
				}


				return response()->json(["Code" => "200","Message" => "Registro Guardado."]);

			}catch(\Exception $e){
				Log::info('Error Tramites - guardar Agrupacion: '.$e->getMessage());
			}

		}

		public function viewConfiguracion(){
			return view("portal/configuraciontramite");
		}

		public function listCategory(){
			try{
				$categories = $this->category->all();

				return json_encode($categories);

			}catch(\Exception $e){
				Log::info('Error Tramites - listar categorias: '.$e->getMessage());
			}
		}

	/**
 	* 	Esta funcion ya no se utiliza
	*   Guarda el campo del tramite que indica si requiere un archivo, este campo esta identificado en la tabla
 	*		portal.campos_type con el id #7 y su descripcion es File
 	*	@param Request POST
 	*
 	*	@return estatus de guradado o eliminado
 	*/
 public function addFile(Request $request){
		$option = $request->option;
		$tramite = $request->id_tramite;
		try{
			if($option == 1){ //si el valor de option es 1, se inserta el campo
					$grupo_id = $this->agrupaciones->create(['descripcion'=>'Documentos', 'id_tramite'=>$tramite, 'id_categoria'=>1])->id;

					$save = $this->camrel->create(['tramite_id'=>$tramite, 'campo_id'=>82, 'tipo_id'=>7,'caracteristicas'=>'{"required":"true"}', 'orden'=>1, 'agrupacion_id'=>$grupo_id]);

					return response()->json([
						"Code" => "200",
						"Message"=> "Opcion de archivo agregada"
					]);
			}else{ //si el valor de option es 2, se elimina el campo de Archivos
				$exist = $this->camrel->where('tramite_id',$tramite)->where('tipo_id',7)->delete();

				return response()->json([
					"Code" => "200",
					"Message"=> "Opcion de archivo eliminada"
				]);
			}

		}catch(\Exception $e){
			Log::info('Error Tramites - check para Archivos: '.$e->getMessage());
			return response()->json([
				"Code" => "400",
				"Message" => "Error al agregar campo archivo"
			]);
		}
 }
 	public function editAgrupacion(Request $request){
			$descripcion = $request->descripcion;
			$tramite = $request->id_tramite;
			$tipo = $request->id_categoria;
			$id = $request->id;

		try{
				$existe = $this->agrupaciones->findWhere(['descripcion'=>$descripcion,'id_tramite'=>$tramite, 'id_categoria'=>$tipo]);
				if ($existe->count() == 0){
					$guardar = $this->agrupaciones->update(['descripcion'=>$descripcion],$id);
					return response()->json(["Code" => "200","Message" => "Registro Editado."]);
				}else{
					return response()->json(["Code" => "400","Message" => "Existe una Agrupacion con ese nombre."]);
				}

		}catch(\Exception $e){
			Log::info('Error Tramites - guardar Agrupacion: '.$e->getMessage());
		}

	}
	public function saveOrdenAgrupacion(Request $request )
	{
		try {
				$data = $request->data;
				foreach ($data as $d) {
					$id = $d['id'];

					$orden = $d['orden'];

					$save = $this->agrupaciones->update(['orden'=>$orden], $id);

				}
				return response()->json(["Code" => "200","Message" => "Registros Actualizados."]);

		} catch (\Exception $e) {
			Log::info('Error Tramites - Guardar orden de campos: '.$e->getMessage());
		}
	}
}
