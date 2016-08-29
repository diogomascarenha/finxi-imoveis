@extends('backend.layouts.app')

@section('content')
    <div class="container">
       <div class="col-md-4 col-md-offset-4">
           <a href="{{route('backend.imovel.index')}}" class="btn btn-primary btn-lg btn-block">Meus Imóveis</a>
       </div>
    </div>
@endsection