@extends('layouts.app')
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
                title:"Endereço do Imóvel - {{$imovel->getIdFormatado()}}",
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
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <p class="form-control-static" title="Clique para Baixar a Imagem">
                            <a href="{{$imovel->imagem}}" target="_blank"><img src="{{$imovel->imagem}}" alt="Imagem" class="img-thumbnail" width="400px"></a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Descrição</strong></p>
                        {!! $imovel->descricao !!}
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Identificação do Imóvel:</strong>
                    </div>
                    <div class="col-md-8">
                        {{$imovel->getIdFormatado()}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Cadastrado Por:</strong>
                    </div>
                    <div class="col-md-8">
                        {{$imovel->user->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-8">
                        {{$imovel->status->descricao}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Preço Locação</strong>
                    </div>
                    <div class="col-md-8">
                        R$ {!! $imovel->getPrecoLocacaoFormatado() !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Preço Condomínio</strong>
                    </div>
                    <div class="col-md-8">
                        R$ {!! $imovel->getPrecoCondominioFormatado() !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Preço IPTU</strong>
                    </div>
                    <div class="col-md-8">
                        R$ {!! $imovel->getPrecoIptuFormatado() !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Contato - Nome</strong>
                    </div>
                    <div class="col-md-8">
                        {!! $imovel->contato_nome !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Contato - Telefone</strong>
                    </div>
                    <div class="col-md-8">
                        {!! $imovel->contato_telefone !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Contato - E-mail</strong>
                    </div>
                    <div class="col-md-8">
                        {!! $imovel->contato_email !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <strong>Endereço</strong>
                <p>
                    {{$imovel->getEndereco()}}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <strong>Mapa</strong>
                <div class="form-group" id="map-canvas"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-default" href="{{ route('frontend.home.index') }}">Voltar</a>
            </div>
        </div>
        @include('partials.rodape')
    </div>
@endsection