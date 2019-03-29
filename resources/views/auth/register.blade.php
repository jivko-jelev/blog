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
                        <form action="{{ route('register') }}" method="post">
                            <input type="text" name="name" class="form-control" placeholder="Username" id="name" required value="{{ old('name') }}">
                            <input type="email" name="email" class="form-control" placeholder="Email" id="email" required value="{{ old('email') }}">
                            <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" id="password_confirmation" required>
                            <select name="gender" class="form-control" required>
                                <option value="" disabled="disabled" selected>Select Gender</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            </select>
                            <input type="submit" class="btn btn-success btn-sm btn-block" value="Register">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
