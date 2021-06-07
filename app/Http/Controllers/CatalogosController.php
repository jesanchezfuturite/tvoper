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
use App\Entities\Registradores;
use App\Entities\TramitePorRegistrador;
use App\Repositories\InstitucionesRepositoryEloquent;
use App\Repositories\UsersRepositoryEloquent;
use App\Repositories\PortalSolicitudesTicketRepositoryEloquent;
use App\Repositories\TramitePorRegistradorRepositoryEloquent;
use App\Repositories\RegistradoresRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

class CatalogosController extends Controller
{
    protected $estados;
    protected $municipios;
    protected $distritos;
    protected $distrito;
    protected $instituciones;
    protected $users;
    protected $ticket;
    protected $tramitePorRegistrador;
    protected $registradores;
    protected $catalogo;
    protected $tiposer;


    public function __construct(
        EstadosRepositoryEloquent $estados,
		MunicipiosRepositoryEloquent $municipios,
        DistritosRepositoryEloquent $distritos,
        DistritoRepositoryEloquent $distrito,
        InstitucionesRepositoryEloquent $instituciones,
        UsersRepositoryEloquent $users,
        PortalSolicitudesTicketRepositoryEloquent $ticket,
        TramitePorRegistradorRepositoryEloquent $tramitePorRegistrador,
        RegistradoresRepositoryEloquent $registradores,
        PortalsolicitudescatalogoRepositoryEloquent $catalogo,
        EgobiernotiposerviciosRepositoryEloquent $tiposer

    )
    {
        $this->estados = $estados;
        $this->municipios = $municipios;
        $this->distritos = $distritos;
        $this->instituciones = $instituciones;
        $this->users = $users;
        $this->ticket = $ticket;
        $this->tramitePorRegistrador = $tramitePorRegistrador;
        $this->registradores = $registradores;
        $this->catalogo = $catalogo;
        $this->tiposer = $tiposer;
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

    public function getInstituciones(){
        try {
            $instituciones = $this->instituciones->get()->toArray();

            return json_encode($instituciones);
        } catch (\Exception $e) {
            return json_encode(
                [
                    "code" => 400,
                    "message" => $e->getMessage()
                ]
            );
        }
    }
    public function getRegion($id_ticket, $user_id){
        try {
            $user = $this->users->where('id', $user_id)->first();
            $registrador= $user->portal_registrador_id;
            $registrador = json_decode($registrador);
            $solicitud = $this->ticket->where('id' , $id_ticket)->first();
            $catalogo_id = $this->catalogo->where('tramite_id', $solicitud->catalogo_id)->first();
            $tramite_id = $this->tiposer->where('Tipo_Code', $catalogo_id)->first();

            $info = json_decode($solicitud->info);
            $municipio="";
            if(isset($info->camposConfigurados)){
                $campos = $info->camposConfigurados;
                $key2 = array_search("Municipio", array_column($campos, 'nombre'));
                if(isset($key2)){
                    $municipio = $campos[$key2]->valor[0]->municipio;
                }
            }
            $registradores = TramitePorRegistrador::select("registradores.id as id_registrador", "registradores.municipios_id",
            "registradores.descripcion" , "tramites_por_registrador.registrador_id", "tramites_por_registrador.tramite_id",
            "tramites_por_registrador.region_id")
            ->leftJoin("registradores", "tramites_por_registrador.registrador_id", "=", "registradores.id")
            ->whereIn("registradores.id", $registrador)
            ->where("tramites_por_registrador.tramite_id", 100)
            ->get();


            $data=[];
            foreach ($registradores as $key => $value) {
                $municipio_id = json_decode($value->municipios_id);
                $mun = in_array($municipio, $municipio_id);
                    if($mun){
                        $data[]=$value;
                    }
            }
           return  json_encode($data, JSON_UNESCAPED_SLASHES);

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
