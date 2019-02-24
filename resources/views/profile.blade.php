@extends('layouts.master')

@section('title'){{ Auth::user()->name }}@endsection

@section('content')
    <div class="col-sm-10" style="padding-top: 10px; border: 1px solid #ccc; margin-bottom: 50px; ">
            @include('partials.session-messages')
            <div class="settings-page settings-page-profile">
                <div class="col-sm-12">
                    <div class="col-lg-12">
                        <div class="col-sm-3">
                            <div style="border: 1px solid #ccc; padding: 10px; margin-top: 30px;">
                                <div>
                                    <p style="text-align: center;">
                                    @if(Auth::user()->avatar !== null)
                                        <img src="{{ URL::to('uploads/avatars/' . Auth::user()->avatar) }}" alt="profile-picture-of-user" class="img-responsive" style=" margin: 0 auto">
                                    @else
                                        <spam><i class="fa fa-user fa-5x" style="color: white; text-align: center; margin: 20px 40px 20px 35px;"></i></spam>
                                    @endif
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('add.profile.photo') }}"  enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="PUT">
                                    <input type="file" name="image" id="image" accept="image/*" onchange="this.form.submit()" style="display: none;" />
                                    <input type="submit" class="btn btn-group-justified btn-info" value="Промени" onclick="document.getElementById('image').click(); return false">
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-9" style="margin-top: 30px;">
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading"><strong>{{ Auth::user()->name }}</strong></div>
                                <div class="panel-body">
                                    <p>Date of registration: <strong>{{ Auth::user()->dateCreated() }}</strong></p>
                                    <p>Gender: <strong>{{ Auth::user()->gender }}</strong></p>
                                </div>
                                <div style="padding: 10px 10px 10px 20px;">
                                    {{ Form::open(['route' => 'profile.update']) }}
                                    <div class="form-group row">
                                        {{ Form::label('email', 'Email', array('class' => 'col-sm-3 form-control-label', 'style' => 'margin-top: 14px;')) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('email', Auth::user()->email, array('id'=>'email','class' => 'form-control', 'placeholder' => 'Email')) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{ Form::label('password', 'Password', array('class' => 'col-sm-3 form-control-label', 'style' => 'margin-top: 14px;')) }}
                                        <div class="col-sm-9">
                                            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'id' => 'password')) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{ Form::label('password_confirmation', 'Password', array('class' => 'col-sm-3 form-control-label', 'style' => 'margin-top: 14px;')) }}
                                        <div class="col-sm-9">
                                            {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Password Confirmation', 'id' => 'password_confirmation')) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 col-sm-offset-8">
                                            {{ Form::submit('Save', array('class' => 'btn btn-success btn-block', 'style' => 'float: right;')) }}
                                        </div>
                                    </div>
                                    {{ Form::hidden('_method', 'PUT') }}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

