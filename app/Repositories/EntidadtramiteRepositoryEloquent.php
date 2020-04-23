<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EntidadtramiteRepository;
use App\Entities\Entidadtramite;
use App\Validators\EntidadtramiteValidator;
use Illuminate\Support\Facades\Log;

/**
 * Class EntidadtramiteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EntidadtramiteRepositoryEloquent extends BaseRepository implements EntidadtramiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Entidadtramite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function consultaCuenstasBanco($id,$idbanco)
    {
        try{        
        $data = Entidadtramite::where($id)
        ->join('oper_pagotramite','oper_pagotramite.tramite_id','=','oper_entidadtramite.tipo_servicios_id')    
        ->join('oper_cuentasbanco','oper_cuentasbanco.id','=','oper_pagotramite.cuentasbanco_id')
        ->join('oper_metodopago','oper_metodopago.id','=','oper_cuentasbanco.metodopago_id')
        ->where('oper_cuentasbanco.banco_id','=',$idbanco) 
        ->select('oper_pagotramite.cuentasbanco_id','oper_metodopago.nombre','oper_cuentasbanco.beneficiario','oper_cuentasbanco.monto_min','oper_cuentasbanco.monto_max')
        ->groupBy('oper_pagotramite.cuentasbanco_id','oper_metodopago.nombre','oper_cuentasbanco.beneficiario','oper_cuentasbanco.monto_min','oper_cuentasbanco.monto_max')
        ->get();

        return $data;
       
       }catch( \Exception $e){
            Log::info('[TramitesRepositoryEloquent@ConsultaRFC] Error ' . $e->getMessage());
        } 
    }
    public function consultaPagoTramite($id,$idcuenta)
    {
        try{        
        $data = Entidadtramite::where($id)
        ->join('oper_pagotramite','oper_pagotramite.tramite_id','=','oper_entidadtramite.tipo_servicios_id')    
        ->where('oper_pagotramite.cuentasbanco_id','=',$idcuenta) 
        ->select('oper_pagotramite.cuentasbanco_id','oper_pagotramite.descripcion','oper_pagotramite.fecha_inicio','oper_pagotramite.fecha_fin')
        ->groupBy('oper_pagotramite.cuentasbanco_id','oper_pagotramite.descripcion','oper_pagotramite.fecha_inicio','oper_pagotramite.fecha_fin')
        ->get();

        return $data;
       
       }catch( \Exception $e){
            Log::info('[TramitesRepositoryEloquent@ConsultaRFC] Error ' . $e->getMessage());
        } 
    }
}
