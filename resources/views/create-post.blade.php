@extends('layouts.master')

@section('title')Create Post @endsection

@section('styles')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=2zjwtevlfe01bcwqb75sin0jjbaer8nod0itzcpv0mffikph"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#description',
            theme: 'modern',
            height: 300,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor code codesample'
            ],
            toolbar: 'fontselect | insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' + 'link image | print preview media fullpage | forecolor backcolor emoticons | code codesample',
        });
    </script>
    <style>
        form > select, form > input {
            margin-bottom: 10px;
        }
    </style>
@endsection


@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8 col-sm-offset-1">
            @include('partials.session-messages')
            {{ Form::open(['route' => 'blogs.store'], ['method'=>'post', 'class' => 'form-inline']) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) }}
            <select name="category" id="" class="form-control">
                @foreach(\App\Category::get() as $cat)
                    <option value="{{ $cat->id }}" @if($cat->id==old('category')) selected="selected" @endif >{{ $cat->title }}</option>
                @endforeach
            </select>
            <div style="margin: 10px 0 10px 0;">
                {{ Form::textarea('description', old('description'), ['id'=>'description', 'class' => 'form-control', 'style'=> 'margin-top: 20px;']) }}
            </div>
            {{ Form::button('Save', array('type'=>'submit','class' => 'btn btn-block btn-info')) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
