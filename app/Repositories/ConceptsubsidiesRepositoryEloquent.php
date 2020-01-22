<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\conceptsubsidiesRepository;
use App\Entities\Conceptsubsidies;
use App\Validators\ConceptsubsidiesValidator;

/**
 * Class ConceptsubsidiesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConceptsubsidiesRepositoryEloquent extends BaseRepository implements ConceptsubsidiesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conceptsubsidies::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
