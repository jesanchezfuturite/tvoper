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
     * 	Guarda el tramite creado con campos y caracteristicas
	 *  
	 *	@param Request POST 
	 *
	 *	@return ??
    */

	public function guardaTramite(Request $request)
	{
		

		// try {

		// 	$this->camrel->create(['tramite_id'=>$request->trid,])
			
		// } catch (\Exception $e) {
		// 	Log::info('Error Tramites - listar tipo campos: '.$e->getMessage());
		// }

		return json_encode($request);
	}
}