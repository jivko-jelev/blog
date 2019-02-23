@if(session('errors'))
    <div class="col-sm-8 col-sm-offset-2">
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
@if(session('message'))
    <div class="col-sm-8 col-sm-offset-2">
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    </div>
@endif
