@extends('layouts.admin')

@section('title')Posts @endsection

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
            <li class="breadcrumb-item active">Posts</li>
        </ol>
        @include('partials.admin-session-messages')
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i> Posts</div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-striped">
                                    <thead>
                                    <th>Post ID</th>
                                    <th>Category</th>
                                    <th>Created at</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td><a href="{{ route('blogs.show', $post->permalink) }}">{{ $post->title }}</a></td>
                                            <td>{{ $post->created_at }}</td>
                                            <td><a href="{{ route('blogs.edit', $post->permalink) }}" class="btn btn-success btn-sm">Edit</a></td>
                                            <td>
                                                <form action="{{ route('comments.destroy', $post->id) }}" method="POST">
                                                    <input class="btn btn-danger btn-sm" type="submit" id="submit" value="Delete" name="submit">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="DELETE" name="_method">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
@endsection
