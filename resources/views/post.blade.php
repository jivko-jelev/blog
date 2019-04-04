@extends('layouts.master')

@section('title'){{ $blog->title() }}@endsection

@section('styles')
    <style>
        textarea.form-control {
            max-width: 100%;
        }
    </style>
    <script src="{{ URL::to('js/prism.js') }}"></script>
@endsection

@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8">
            @include('partials.session-messages')
            <div class="col-sm-12" style="border: 1px solid #ccc; padding: 0; margin-bottom: 10px;">
                <div class="blog-wrap">
                    <h1 class="blog-title2">{{ $blog->title }}</h1>
                    <div class="blog-info pull-right" style="margin-top: -11px; ">
                        <div class="form-inline">
                            <span style="color: lightgrey; font-weight: normal;">Published {{ App\Functions::humanReadableDateTime($blog->updated_at) }}
                                by </span>
                            <span style="color: lightgrey; font-weight: normal">
                                <strong><a href="{{ URL::to('profile/' . \App\User::find($blog->user_id)->name) }}">{{ \App\User::find($blog->user_id)->name }}</a>
                                </strong>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="blog-description">
                        <p>{!! $blog->description !!}</p>
                    </div>
                </div>
            </div>
            <p><a name="comments"></a></p>
            <div class="col-sm-12" style="padding: 0;">
                <h2>Comments</h2>
                <div class="comments-wrap">
                    @foreach ($blog->comments as $comment)
                        <div class="comment-wrap">
                            <div class="comment-header">
                                <span><i class="fa fa-user" aria-hidden="true"></i>
                                    <strong><a href="{{ URL::to('profile/' . $comment->authorName()) }}">{{ $comment->authorName() }}</a></strong>
                                </span>
                                <span style="color: lightgrey; font-weight: normal">{{ \App\Functions::humanReadableDateTime($comment->created_at) }}</span>
                                @if (Auth::check() && Auth::user()->isadmin())
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        <input type="submit" id="submit" value="Delete" name="submit"
                                               style="background-color: darkred; color:#fff; float: right; top: -22px; left: -10px; height: 20px; font-size: 11px; position:relative;">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="DELETE" name="_method">
                                    </form>
                                @endif
                            </div>
                            <div class="comment-body">{{ $comment->message }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if(Auth::check())
                <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
                    <div class="panel panel-default">
                        <div class="panel-heading">Add Comment</div>
                        <div class="panel-body">
                            <form action="{{ route('comments.store') }}" method="post">
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <textarea name="message" class="form-control" cols="30" rows="10"></textarea>
                                <input type="submit" class="btn btn-success btn-block" value="Send">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <p style="text-align: center;"><a href="{{ route('login') }}">Sign in</a> to participate in this thread!
                </p>
            @endif
        </div>
    </div>
@endsection
