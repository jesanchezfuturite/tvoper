<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobfoliosRepository;
use App\Entities\Egobfolios;
use App\Validators\EgobfoliosValidator;

/**
 * Class EgobfoliosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobfoliosRepositoryEloquent extends BaseRepository implements EgobfoliosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobfolios::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function consultaRFCegob($rfc)
    {
        //try{        
       $data = Egobfolios::where($rfc)
            ->join('transacciones','transacciones.idTrans', '=','folios.idTrans')       
            ->join('status','status.Status','=','transacciones.Status')
            ->join('operacion.oper_entidadtramite','operacion.oper_entidadtramite.tipo_servicios_id','=','transacciones.TipoServicio')
            ->join('operacion.oper_entidad','operacion.oper_entidad.id','=','operacion.oper_entidadtramite.entidad_id')
            ->join('tipo_servicios','tipo_servicios.Tipo_Code', '=','transacciones.TipoServicio')
            ->join('tipopago','tipopago.TipoPago', '=','transacciones.TipoPago')
            ->select('status.Descripcion as status','transacciones.idTrans','operacion.oper_entidad.nombre as entidad','tipo_servicios.Tipo_Descripcion as tiposervicio','transacciones.TitularTC','transacciones.fechatramite','transacciones.HoraTramite','transacciones.BancoSeleccion','tipopago.Descripcion as tipopago','transacciones.TotalTramite','transacciones.TipoServicio as tiposervicio_id','transacciones.Status as estatus_id','folios.CartKey1 as rfc','folios.CartKey2 as declarado')
            ->groupBy('folios.idTrans')
            ->get();
            return $data;
       
       /*}catch( \Exception $e){
            Log::info('[TramitesRepositoryEloquent@ConsultaRFC] Error ' . $e->getMessage());
        } */
    }
    
}