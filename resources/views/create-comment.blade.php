@extends('layouts.master')

@section('title')Create Post @endsection

@section('content')

        @section('content')
            <div class="col-sm-6 col-sm-offset-3" style="border: 1px solid #ccc; padding: 0; max-width: 1023px; min-width: 800px;">
            @include('partials.session-messages')
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Create Post</div>
                        <div class="panel-body">
                            {{ Form::open(['route' => 'comments.store']) }}
                            {{ Form::select('category', App\Category::orderby('id')->pluck('title', 'id'), null, array('optgroup' => '', 'class' => 'form-control')) }}
                            {{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) }}
                            {{ Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => 'Description')) }}
                            {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-sm btn-block')) }}
                            {{ Form::close() }}
                        </div>
                    </div>
            </div>
        @endsection
    </div>
@endsection
