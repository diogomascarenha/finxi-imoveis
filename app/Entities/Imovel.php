<?php

namespace FinxiImoveis\Entities;

use FinxiImoveis\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Imovel extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'imoveis';
    protected $fillable = ['user_id', 'imoveis_status_id', 'descricao',
        'contato_nome', 'contato_email', 'contato_telefone', 'imagem',
        'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'localidade', 'uf',
        'preco_locacao', 'preco_condominio', 'preco_iptu',
        'latitude', 'longitude'
    ];

    public function status()
    {
        return $this->belongsTo(ImovelStatus::class, 'imoveis_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getEnderecoGeoCode()
    {
        $endereco = [];
        if (isset($this->logradouro) && !empty($this->logradouro)) {
            $endereco[] = $this->logradouro;
        }

        if (isset($this->numero) && !empty($this->numero)) {
            $endereco[] = $this->numero;
        }

        if (isset($this->bairro) && !empty($this->bairro)) {
            $endereco[] = $this->bairro;
        }

        if (isset($this->localidade) && !empty($this->localidade)) {
            $endereco[] = $this->localidade;
        }

        if (isset($this->uf) && !empty($this->uf)) {
            $endereco[] = $this->uf;
        }

        $endereco[] = 'Brasil';

        return implode(', ', $endereco);
    }

    public function getEndereco()
    {
        $endereco = [];
        if (isset($this->logradouro) && !empty($this->logradouro)) {
            $endereco[] = $this->logradouro;
        }

        $complemento = '';
        if (isset($this->complemento) && !empty($this->complemento)) {

            $complemento = ' - ' . $this->complemento;
        }

        if (isset($this->numero) && !empty($this->numero)) {
            $numero = $this->numero . $complemento;
        }


        if (isset($this->bairro) && !empty($this->bairro)) {
            $endereco[] = $this->bairro;
        }

        if (isset($this->localidade) && !empty($this->localidade)) {
            $endereco[] = $this->localidade;
        }

        if (isset($this->uf) && !empty($this->uf)) {
            $endereco[] = $this->uf;
        }

        $endereco[] = 'Brasil';

        if (isset($this->cep) && !empty($this->cep)) {
            $endereco[] = 'CEP: ' . $this->getCepFormatado();
        }

        return implode(', ', $endereco);
    }

    public function getIdFormatado()
    {
        return str_pad($this->id,10,'0',STR_PAD_LEFT);
    }

    public function getCepFormatado()
    {

        if (!isset($this->cep) || empty($this->cep) || strlen($this->cep) <> 8) {
            return '';
        }

        return substr($this->cep, 0, 5) . '-' . substr($this->cep, 5, 3);
    }

    public function getPrecoLocacaoFormatado()
    {
        return number_format($this->preco_locacao,2,',','.');
    }

    public function getPrecoCondominioFormatado()
    {
        return number_format($this->preco_condominio,2,',','.');
    }

    public function getPrecoIptuFormatado()
    {
        return number_format($this->preco_iptu,2,',','.');
    }
}
