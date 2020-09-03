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

class PortaltramitesauxController extends Controller
{
    //

	protected $tramites;
	protected $campos;
	protected $camtip;
	protected $camrel;
	protected $tiposer;

    public function __construct(

    	PortalcampoRepositoryEloquent $campos,
    	PortalcampotypeRepositoryEloquent $campotipos,
    	PortalcamporelationshipRepositoryEloquent $camposrel,
    	EgobiernotiposerviciosRepositoryEloquent $tiposer

    )
    {
    	$this->middleware('auth');
    	$this->tiposer = $tiposer;
    	$this->campos = $campos;
    	$this->camtip = $campotipos;
    	$this->camrel = $camposrel;
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
		$sr = $this->tiposer->all();

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
		
		try {

			$rel = $this->camrel->findWhere(['id_tramite' => $request->tramiteid]);			
			
		} catch (\Exception $e) {
			Log::info('Error Tramites - listar campos relacion: '.$e->getMessage());
		}

		return json_encode($rel);
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
				
				$in[] = array('tramite_id'=>$request->tramiteid,'campo_id'=>$v[$k],'tipo_id'=>$request->tipoid[$k],'caracteristicas'=>$request->caracteristicas[$k]); 
			}

			$this->camrel->insert($in);
			
		} catch (\Exception $e) {
			Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());
		}

	}

}
