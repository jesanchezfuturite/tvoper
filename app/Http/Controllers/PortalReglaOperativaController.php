<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Repositories\PortalreglaoperativaRepositoryEloquent;
use App\Repositories\PortalreglaoperativacamposRepositoryEloquent;
use App\Repositories\PortalcampoRepositoryEloquent;
use App\Repositories\PortalcamporelationshipRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

class PortalReglaOperativaController extends Controller
{
    //
    protected $reglaoperativa;
    protected $ro_cmps;
    protected $campos;
    protected $camposrel;
    protected $tiposer;

      public function __construct(
        PortalreglaoperativaRepositoryEloquent $reglaoperativa,
        PortalreglaoperativacamposRepositoryEloquent $ro_cmps,
        PortalcampoRepositoryEloquent $campos,
        PortalcamporelationshipRepositoryEloquent $camposrel,
      	EgobiernotiposerviciosRepositoryEloquent $tiposer
        )
      {
        $this->middleware('auth');
        $this->reglaoperativa = $reglaoperativa;
        $this->ro_cmps = $ro_cmps;
      	$this->campos = $campos;
        $this->camposrel = $camposrel;
        $this->tiposer = $tiposer;
      }

      public function index()
      {
        $tramites=$this->getTramites();
      	return view('portal/reglasoperativas',['tramites'=>json_decode($tramites,true)]);
      }

      public function getTramites(){

        $tramits = $this->camposrel->groupby('tramite_id')->get();
        //dd($tramits);
        $tmts = array();

        foreach ($tramits as $t) {
          $id_tramite = $t->tramite_id;
          $created_at = $t->created_at;
          $updated_at = $t->updated_at;

          $serv = $this->tiposer->where('Tipo_Code', $id_tramite)->get();
          foreach ($serv as $s) {
            $name = $s->Tipo_Descripcion;

            $tmts []=array(
              'id_tramite' => $id_tramite,
              'nombre' => $name
            );

          }
        }

        //dd($tmts);

        return json_encode($tmts);
      }

      public function getCampos(Request $request){
        $id_tmt = $request->id;
        //$id_tmt = 100;
        try{
          $rel = $this->camposrel->where('tramite_id', $id_tmt)->get();

        }catch(\Exception $e){
          Log::info('Error Portal - relacion campos: '.$e->getMessage());
          return response()->json(["Code" => "400","Message" => "Error"]);
        }
        return json_encode($rel);
      }

     /**
     * 	Lista las reglas disponibles por catalogo
  	 *
  	 *	@param NULL datos iniciales de catalogo
  	 *
  	 *	@return json catalogo con ids
     */
      public function getReglas(){
        try {
          $reglas = $this->reglaoperativa->get();

    		} catch (\Exception $e) {
    			Log::info('Error Reglas Operativas - listar reglas: '.$e->getMessage());
    		}
        return json_encode($reglas);
      }

      public function saveRegla(Request $request){
        $nombre = $request->nombre;
        $definicion = $request->definicion;

        try{
          $save = $this->reglaoperativa->create(['nombre'=>$nombre, 'definicion'=>$definicion, 'status'=>1]);
          return response()->json(["Code" => "200","Message" => "Success"]);
        }catch(\Exception $e){
          Log::info('Error Reglas Operativas - guardar reglas: '.$e->getMessage());
          return response()->json(["Code" => "400","Message" => "Error al insertar"]);
        }

      }

      public function deleteRegla(Request $request){
        $id = $request->id;
      }
}
