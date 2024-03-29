<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalcamporelationshipRepository;
use App\Entities\Portalcamporelationship;
use App\Validators\PortalcamporelationshipValidator;
use Illuminate\Support\Facades\Log;
/**
 * Class PortalcamporelationshipRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalcamporelationshipRepositoryEloquent extends BaseRepository implements PortalcamporelationshipRepository
{

    protected $db='egobierno';

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalcamporelationship::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function searchRelation($idrel, $idgroup)
    {
        try{

            $data = Portalcamporelationship::where(['tramite_id'=>$idrel])
            ->leftjoin('campos_type','campos_type.id','=','campos_relationship.tipo_id')
            ->leftjoin('campos_catalogue','campos_catalogue.id','=','campos_relationship.campo_id')
            // ->join('campos_agrupaciones','campos_relationship.agrupacion_id','=','campos_catalogue.id')
            ->select('campos_relationship.id','campos_type.id as tipo_id','campos_type.descripcion as tipo_nombre','campos_catalogue.id as campo_id','campos_catalogue.descripcion as campo_nombre','campos_relationship.orden as orden','campos_relationship.agrupacion_id as agrupacion_id','campos_relationship.caracteristicas')
            ->where('campos_relationship.agrupacion_id', $idgroup)
            ->orderBy('campos_relationship.orden', 'ASC')
            ->get();

            return $data;

       }catch( \Exception $e){
            Log::info('[PortalcamporelationshipRepositoryEloquent@searchRelation] Error ' . $e->getMessage());
        }
    }

    // public function searchGroup($idGroup){
    //   try{
    //
    //   }catch( \Exception $e){
    //        Log::info('[PortalcamporelationshipRepositoryEloquent@searchGroup] Error ' . $e->getMessage());
    //   }
    // }
    public function findTramite()
    {
        try{
        $data = Portalcamporelationship::select('campos_relationship.tramite_id as id',$this->db  . '.tipo_servicios.Tipo_Descripcion as nombre')
            ->leftjoin($this->db  . '.tipo_servicios',$this->db  . '.tipo_servicios.Tipo_Code','=','campos_relationship.tramite_id')
            ->groupBy('campos_relationship.tramite_id')
            ->get();

            return $data;
        }catch( \Exception $e){
            Log::info('[PortalcamporelationshipRepositoryEloquent@findTramite] Error ' . $e->getMessage());
        }
    }
    public function findCamposTramites($idcampo)
    {
        try{
        $data = Portalcamporelationship::select('campos_relationship.tramite_id as id',$this->db  . '.tipo_servicios.Tipo_Descripcion as nombre')
            ->leftjoin($this->db  . '.tipo_servicios',$this->db  . '.tipo_servicios.Tipo_Code','=','campos_relationship.tramite_id')
            ->where('campos_relationship.campo_id', $idcampo)
            ->groupBy('campos_relationship.tramite_id')
            ->get();

            return $data;
        }catch( \Exception $e){
            Log::info('[PortalcamporelationshipRepositoryEloquent@findTramite] Error ' . $e->getMessage());
        }
    }

}
