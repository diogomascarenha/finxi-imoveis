<?php

namespace FinxiImoveis\Repositories;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use FinxiImoveis\Repositories\ImovelRepository;
use FinxiImoveis\Entities\Imovel;
use FinxiImoveis\Validators\ImovelValidator;

/**
 * Class ImovelRepositoryEloquent
 * @package namespace FinxiImoveis\Repositories;
 */
class ImovelRepositoryEloquent extends BaseRepository implements ImovelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Imovel::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getByAuthenticatedUser($request)
    {
        $userId = $request->user()->id;
        return $this->model->with(['status'])->where(['user_id' => $userId])->orderBy('id', 'desc')->paginate();
        //return $this->model->with(['status'])->join('imoveis_status','imoveis_status.id','=','imoveis.imoveis_status_id')->where(['user_id'=>$userId])->where(['imoveis_status.ativo'=>true])->paginate();
    }

    public function getAllToFrontendHome($request)
    {
        $model = $this->model;
        $data  = $request->all();
        $model->with('status')->with('user');
        if(isset($data['pesquisa']) && !empty($data['pesquisa']))
        {

        }
        return $model->paginate();
    }
}
