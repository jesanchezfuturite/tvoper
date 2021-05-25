<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EstadosRepositoryEloquent;
use App\Repositories\MunicipiosRepositoryEloquent;

class CatalogosController extends Controller
{
    protected $estados;
    protected $municipios;

    public function __construct(
        EstadosRepositoryEloquent $estados,
		MunicipiosRepositoryEloquent $municipios
		
    )
    {
        $this->estados = $estados;
        $this->municipios = $municipios;
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
}