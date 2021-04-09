<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalcamporelationshipRepositoryEloquent;

class PortaltramitesController extends Controller
{
    //

	protected $campos;
	protected $camposreldb;

    public function __construct(
    	PortalcampoRepositoryEloquent $campos,
    	PortalcamporelationshipRepositoryEloquent $camposreldb
    )
    {
    	$this->campos = $campos;
    	$this->camposreldb = $camposreldb;
    }


   /*
	 *  listFields
	 *
   */

	public function listFields()
	{
		$cmp = $this->campos->all();

		$response = array();

		try{
	    foreach ($cmp as $t) {
	      $response []=array(
	        'id_campo'=> $t->id,
	        'campo' => $t->descripcion,
					'estatus' => $t->status,
	      );
	    }

	  }catch(\Exception $e){
	    Log::info('Error Operacion - ver Tramites: '.$e->getMessage());
	  }

		return view('portal/fieldtramites', ['data'=> $response]);
	}

	/*
	*  Add New Fields
	*/
	public function newField(Request $request){
		$desc = $request->campo;


		try{
			$cmp = $this->campos->findWhere(['descripcion'=> $desc, 'status'=>'1']);
			//log::info($cmp);
			if($cmp->count() > 0){

				//Log::info($cmp->count());

				return response()->json(
					[
						"Code" => "400",
						"Message" => "Error, este campo ya existe",
					]
				);
			} else {

				$insert=$this->campos->create( ["descripcion" => $desc, "status" => 1, "alias"=>'0'] );
				$this->campos->update(['alias'=>'f_' . $insert->id],$insert->id);
				return response()->json(
					[
						"Code" => "200",
    				"Message" => "Se agrego un nuevo campo",
					]
				);

			}

		}
		catch(\Exception $e){
			Log::info('Error Add New Field '.$e->getMessage());

		}

	}

	public function editField(Request $request){
		$desc = $request->campo;
		$id = $request->id_campo;

		try{
			$cmp = $this->campos->Where('descripcion',$desc)->where('status','1')->where('id','<>',$id)->get();

			if($cmp->count() > 0){

				return response()->json(
					[
						"Code" => "400",
						"Message" => "Error, ya existe un campo con este nombre",
					]
				);

			}
			else{
				$campo = $this->campos->update(["descripcion" => $desc], $id);

				return response()->json(
					[
						"Code" => "200",
						"Message" => "Edición realizada con éxito",
					]
				);
			}

		} catch(\Exception $e) {

			Log::info('Error Edit Field '.$e->getMessage());
			return response()->json(
				[
					"Code" => "400",
					"Message" => "Error al editar",
				]
			);
		}

	}

	public function fieldStatus(Request $request){
		$status = $request->status;
		$id = $request->id_campo;

		try{
			$findrel=$this->camposreldb->findCamposTramites($id);
			if($findrel->count()==0)
			{
				$campo = $this->campos->update(["status" => $status], $id);
				return response()->json(
					[
						"Code" => "200",
						"Message" => "Estatus Actualizado",
					]
				);
			}else{

				return response()->json(
					[
						"Code" => "400",
						"Message" => "Campo en uso en otros Tramites",
						"response"=>json_encode($findrel)
					]
				);
			}
			
		}
		catch(\Exception $e){
			Log::info('Error Edit Field '.$e->getMessage());
			return response()->json(
				[
					"Code" => "400",
					"Message" => "Error al actualizar estatus",
				]
			);
		}

	}

}
