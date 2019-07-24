<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TiporeferenciaRepository;
use App\Entities\Tiporeferencia;
use App\Validators\TiporeferenciaValidator;

/**
 * Class TiporeferenciaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TiporeferenciaRepositoryEloquent extends BaseRepository implements TiporeferenciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tiporeferencia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
