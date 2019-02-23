@extends('layouts.master')

@section('title'){{ Auth::user()->name }}@endsection

@section('content')
    <div class="col-sm-10" style="min-width: 790px; padding-top: 10px; border: 1px solid #ccc; margin-bottom: 50px; ">
            @include('partials.session-messages')
            <div class="settings-page settings-page-profile">
                <div class="col-sm-12">
                    <div class="col-lg-12">
                        <div class="col-sm-3">
                            <h2 translate>Avatar:</h2>
                            <div style="border: 1px solid #ccc; padding: 10px;">
                                <div style="background-color: lightgrey;">
                                    <p style="text-align: center">
                                    @if($user->avatar !== null)
                                        <img src="{{ URL::to('uploads/avatars/' . $user->avatar) }}" alt="profile-picture-of-user" class="img-responsive">
                                    @else
                                        <spam><i class="fa fa-user fa-5x" style="color: white; text-align: center; margin: 20px 40px 20px 35px;"></i></spam>
                                    @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <h3><strong>{{ $user->name }}</strong></h3>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Date of registration: <strong>{{ $user->dateCreated() }}</strong></div>
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
            </div>
    </div>
@endsection

