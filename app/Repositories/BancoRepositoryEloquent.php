<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BancoRepository;
use App\Entities\Banco;
use App\Validators\BancoValidator;

/**
 * Class BancoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BancoRepositoryEloquent extends BaseRepository implements BancoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banco::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
