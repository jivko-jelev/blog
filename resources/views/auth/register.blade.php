@extends('layouts.master')

@section('title')Register @endsection

@section('styles')
    <style type="text/css">
        input#name, input#email, input#password, input#password_confirmation {
            color: #5a5854;
            background-color: #f2f2f2;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
            padding: 5px 5px 5px 35px !important;
            background-repeat: no-repeat;
            background-position: 8px 9px;
            display: block;
            margin-bottom: 10px;
        }
        input:focus, input:hover {
            background-color: #ffffff;
            border: 1px solid #b1e1e4;
        }
        input#name {
            background-image: url("{{ URL::to('avatar.png') }}");
        }
        input#email {
            background-image: url("{{ URL::to('envelope.png') }}");
        }
        input#password, input#password_confirmation {
            background-image: url("{{ URL::to('padlock.png') }}");
        }
    </style>
@endsection

@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8 col-sm-offset-1">
            @include('partials.session-messages')
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="border-top: 2px solid dodgerblue;">Register</div>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'register']) }}
                        {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Username', 'id' => 'name')) }}
                        {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email', 'id' => 'email')) }}
                        {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'id' => 'password')) }}
                        {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Password Confirmation', 'id' => 'password_confirmation')) }}
                        {{ Form::select('gender', [null => 'Select Gender', 'female' => 'female', 'male' => 'male'], null, array('class' => 'form-control')) }}
                        {{ Form::submit('Register', array('class' => 'btn btn-success btn-sm btn-block')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
