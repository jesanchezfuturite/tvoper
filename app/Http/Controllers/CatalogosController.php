<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EstadosRepositoryEloquent;
use App\Repositories\MunicipiosRepositoryEloquent;
use App\Repositories\DistritosRepositoryEloquent;
use App\Entities\Distritos;
use App\Entities\Municipios;


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
            
            $distrito = Distritos::leftJoin("municipios", "distritos.municipio","=",  "municipios.clave")
            ->where("municipios.clave_estado", 19);

            if($type=="distrito"){
                $distrito->where("distritos.distrito", $clave);
            }else{
                $distrito->where("municipios.clave", $clave)->where("distritos.distrito", 1);
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
}