<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EstadosRepositoryEloquent;
use App\Repositories\MunicipiosRepositoryEloquent;
use App\Repositories\DistritosRepositoryEloquent;
use App\Repositories\DistritoRepositoryEloquent;
use App\Entities\Distritos;
use App\Entities\Distrito;
use App\Entities\Municipios;


class CatalogosController extends Controller
{
    protected $estados;
    protected $municipios;
    protected $distritos;
    protected $distrito;



    public function __construct(
        EstadosRepositoryEloquent $estados,
		MunicipiosRepositoryEloquent $municipios,
        DistritosRepositoryEloquent $distritos,
        DistritoRepositoryEloquent $distrito
		
    )
    {
        $this->estados = $estados;
        $this->municipios = $municipios;
        $this->distritos = $distritos;
    }

    public function getEntidad(){
        try {
            $estados = $this->estados->get(["clave", "nombre"])->toArray();
            if($estados){

             return json_encode($estados);

            }else{
                return json_encode(
                    [
                        "code" => 401,
                        "message" => "No hay registro de estados"
                    ]
                );
            }
        } catch (\Exception $e) {
            return json_encode(
                [
                    "code" => 400,
                    "message" => $e->getMessage()
                ]
            );
        }
    }

    
    public function getMunicipios($clave_estado){
        try {
            $municipios = $this->municipios->where("clave_estado", $clave_estado)->get(["clave", "nombre"])->toArray();
            if($municipios){

             return json_encode($municipios);

            }else{
                return json_encode(
                    [
                        "code" => 401,
                        "message" => "No hay registro de municipios"
                    ]
                );
            }
        } catch (\Exception $e) {
            return json_encode(
                [
                    "code" => 400,
                    "message" => $e->getMessage()
                ]
            );
        }
    }

    public function getDistrito($type, $clave){
        
        try {
            
            $distrito = Distritos::leftJoin("municipios", "distritos.municipio","=",  "municipios.clave")
            ->leftJoin("distrito", "distritos.distrito" ,"=" , "distrito.id")
            ->where("municipios.clave_estado", 19);

            if($type=="distrito"){
                $distrito->where("distrito.valor", $clave);
            }else{
                $distrito->where("municipios.clave", $clave)->where("distrito.valor", 1);
            }
           
            $distrito = $distrito->get()->toArray();

          
            if($distrito){

             return json_encode($distrito);

            }else{
                return json_encode(
                    [
                        "code" => 401,
                        "message" => "No hay registro de distritos"
                    ]
                );
            }
        } catch (\Exception $e) {
            return json_encode(
                [
                    "code" => 400,
                    "message" => $e->getMessage()
                ]
            );
        }
    }

    public function obtDistritos(){
        try {
            $distritos = Distrito::select("valor as clave", "descripcion as nombre")->get()->toArray();
         
            return json_encode($distritos);
        } catch (\Exception $e) {
            return json_encode(
                [
                    "code" => 400,
                    "message" => $e->getMessage()
                ]
            );
        }
    }
}