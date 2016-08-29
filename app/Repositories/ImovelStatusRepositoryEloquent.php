<?php

namespace FinxiImoveis\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use FinxiImoveis\Repositories\ImovelStatusRepository;
use FinxiImoveis\Entities\ImovelStatus;
use FinxiImoveis\Validators\ImovelStatusValidator;

/**
 * Class ImovelStatusRepositoryEloquent
 * @package namespace FinxiImoveis\Repositories;
 */
class ImovelStatusRepositoryEloquent extends BaseRepository implements ImovelStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImovelStatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
