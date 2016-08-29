<?php

namespace FinxiImoveis\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

use KamranAhmed\Geocode\Geocode;

/**
 * Class ImovelCriteria
 * @package namespace FinxiImoveis\Criteria;
 */
class ImovelCriteria implements CriteriaInterface
{

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {

        // TODO: Tratar SQL Injection

        $data = $this->request->all();

        if (isset($data['cep']) && !empty($data['cep'])) {
            $model = $model->where('cep', 'like', '%' . $data['cep'] . '%');
        }

        if (isset($data['logradouro']) && !empty($data['logradouro'])) {
            $model = $model->where('logradouro', 'like', '%' . $data['logradouro'] . '%');
        }

        if (isset($data['bairro']) && !empty($data['bairro'])) {
            $model = $model->where('bairro', 'like', '%' . $data['bairro'] . '%');
        }

        if (isset($data['localidade']) && !empty($data['localidade'])) {
            $model = $model->where('localidade', 'like', '%' . $data['localidade'] . '%');
        }

        if (isset($data['uf']) && !empty($data['uf'])) {
            $model = $model->where('uf', 'like', '%' . $data['uf'] . '%');
        }

        if (isset($data['descricao']) && !empty($data['descricao'])) {
            $model = $model->where('descricao', 'like', '%' . $data['descricao'] . '%');
        }

        if (isset($data['endereco']) && !empty($data['endereco'])) {
            $geocode           = new Geocode(env('GOOGLE_MAPS_KEY'));
            $location          = $geocode->get($data['endereco']);
            $data['latitude']  = $location->getLatitude();
            $data['longitude'] = $location->getLongitude();
        }

        if (
            isset($data['latitude']) && !empty($data['latitude'])
            &&
            isset($data['longitude']) && !empty($data['longitude'])
            &&
            isset($data['distancia']) && !empty($data['distancia'])
        ) {

            // TODO: Tratar SQL Injection
            $latitude  = $data['latitude'];
            $longitude = $data['longitude'];
            $distancia = $data['distancia'];

            \DB::statement('DROP TABLE IF EXISTS tmp_imoveis_distancia');
            \DB::statement('

                              CREATE TEMPORARY TABLE tmp_imoveis_distancia AS (
                                                                                  SELECT id,
                                                                                         (6371 * acos(
                                                                                                       cos( radians(' . $latitude . ') )
                                                                                                       * 
                                                                                                       cos( radians( latitude ) )
                                                                                                       * 
                                                                                                       cos( radians( longitude ) - radians(' . $longitude . ') )
                                                                                                       + 
                                                                                                       sin( radians(' . $latitude . ') )
                                                                                                       * 
                                                                                                       sin( radians( latitude ) ) 
                                                                                                     )
                                                                                        ) AS distancia
                                                                                    FROM imoveis
                                                                              );
            ');

            $model = $model->whereRaw('
                                         imoveis.id IN (
                                                            SELECT id 
                                                              FROM tmp_imoveis_distancia
                                                             WHERE distancia < ' . $distancia . '
                                                       )
                                     ');
        }

        $model = $model->selectRaw('imoveis.*')->with(['status', 'user'])->join('imoveis_status', 'imoveis_status.id', '=', 'imoveis.imoveis_status_id')->where(['imoveis_status.ativo' => true]);

        return $model;
    }
}
