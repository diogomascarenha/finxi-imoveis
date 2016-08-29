@if (count($errors) > 0)
    <div class="row">
        <div class="col-md-12">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                    <li>{{ $error }}</li>
                </ul>
            </div>
            @endforeach
        </div>
    </div>
@endif

@if(Session::has('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!! session('message') !!}
            </div>
        </div>
    </div>
@endif
