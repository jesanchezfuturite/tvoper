<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContdetalleisnretenedorRepository;
use App\Entities\Contdetalleisnretenedor;
use App\Validators\ContdetalleisnretenedorValidator;

/**
 * Class ContdetalleisnretenedorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContdetalleisnretenedorRepositoryEloquent extends BaseRepository implements ContdetalleisnretenedorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contdetalleisnretenedor::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
