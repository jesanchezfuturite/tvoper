<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Applicable_subjectRepository;
use App\Entities\ApplicableSubject;
use App\Validators\ApplicableSubjectValidator;

/**
 * Class ApplicableSubjectRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ApplicableSubjectRepositoryEloquent extends BaseRepository implements ApplicableSubjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApplicableSubject::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
