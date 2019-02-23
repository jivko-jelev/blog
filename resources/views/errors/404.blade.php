@extends('layouts.master')

@section('title')
    Error 404
@endsection

@section('content')
    <div class="container"style="text-align: center;">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="page_404">
                <h1 style="font-size: 120px;">404</h1>
                <p>Sorry, Page you're looking for is not found</p>
            </div>
        </div>
        <div class="col-sm-6 col-sm-offset-3">
            <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default btn-lg">
                <i class="fa fa-arrow-circle-o-left"></i>
                Go to Back
            </a>
        </div>
    </div>
@endsection