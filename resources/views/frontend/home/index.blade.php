@extends('layouts.app')
@section('styles')
    <style>
        html,body {
            height:100%;
        }

        .row-flex, .row-flex > div[class*='col-'] {
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            flex:1 1 auto;
        }

        .row-flex-wrap {
            -webkit-flex-flow: row wrap;
            align-content: flex-start;
            flex:0;
        }

        .row-flex > div[class*='col-'], .container-flex > div[class*='col-'] {
            margin:-.2px; /* hack adjust for wrapping */
        }

        .container-flex > div[class*='col-'] div,.row-flex > div[class*='col-'] div {
            width:100%;
        }


        .flex-col {
            display: flex;
            display: -webkit-flex;
            flex: 1 100%;
            flex-flow: column nowrap;
        }

        .flex-grow {
            display: flex;
            -webkit-flex: 2;
            flex: 2;
        }
    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#btnPesquisarEndereco').click(function(){

                $('#endereco').val("");

                var cep = $('#cep_pesquisa').val();
                if(cep == undefined){
                    cep = '00000000';
                }
                var url = 'https://viacep.com.br/ws/'+cep+'/json/';
                $.get( url, function( data ) {
                    console.log(data);
                    if(data.erro == true){
                        return;
                    }
                    $('#endereco').val(
                            data.logradouro
                            + ', ' +
                            data.bairro
                            + ', ' +
                            data.localidade
                            + ', ' +
                            data.uf
                    );

                }, "json" );
            });
        });
    </script>
@endsection
@section('content')
    <div class="container">
        @include('partials.messages')
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#home">Pesquisa por Proximidade de Endereço</a></li>
                    <li><a data-toggle="pill" href="#menu1">Pesquisar Detalhada</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <form method="get" action="{{route('frontend.home.index')}}" class="form-inline">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <div>
                                    <label for="cep">CEP</label><br>
                                    <p class="form-control-static">
                                        <input type="text"  id="cep_pesquisa" name="cep_pesquisa" value="{{Request::get('cep_pesquisa')}}" class="form-control">
                                        <a href="#cep_pesquisa" class="btn btn-primary" id="btnPesquisarEndereco">Consultar</a>
                                    </p>
                                </div>
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Digite o Endereço" size="50" value="{{ Request::get('endereco')}}">
                                <select name="distancia" class="form-control">
                                    <option value="1"    {{( Request::get('distancia') == 1)   ?'selected':''}}>1 KM</option>
                                    <option value="5"    {{( Request::get('distancia') == 5)   ?'selected':''}}>5 KM</option>
                                    <option value="10"   {{( Request::get('distancia') == 10)  ?'selected':''}}>10 KM</option>
                                    <option value="15"   {{( Request::get('distancia') == 15)  ?'selected':''}}>15 KM</option>
                                    <option value="20"   {{( Request::get('distancia') == 20)  ?'selected':''}}>20 KM</option>
                                    <option value="50"   {{( Request::get('distancia') == 50)  ?'selected':''}}>50 KM</option>
                                    <option value="100"  {{( Request::get('distancia') == 100) ?'selected':''}}>100 KM</option>
                                    <option value="200"  {{( Request::get('distancia') == 200) ?'selected':''}}>200 KM</option>
                                    <option value="500"  {{( Request::get('distancia') == 500) ?'selected':''}}>500 KM</option>
                                    <option value="1000" {{( Request::get('distancia') == 1000)?'selected':''}}>1000 KM</option>
                                </select>
                                <button type="submit" class="btn btn-default">Pesquisar</button>
                            </div>


                        </form>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <form method="get" action="{{route('frontend.home.index')}}" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="cep">CEP</label>
                                <p class="form-control-static">
                                    <input type="text" name="cep" id="cep" value="{{Request::get('cep')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="logradouro">Logradouro</label>
                                <p class="form-control-static">
                                    <input type="text" name="logradouro" id="logradouro" value="{{Request::get('logradouro')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <p class="form-control-static">
                                    <input type="text" name="numero" value="{{Request::get('numero')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="complemento">Complemento</label>
                                <p class="form-control-static">
                                    <input type="text" name="complemento" value="{{Request::get('complemento')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="bairro">Bairro</label>
                                <p class="form-control-static">
                                    <input type="text" name="bairro" id="bairro" value="{{Request::get('bairro')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="localidade">Localidade</label>
                                <p class="form-control-static">
                                    <input type="text" name="localidade" id="localidade" value="{{Request::get('localidade')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="uf">UF</label>
                                <p class="form-control-static">
                                    <input type="text" name="uf" id="uf" value="{{Request::get('uf')}}" class="form-control">
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="reset" class="btn btn-danger">Limpar Formulário</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        @forelse($imoveis->chunk(3) as $imoveis_chunk)
            <div class="row row-flex row-flex-wrap">
                @foreach($imoveis_chunk as $imovel)
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img src="{{$imovel->imagem}}" class="img-responsive">
                            <div class="caption">
                                <h3><strong>Preço:</strong> R$ {{ $imovel->getPrecoLocacaoFormatado() }}</h3>
                                <h4><strong>Bairro:</strong> {{$imovel->bairro}}</h4>
                                <h4><strong>Localidade:</strong> {{$imovel->localidade}} / {{$imovel->uf}}</h4>
                                <h5><strong>Usuário:</strong> {{$imovel->user->name}}</h5>
                                <p>{!! $imovel->descricao  !!}</p>
                                <p><a href="{{route('frontend.home.show',$imovel->getIdFormatado())}}" class="btn btn-primary"
                                      role="button">Mais Info</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div>Nenhum imóvel cadastrado</div>
        @endforelse
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">{!! $imoveis->render() !!}</div>
            </div>
        </div>
        @include('partials.rodape')
    </div>
@endsection