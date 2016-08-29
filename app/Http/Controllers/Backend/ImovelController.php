<?php

namespace FinxiImoveis\Http\Controllers\Backend;

use FinxiImoveis\Repositories\ImovelStatusRepository;
use Illuminate\Http\Request;

use FinxiImoveis\Http\Requests;
use FinxiImoveis\Http\Controllers\Controller;
use FinxiImoveis\Repositories\ImovelRepository;
use FinxiImoveis\Entities\Imovel;

use KamranAhmed\Geocode\Geocode;


class ImovelController extends Controller
{

    /**
     * @var \FinxiImoveis\Repositories\ImovelRepositoryEloquent
     */
    private $imovelRepository;
    /**
     * @var \FinxiImoveis\Repositories\ImovelStatusRepositoryEloquent
     */
    private $imovelStatusRepository;

    /**
     * @var Geocode
     */
    private $geoCode;

    public function __construct(ImovelRepository $imovelRepository, ImovelStatusRepository $imovelStatusRepository)
    {

        $this->imovelRepository       = $imovelRepository;
        $this->imovelStatusRepository = $imovelStatusRepository;

        $this->geoCode = new Geocode(env('GOOGLE_MAPS_KEY'));

    }

    public function index()
    {
        $imoveis = $this->imovelRepository->getByAuthenticatedUser(request());

        return view('backend.imovel.index', compact('imoveis'));
    }


    public function show(Imovel $imovel)
    {
        if (\Gate::denies('own', $imovel)) {
            return redirect()->route('backend.imovel.index')->withErrors(['Acesso Negado! Você não possui permissão para acessar esse imóvel']);
        }

        return view('backend.imovel.show', compact('imovel'));
    }

    public function edit(Imovel $imovel)
    {
        if (\Gate::denies('own', $imovel)) {
            return redirect()->route('backend.imovel.index')->withErrors(['Acesso Negado! Você não possui permissão para acessar esse imóvel']);
        }

        $imoveisStatus = $this->imovelStatusRepository->all();

        return view('backend.imovel.edit', compact('imovel', 'imoveisStatus'));
    }

    public function create()
    {
        $imoveisStatus = $this->imovelStatusRepository->findWhere(['ativo'=>true])->all();
        return view('backend.imovel.create', compact('imoveisStatus'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'imoveis_status_id' => 'required|integer',
            'descricao'         => 'required',
            'imagem'            => 'required',
            'contato_nome'      => 'required|max:255',
            'contato_email'     => 'required|email|max:255',
            'contato_telefone'  => 'required|max:20',
            'cep'               => 'required|min:8|max:8',
            'logradouro'        => 'required|max:255',
            'numero'            => 'required|max:255',
            'complemento'       => 'max:255',
            'bairro'            => 'max:255',
            'localidade'        => 'required|max:255',
            'uf'                => 'required|max:2',
            'preco_locacao'     => 'required|numeric',
            'preco_condominio'  => 'required|numeric',
            'preco_iptu'        => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('backend.imovel.create')->withInput()->withErrors($validator);
        }

        $data = $request->all();

        $url            = request()->file('imagem')->store('imagens/imoveis', 's3');
        $urlCompleta    = \Storage::disk('s3')->url($url);
        $data['imagem'] = $urlCompleta;


        $endereco   = [];
        $endereco[] = $data['logradouro'];
        $endereco[] = $data['numero'];
        if (isset($data['bairro']) && !empty($data['bairro'])) {
            $endereco[] = $data['bairro'];
        }
        $endereco[] = $data['localidade'];
        $endereco[] = $data['uf'];
        $endereco[] = 'Brasil';

        $enderecoGeoCode = implode(', ', $endereco);

        $geocode = $this->geoCode;

        // Get the details for the passed address
        $location = $geocode->get($enderecoGeoCode);
        $latitude = $location->getLatitude();
        $longitude = $location->getLongitude();

        $data['latitude'] = null;
        if(!empty($latitude)){
            $data['latitude'] = $latitude;
        }

        $data['longitude'] = null;
        if(!empty($longitude)){
            $data['longitude'] = $longitude;
        }

        $data['user_id'] = \Auth::user()->id;

        $imovel = $this->imovelRepository->create($data);

        return redirect()->route('backend.imovel.show', $imovel->id)->with('message', 'Imóvel incluído com sucesso.');
    }


    public function update(Request $request, Imovel $imovel)
    {
        if (\Gate::denies('own', $imovel)) {
            return redirect()->route('backend.imovel.index')->withErrors(['Acesso Negado! Você não possui permissão para acessar esse imóvel']);
        }

        $validator = \Validator::make($request->all(), [
            'imoveis_status_id' => 'required|integer',
            'descricao'         => 'required',
            'contato_nome'      => 'required|max:255',
            'contato_email'     => 'required|email|max:255',
            'contato_telefone'  => 'required|max:20',
            'cep'               => 'required|min:8|max:8',
            'logradouro'        => 'required|max:255',
            'numero'            => 'required|max:255',
            'complemento'       => 'max:255',
            'bairro'            => 'max:255',
            'localidade'        => 'required|max:255',
            'uf'                => 'required|max:2',
            'preco_locacao'     => 'required|numeric',
            'preco_condominio'  => 'required|numeric',
            'preco_iptu'        => 'required|numeric',
        ]);

        if ($validator->fails()) {

            return redirect()->route('backend.imovel.edit', $imovel->id)->withInput()->withErrors($validator);
        }

        $data = $request->all();
        if (isset($data['imagem']) && !empty($data['imagem'])) {
            $url            = request()->file('imagem')->store('imagens/imoveis', 's3');
            $urlCompleta    = \Storage::disk('s3')->url($url);
            $data['imagem'] = $urlCompleta;
        }

        $endereco   = [];
        $endereco[] = $data['logradouro'];
        $endereco[] = $data['numero'];
        if (isset($data['bairro']) && !empty($data['bairro'])) {
            $endereco[] = $data['bairro'];
        }
        $endereco[] = $data['localidade'];
        $endereco[] = $data['uf'];
        $endereco[] = 'Brasil';

        $enderecoGeoCode = implode(', ', $endereco);

        $geocode = $this->geoCode;

        // Get the details for the passed address
        $location = $geocode->get($enderecoGeoCode);
        $latitude = $location->getLatitude();
        $longitude = $location->getLongitude();

        $data['latitude'] = null;
        if(!empty($latitude)){
            $data['latitude'] = $latitude;
        }

        $data['longitude'] = null;
        if(!empty($longitude)){
            $data['longitude'] = $longitude;
        }

        $imovel->fill($data);

        $imovel->save();

        return redirect()->route('backend.imovel.show', $imovel->id)->with('message', 'Imóvel atualizado com sucesso.');
    }

    public function destroy(Imovel $imovel)
    {
        if (\Gate::denies('own', $imovel)) {
            return redirect()->route('backend.imovel.index')->withErrors(['Acesso Negado! Você não possui permissão para acessar esse imóvel']);
        }

        // TODO: Deletar imagem da Amazon

        $imovel->delete();

        return redirect()->route('backend.imovel.index', $imovel->id)->with('message', 'Imóvel excluído com sucesso.');
    }
}
