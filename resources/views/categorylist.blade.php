@extends('layouts.master')

@section('title')Create Category @endsection

@section('content')

    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8 col-sm-offset-1">
            @include('partials.session-messages')

    @if(Auth::user()->isadmin())
            <div class="col-sm-8 col-sm-offset-2" style="padding-left: 0; padding-right: 0;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="margin-bottom: 10px;">Edit/Delete Category</div>
                    @foreach(App\Category::all() as $category)
                        <div class="panel-body" style="padding: 0 10px 10px 10px;">
                           <table style="width: 100%;">
                               <tr>
                                <td style="width: 100%; padding-right: 10px;">
                                    {{ Form::open(['route' => ['category.update', $category->id], 'class' => 'form-inline']) }}
                                    {{ Form::hidden('_method', 'PUT') }}
                                    <input type="text" name="title" value="{{ $category->title }}" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="Title" style="width: 100%;"></td>
                                <td style="padding-right: 10px;">{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
                                {{ Form::close() }}</td>
                                <td>{{ Form::open(['route' => ['category.destroy', $category->id] , 'class' => 'form-inline']) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Delete', array('class' => 'btn btn-danger', 'style' => 'background-color: #af0e0e;')) }}
                                {{ Form::close() }}</td>
                               </tr>
                           </table>
                        </div>
                    @endforeach
                </div>
            </div>
    @else
        <p style="text-align: center;"><a href="{{ route('login') }}">Sign in</a> to participate in this thread!</p>
    @endif


        </div>
    </div>
@endsection
