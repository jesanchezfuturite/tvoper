<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConceptsCalculationRepository;
use App\Entities\ConceptsCalculation;
use App\Validators\ConceptsCalculationValidator;

/**
 * Class ConceptsCalculationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConceptsCalculationRepositoryEloquent extends BaseRepository implements ConceptsCalculationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ConceptsCalculation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
