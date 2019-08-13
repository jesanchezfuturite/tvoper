<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EgobiernotransaccionesRepository;
use App\Entities\Egobiernotransacciones;
use App\Validators\EgobiernotransaccionesValidator;

/**
 * Class EgobiernotransaccionesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EgobiernotransaccionesRepositoryEloquent extends BaseRepository implements EgobiernotransaccionesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Egobiernotransacciones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
