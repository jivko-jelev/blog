@extends('layouts.master')

@section('styles')
    <style type="text/css">
          input#email, input#password {
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
        input#email {
            background-image: url("{{ URL::to('envelope.png') }}");
        }
        input#password {
            background-image: url("{{ URL::to('padlock.png') }}");
        }
    </style>
@endsection

@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.session-messages')
        <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="border-top: 2px solid dodgerblue;">Login</div>
                    <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
