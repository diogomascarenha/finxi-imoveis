@extends('backend.layouts.app')
@section('scripts')
    <script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>
    <script src="//igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

    <script type="text/javascript">
        CKEDITOR.replace( 'descricao' );

        $( document ).ready(function() {
            $('#contato_telefone').mask('(00) 00000-0000');
            $('#preco_locacao').mask("###0.00", {reverse: true});
            $('#preco_condominio').mask("###0.00", {reverse: true});
            $('#preco_iptu').mask("###0.00", {reverse: true});


            $('#btnPesquisarEndereco').click(function(){

                $('#logradouro').val("");
                $('#bairro').val("");
                $('#localidade').val("");
                $('#uf').val("");

                var cep = $('#cep').val();
                if(cep == undefined){
                    cep = '00000000';
                }
                var url = 'https://viacep.com.br/ws/'+cep+'/json/';
                $.get( url, function( data ) {
                    if(data.erro == true){
                        return;
                    }
                    $('#logradouro').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#localidade').val(data.localidade);
                    $('#uf').val(data.uf);

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
                <ol class="breadcrumb">
                    <li><a href="{{route('backend.imovel.index')}}"><i class="fa fa-dashboard"></i> Imóvel</a></li>
                    <li class="active">Incluir</li>
                </ol>
            </div>
        </div>
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Incluir Imóvel</h3>
                </div>

                <form action="{{ route('backend.imovel.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="imoveis_status_id">Status</label>
                            <p class="form-control-static">
                                <select class="form-control select2" name="imoveis_status_id" required>
                                    @forelse($imoveisStatus as $imovelStatus)
                                        <option value="{{$imovelStatus->id}}"{{$imovelStatus->id == old('imoveis_status_id') ? "selected" : ""}}>{{$imovelStatus->descricao}}</option>
                                    @empty
                                        <option>Lista vazia</option>
                                    @endforelse
                                </select>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <p class="form-control-static">
                                <textarea name="descricao">{{old('descricao')}}</textarea>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="imagem">Imagem</label>
                            {{-- <p class="form-control-static"><img src="{{old('imagem')}}" alt="Imagem" class="src" width="400px"></p> --}}
                            <input type="file" name="imagem">
                        </div>
                        <div class="form-group">
                            <label for="contato_nome">Nome do Contato</label>
                            <p class="form-control-static">
                                <input type="text" name="contato_nome" value="{{old('contato_nome')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="contato_email">E-Mail do Contato</label>
                            <p class="form-control-static">
                                <input type="text" name="contato_email" value="{{old('contato_email')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="contato_telefone">Telefone do Contato</label>
                            <p class="form-control-static">
                                <input type="text" name="contato_telefone" id="contato_telefone" value="{{old('contato_telefone')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="preco_locacao">Preço Locação</label>
                            <p class="form-control-static">
                                <input type="text" name="preco_locacao" id="preco_locacao" value="{{old('preco_locacao')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="preco_condominio">Preço Condomínio</label>
                            <p class="form-control-static">
                                <input type="text" name="preco_condominio" id="preco_condominio" value="{{old('preco_condominio')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="preco_iptu">Preço IPTU</label>
                            <p class="form-control-static">
                                <input type="text" name="preco_iptu" id="preco_iptu" value="{{old('preco_iptu')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-inline">
                            <label for="cep">CEP</label><br>
                            <p class="form-control-static">
                                <input type="text" name="cep" id="cep" value="{{old('cep')}}" class="form-control">
                                <a href="#cep" class="btn btn-primary" id="btnPesquisarEndereco">Pesquisar Endereço</a>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="logradouro">Logradouro</label>
                            <p class="form-control-static">
                                <input type="text" name="logradouro" id="logradouro" value="{{old('logradouro')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="numero">Número</label>
                            <p class="form-control-static">
                                <input type="text" name="numero" value="{{old('numero')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <p class="form-control-static">
                                <input type="text" name="complemento" value="{{old('complemento')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="bairro">Bairro</label>
                            <p class="form-control-static">
                                <input type="text" name="bairro" id="bairro" value="{{old('bairro')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="localidade">Localidade</label>
                            <p class="form-control-static">
                                <input type="text" name="localidade" id="localidade" value="{{old('localidade')}}" class="form-control">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="uf">UF</label>
                            <p class="form-control-static">
                                <input type="text" name="uf" id="uf" value="{{old('uf')}}" class="form-control">
                            </p>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-primary" href="{{ route('backend.imovel.index') }}">Voltar</a>
                        <button type="submit" class="btn btn-success pull-right">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection