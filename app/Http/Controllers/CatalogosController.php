<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EstadosRepositoryEloquent;
use App\Repositories\MunicipiosRepositoryEloquent;
use App\Repositories\DistritosRepositoryEloquent;


class CatalogosController extends Controller
{
    protected $estados;
    protected $municipios;
    protected $distritos;


    public function __construct(
        EstadosRepositoryEloquent $estados,
		MunicipiosRepositoryEloquent $municipios,
        DistritosRepositoryEloquent $distritos
		
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
            $distrito = $this->distritos->where($type, $clave)->get(["distrito", "municipio"])->toArray();
          
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
}