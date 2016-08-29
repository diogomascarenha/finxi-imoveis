@extends('backend.layouts.app')
@section('styles')
    <style>
        html {
            height: 100%;
        }
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map-canvas {
            margin: 0;
            padding: 0;
            height: 400px;
            max-width: none;
        }
        #map-canvas img {
            max-width: none !important;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnMqQATIIxJLl9bVT5M_Hx2BMwOQP9KpU"></script>


    <script>
        // variável que indica as coordenadas do centro do mapa
        var coordenadasCentroDoMapa = new google.maps.LatLng({{$imovel->latitude}},{{$imovel->longitude}});

        // variável que indica as coordenadas do marcador
        var coordenadasPontoMarcado = new google.maps.LatLng({{$imovel->latitude}},{{$imovel->longitude}});

        function initialize() {
            var mapOptions = {
                center: coordenadasCentroDoMapa, // variável com as coordenadas Lat e Lng
                zoom: 19,
                mapTypeId: google.maps.MapTypeId.SATELLITE
            };
            var map = new google.maps.Map(document.getElementById("map-canvas"),
                    mapOptions);

            // variável que define o URL para a nova imagem do marcador
            var minhaImagem = 'images/farol.png';

            // variável que define as opções do marcador
            var marker = new google.maps.Marker({
                position: coordenadasPontoMarcado, // variável com as coordenadas Lat e Lng
                map: map,
                title:"Endereço do Imóvel",
                //icon: minhaImagem // define a nova imagem do marcador
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
@endsection
@section('content')
    <div class="container">
        @include('partials.messages')
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{route('backend.imovel.index')}}"><i class="fa fa-dashboard"></i> Imóvel</a></li>
                    <li class="active">Exibir</li>
                </ol>
            </div>
        </div>
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Exibir Imóvel</h3>
                </div>

                <form action="#">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Id</label>
                            <p class="form-control-static">{{$imovel->id}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Status</label>
                            <p class="form-control-static">{{$imovel->status->descricao}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Descrição</label>
                            <p class="form-control-static">{!! $imovel->descricao !!}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Imagem</label>
                            <p class="form-control-static" title="Clique para Baixar a Imagem">
                                <a href="{{$imovel->imagem}}" target="_blank"><img src="{{$imovel->imagem}}" alt="Imagem" class="src" width="400px"></a>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Nome do Contato</label>
                            <p class="form-control-static">{{$imovel->contato_nome}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">E-Mail do Contato</label>
                            <p class="form-control-static">{{$imovel->contato_email}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Telefone do Contato</label>
                            <p class="form-control-static">{{$imovel->contato_telefone}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Preço Locação</label>
                            <p class="form-control-static">R$ {{$imovel->preco_locacao}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Preço Condomínio</label>
                            <p class="form-control-static">R$ {{$imovel->preco_condominio}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Preço IPTU</label>
                            <p class="form-control-static">R$ {{$imovel->preco_iptu}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">CEP</label>
                            <p class="form-control-static">{{$imovel->cep}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Logradouro</label>
                            <p class="form-control-static">{{$imovel->logradouro}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Número</label>
                            <p class="form-control-static">{{$imovel->numero}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Complemento</label>
                            <p class="form-control-static">{{$imovel->complemento}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Bairro</label>
                            <p class="form-control-static">{{$imovel->bairro}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Localidade</label>
                            <p class="form-control-static">{{$imovel->localidade}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">UF</label>
                            <p class="form-control-static">{{$imovel->uf}}</p>
                        </div>

                        <div class="form-group">
                            <label for="nome">Latitude</label>
                            <p class="form-control-static">{{$imovel->latitude}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Longitude</label>
                            <p class="form-control-static">{{$imovel->longitude}}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Mapa</label>
                            <div class="form-group" id="map-canvas"></div>
                        </div>

                        <div class="form-group">
                            <label for="nome">Criado em</label>
                            <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($imovel->created_at)) }}</p>
                        </div>
                        <div class="form-group">
                            <label for="nome">Modificado em</label>
                            <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($imovel->updated_at)) }}</p>
                        </div>
                    </div>
                </form>

                <div class="box-footer">
                    <a class="btn btn-primary" href="{{ route('backend.imovel.index') }}">Voltar</a>

                    <form action="{{ route('backend.imovel.destroy', $imovel->id) }}" method="POST" style="display: inline;"
                          onsubmit="if(confirm('Deseja realmente deletar esse imóvel?')) { return true } else {return false };">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <a class="btn btn-warning btn-group" role="group" href="{{ route('backend.imovel.edit', $imovel->id) }}">Editar</a>
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection