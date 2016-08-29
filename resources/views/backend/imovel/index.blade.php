@extends('backend.layouts.app')

@section('content')
    <div class="container">
        @include('partials.messages')
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="active">Imóvel</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-xs btn-success" href="{{ route('backend.imovel.create') }}">Incluir</a>
            <div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($imoveis->count())
                    <div class="box box-info">
                        <div class="box-body">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th title="Id">Id</th>
                                    <th title="Imagem">Imagem</th>
                                    <th title="Bairro">Bairro</th>
                                    <th title="Estado">UF</th>
                                    <th title="Preço Aluguel">Preço</th>
                                    <th title="Status">Status</th>
                                    <th title="Criado em">Criado</th>

                                    <th title="Opções" class="text-center">Opções</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($imoveis as $imovel)
                                    <tr>
                                        <td>{{$imovel->id}}</td>
                                        <td>
                                            <a href="{{$imovel->imagem}}" target="_blank"><img src="{{$imovel->imagem}}" alt="" class="src" width="50px"></a>
                                        </td>
                                        <td>{{$imovel->bairro}}</td>
                                        <td>{{$imovel->uf}}</td>
                                        <td>{{$imovel->preco_locacao}}</td>
                                        <td>{{$imovel->status->descricao}}</td>
                                        <td>{{ date('d/m/Y H:i', strtotime($imovel->created_at)) }}</td>

                                        <td class="text-right">
                                            <a class="btn btn-xs btn-primary" href="{{ route('backend.imovel.show', $imovel->id) }}">Exibir</a>
                                            <a class="btn btn-xs btn-warning" href="{{ route('backend.imovel.edit', $imovel->id) }}">Editar</a>
                                            <form action="{{ route('backend.imovel.destroy', $imovel->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja deletar esse imóvel?')) { return true } else {return false };">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-danger">Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="text-center">{!! $imoveis->render() !!}</div>

                @else
                    <h3 class="text-center alert alert-info">Você não possui imóveis cadastrados!</h3>
                @endif
            </div>
        </div>
    </div>
@endsection