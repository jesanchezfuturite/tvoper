<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contdetimpisop.
 *
 * @package namespace App\Entities;
 */
class Contdetimpisop extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = "mysql5";
    protected $fillable = ['idTrans','Folio','rfcalf','rfcnum','rfchom','curp','nom_rs','cuenta','cve_imp','cve_mpo','tipo_dec','anio','mes``folio_anterior','imp_anterior','imp_ant_isop','imp_ant_erog','imp_ant_apu','num_comp','pre_isop','imp_pre_isop','act_pre_isop','rec_pre_isop','ttl_pre_isop','apu_isop','imp_apu_isop','act_apu_isop','rec_apu_isop','ttl_apu_isop','jys_isop','imp_jys_isop','act_jys_isop','`rec_jys_isop','ded_jys_isop','ttl_jys_isop','ttl_cont_isop'];
    protected $table = "det_imp_isop";

    public $timestamps = false;
}
