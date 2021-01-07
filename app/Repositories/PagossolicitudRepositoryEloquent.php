<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PagossolicitudRepository;
use App\Entities\Pagossolicitud;
use App\Validators\PagossolicitudValidator;

/**
 * Class PagossolicitudRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PagossolicitudRepositoryEloquent extends BaseRepository implements PagossolicitudRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pagossolicitud::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
