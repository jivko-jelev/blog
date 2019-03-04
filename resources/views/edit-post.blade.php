@extends('layouts.master')

@section('title')Edit Post @endsection

@section('styles')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=2zjwtevlfe01bcwqb75sin0jjbaer8nod0itzcpv0mffikph"></script>
@endsection


@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8 col-sm-offset-1">
            @include('partials.session-messages')
            {{ Form::open(['route' => ['blogs.update', $blog->permalink]], ['class' => 'form-inline']) }}
            {{ Form::hidden('_method', 'PUT') }}
            {{--{{ Form::label('title', 'Title') }}--}}
            {{ Form::text('title', old('title', $blog->title), ['class' => 'form-control']) }}
            <select name="category" id="" class="form-control">
                @foreach(\App\Category::get() as $cat)
                    <option value="{{ $cat->id }}"
                            @if($cat->id==old('category', $blog->category_id)) selected="selected" @endif >{{ $cat->title }}</option>
                @endforeach
            </select>
            <div style="margin: 10px 0 10px 0;">
                {{ Form::textarea('description', old('description', $blog->description), ['id'=>'description', 'class' => 'form-control', 'style'=> 'margin-top: 20px;']) }}
            </div>
            {{ Form::submit('Save', array('class' => 'btn btn-block btn-info')) }}
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        tinymce.init({
            selector: '#description',  // change this value according to your HTML
            plugins: 'codesample advlist autolink link image lists charmap print preview emoticons textcolor code',
            height: 300,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            toolbar: "undo redo | styleselect | bold italic underline | fontselect | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | code codesample | image emoticons",
            style_formats: [
                {
                    title: 'Image Left',
                    selector: 'p',
                    styles: {
                        'line-height': '1em'
                    }
                }
            ]
        });
    </script>
@endsection