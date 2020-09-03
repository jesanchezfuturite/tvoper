<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\PortalcampoRepositoryEloquent;

class PortaltramitesController extends Controller
{
    //

	protected $campos;

    public function __construct(
    	PortalcampoRepositoryEloquent $campos
    )
    {
    	$this->campos = $campos;
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
			$cmp = $this->campos->findWhere(['descripcion'=> $desc]);

			if($cmp->count() > 0){

				Log::info($cmp->count());

				return response()->json(
					[
						"Code" => "400",
						"Message" => "Error, este campo ya existe",
					]
				);
			} else {

				$this->campos->create( ["descripcion" => $desc, "status" => 1] );

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
		$status = $request->status;

		try{

			$campo = $this->campos->update(["descripcion" => $desc, "status" => $status], $id);

			return response()->json(
				[
					"Code" => "200",
					"Message" => "Edición realizada con éxito",
				]
			);

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

}
