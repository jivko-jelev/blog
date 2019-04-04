@extends('layouts.admin')

@section('title')Dashboard @endsection

@section('styles')
@endsection

@section('content')
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">
                <a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li>
            <!-- Breadcrumb Menu-->
            <li class="breadcrumb-menu d-md-down-none">
                <div class="btn-group" role="group" aria-label="Button group">
                    <a class="btn" href="#">
                        <i class="icon-speech"></i>
                    </a>
                    <a class="btn" href="./">
                        <i class="icon-graph"></i>  Dashboard</a>
                    <a class="btn" href="#">
                        <i class="icon-settings"></i>  Settings</a>
                </div>
            </li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-6 col-md-2">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="h1 text-muted text-right mb-4">
                                    <i class="icon-people"></i>
                                </div>
                                <div class="text-value">{{ \App\User::all()->count() }}</div>
                                <small class="text-muted text-uppercase font-weight-bold">Registered Users</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-md-2">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="h1 text-muted text-right mb-4">
                                    <i class="icon-note"></i>
                                </div>
                                <div class="text-value">{{ \App\Blog::all()->count() }}</div>
                                <small class="text-muted text-uppercase font-weight-bold">Posts</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-md-2">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="h1 text-muted text-right mb-4">
                                    <i class="icon-speech"></i>
                                </div>
                                <div class="text-value">{{ \App\Comment::all()->count() }}</div>
                                <small class="text-muted text-uppercase font-weight-bold">Comments</small>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </div>
@endsection

@section('scripts')
@endsection