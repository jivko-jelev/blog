@extends('layouts.master')

@section('title')Create Category @endsection

@section('content')

    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8 col-sm-offset-1">
            @include('partials.session-messages')
    @if(Auth::check())
            <div class="col-md-12" style="padding-left: 0; padding-right: 0;">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Category</div>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'category.store']) }}
                        {{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) }}
                        {{ Form::submit('Reply', array('class' => 'btn btn-success btn-block')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
    @else
        <p style="text-align: center;"><a href="{{ route('login') }}">Sign in</a> to participate in this thread!</p>
    @endif
        </div>
    </div>
    </div>
@endsection
