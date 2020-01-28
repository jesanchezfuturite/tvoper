<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CurrenciesRepository;
use App\Entities\Currencies;
use App\Validators\CurrenciesValidator;

/**
 * Class CurrenciesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CurrenciesRepositoryEloquent extends BaseRepository implements CurrenciesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Currencies::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
