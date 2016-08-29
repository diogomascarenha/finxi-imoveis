<?php

namespace FinxiImoveis\Http\Controllers\Frontend;

use FinxiImoveis\Criteria\ImovelCriteria;
use FinxiImoveis\Entities\Imovel;
use FinxiImoveis\Repositories\ImovelRepositoryEloquent;
use Illuminate\Http\Request;

use FinxiImoveis\Http\Requests;
use FinxiImoveis\Http\Controllers\Controller;
use FinxiImoveis\Repositories\ImovelRepository;

class HomeController extends Controller
{
    /**
     * @var ImovelRepositoryEloquent
     */
    protected $imovelRepository;

    public function __construct(ImovelRepository $imovelRepository)
    {
        $this->imovelRepository = $imovelRepository;
    }

    public function index(Request $request)
    {

        $this->imovelRepository->pushCriteria(new ImovelCriteria($request));
        $imoveis = $this->imovelRepository->paginate();
        return view('frontend.home.index',compact('imoveis'));
    }

    public function show(Imovel $imovel)
    {
        if($imovel->status->ativo == false)
        {
            return redirect()->route('frontend.home.index')->withInput()->withErrors(collect(['Acesso Negado! Imóvel com status incompatível para visualização']));
        }
        return view('frontend.home.show',compact('imovel'));
    }
}
