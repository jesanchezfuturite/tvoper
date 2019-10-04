<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Corte_ArchivosRepository;
use App\Entities\CorteArchivos;
use App\Validators\CorteArchivosValidator;

/**
 * Class CorteArchivosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CorteArchivosRepositoryEloquent extends BaseRepository implements CorteArchivosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CorteArchivos::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
