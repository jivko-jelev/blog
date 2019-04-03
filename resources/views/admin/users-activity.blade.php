@extends('layouts.admin')

@section('title'){{ $user->name }} @endsection

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
            <li class="breadcrumb-item active">Users</li>
        </ol>
        @include('partials.admin-session-messages')
        <div class="container-fluid">
            <div class="animated fadeIn">
                <h1>{{ $user->name }}</h1>

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
                                    <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user_posts as $user_post)
                                        <tr>
                                            <td>{{ $user_post->id }}</td>
                                            <td><a href="{{ route('blogs.show', $user_post->permalink) }}">{{ $user_post->title }}</a></td>
                                            <td>{{ $user_post->created_at }}</td>
                                            <td>
                                                <form action="{{ route('comments.destroy', $user_post->id) }}" method="POST">
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


                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-align-justify"></i> Comments</div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-striped">
                                    <thead>
                                        <th>Post ID</th>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Created at</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    @foreach($user_comments as $user_comment)
                                        @if($user_comment->blog_id)
                                        <tr>
                                            <td>{{ $user_comment->blog_id }}</td>
                                            <td><a href="{{ route('blogs.show', $user_comment->permalink) }}">{{ $user_comment->title }}</a></td>
                                            <td>{{ $user_comment->message }}</td>
                                            <td>{{ $user_comment->created_at }}</td>
                                            <td>
                                                <form action="{{ route('comments.destroy', $user_comment->id) }}" method="POST">
                                                    <input class="btn btn-danger btn-sm" type="submit" id="submit" value="Delete" name="submit">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="DELETE" name="_method">
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </div>
@endsection
