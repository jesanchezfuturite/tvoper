<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PortalConfigUserNotaryOfficeRepository;
use App\Entities\PortalConfigUserNotaryOffice;
use App\Validators\PortalConfigUserNotaryOfficeValidator;

/**
 * Class PortalConfigUserNotaryOfficeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PortalConfigUserNotaryOfficeRepositoryEloquent extends BaseRepository implements PortalConfigUserNotaryOfficeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortalConfigUserNotaryOffice::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
