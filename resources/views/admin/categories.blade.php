@extends('layouts.admin')

@section('title')Categories @endsection

@section('styles')
    <style>
        .my-row{
            min-width: 384px;
        }
    </style>
@endsection

@section('content')
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">
                <a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Categories</li>
        </ol>
        @include('partials.admin-session-messages')
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                <div class="col-lg-4 my-row">
                    <div class="card">
                        <div class="card-header">
                            <strong>Edit/Delete Category</strong></div>
                            <div class="card-body">
                                <table class="col-md-12">
                                @foreach(App\Category::all() as $category)
                                        <tr>
                                            <form action="{{ route('category.update', $category->id) }}" class="form-inline" method="post">
                                                <td class="col-lg-6" style="padding-right: 10px;">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <input type="text" name="title" value="{{ $category->title }}" class="form-control form-control-sm mb-2 mr-sm-2 mb-sm-0" placeholder="Title" style="width: 100%;">
                                                </td>
                                                <td style="padding-right: 10px;">
                                                    <input type="submit" class="btn btn-sm btn-primary" value="Update">
                                                </td>
                                                {{ csrf_field() }}
                                            </form>
                                            <td>
                                                <form action="{{ route('category.destroy', $category->id) }}" class="form-inline" method="post">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                                </table>
                            </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Category</strong></div>
                            <form class="form-horizontal" action="{{ route('category.store') }}" method="post">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label col-form-label-sm" for="title">Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control form-control-sm" type="text" name="title" id="title" placeholder="Enter Category Name" value="{{ old('title') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary pull-right" type="submit">
                                        <i class="fa fa-dot-circle-o"></i> Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
