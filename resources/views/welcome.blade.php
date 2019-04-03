@extends('layouts.master')

@section('title')
    {{ isset($title) ? $title : 'Welcome'  }}
@endsection

@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-10 col-lg-8">
            @include('partials.session-messages')
            @include('partials.search')
            @if(isset($blogs))
                @foreach($blogs as $blog)
                    <a href="{{ route( 'blogs.show', urlencode($blog->permalink)) }}"><h3
                                class="blog-title">{!! $blog->printtitle() !!}</h3></a>
                    <span>Posted by
                        <a href="{{ route('profile.user', \App\User::find($blog->user_id)->name) }}"><strong>{{ \App\User::find($blog->user_id)->name }}</strong></a>.
                        <a href="#"
                           title="{{ $blog->created_at->format('d-m-Y') }}"><strong>{!! App\Functions::humanReadableDateTime($blog->created_at) !!}</strong></a>.
                        In <a href="{{ strtolower(route('blogs.order1', $blog->category())) }}"><strong>{{ $blog->category() }}</strong></a> category. Has
                        @if(count($blog->comments)==0) 0 comments
                        @else <a href="{{ route( 'blogs.show', urlencode($blog->permalink)) }}#comments"
                                 class="comments">{!! count($blog->comments) !!}@if(count($blog->comments)>1)
                                comments @else comment @endif</a>
                        @endif
                    </span>
                    <div class="blog-description">{!! $blog->printDescription() !!}</div>

                    @if(Auth::check() && Auth::user()->isadmin())
                        <div style="display: inline-block;">
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="post" class="form-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs"
                                        style="background-color: brown; color: #fff;font-weight: bold;">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Remove
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('blogs.edit', urlencode($blog->permalink)) }}" role="button"
                           class="btn btn-info btn-xs" style="background-color: lightskyblue;font-weight: bold;"><i
                                    class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    @endif
                    <hr>
                @endforeach
                <div class="center-pagination">{{ $blogs->appends(request()->except('page'))->links() }}</div>
            @else
                <div style="text-align: center;">
                    <h2 style="color: #b94a48; text-align: center;">There is no such category!!!</h2>
                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default btn-lg">
                        <i class="fa fa-arrow-circle-o-left"></i>
                        Go Back
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
