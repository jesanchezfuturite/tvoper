<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalsolicitudescatalogoRepository;
use App\Entities\Portalsolicitudescatalogo;
use App\Validators\PortalsolicitudescatalogoValidator;
use Illuminate\Support\Facades\Log;

/**
 * Class PortalsolicitudescatalogoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalsolicitudescatalogoRepositoryEloquent extends BaseRepository implements PortalsolicitudescatalogoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portalsolicitudescatalogo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function findSolicitudes($user,$padre_id,$status)
    {
        try{  
        $c1="=";      
        $c2="=";
        if($user==null)
        {
            $c1="<>";
        }   
        if($status==null)
        {
            $c2="<>";
        } 
        //log::info($c2);  
        $data = Portalsolicitudescatalogo::select("solicitudes_catalogo.id","solicitudes_responsables.user_id", "solicitudes_catalogo.titulo", "solicitudes_catalogo.padre_id","solicitudes_ticket.status")
        ->join('solicitudes_ticket',  'solicitudes_catalogo.id', '=','solicitudes_ticket.catalogo_id')
        ->join('solicitudes_responsables',  'solicitudes_responsables.catalogo_id', '=','solicitudes_catalogo.id')        
        ->where("solicitudes_responsables.user_id",$c1,$user)
        ->where("solicitudes_ticket.status",$c2,$status)
        ->where("solicitudes_catalogo.padre_id","=",$padre_id)
        ->groupBy('solicitudes_catalogo.id')
        ->get()->toArray();

        return $data;
       
       }catch( \Exception $e){
            Log::info('[PortalsolicitudescatalogoRepositoryEloquent@findSolicitudes] Error ' . $e->getMessage());
        } 
    }
    
}
