@extends('layouts.master')

@section('title')@if($user) {{$user->name}} @else {{'Error'}} @endif @endsection

@section('content')
    <div class="col-sm-10" style="padding-top: 10px; margin-bottom: 50px; ">
        @include('partials.left-menu')
        <div class="col-sm-10">
        @include('partials.session-messages')
            @if($user!=null)
                <div class="settings-page settings-page-profile">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <h2 style="margin-bottom: 5px">&nbsp</h2>
                            <div style="border: 1px solid #ccc; padding: 10px;">
                                <div style="background-color: lightgrey;">
                                    <p style="text-align: center">
                                        @if($user->avatar !== null)
                                            <img src="{{ URL::to('uploads/avatars/' . $user->avatar) }}"
                                                 alt="profile-picture-of-user" class="img-responsive">
                                        @else
                                            <spam><i class="fa fa-user fa-5x"
                                                     style="color: white; text-align: center; margin: 20px 40px 20px 35px;"></i>
                                            </spam>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <h3><strong>{{ $user->name }}</strong></h3>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Date of registration: <strong>{{ $user->dateCreated() }}</strong>
                                </div>
                                <div class="panel-body">
                                    <p>Gender: <strong>{{ $user->gender }}</strong></p>
                                    </p>Email: <strong>{{ $user->email }}</strong></p>
                                </div>
                                <div style="padding: 10px 10px 10px 20px;">
                                    <div class="col-sm-9">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center;">
                    <h2 style="color: #b94a48; text-align: center;">There is no such user!!!</h2>
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-circle-o-left"></i>
                        Go Back
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

