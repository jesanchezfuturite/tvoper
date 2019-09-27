<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetalleisnprestadoraRepository;
use App\Entities\Contdetalleisnprestadora;
use App\Validators\ContdetalleisnprestadoraValidator;

/**
 * Class ContdetalleisnprestadoraRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetalleisnprestadoraRepositoryEloquent extends BaseRepository implements ContdetalleisnprestadoraRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetalleisnprestadora::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
