@extends('layouts.master')

@section('title')Edit Post @endsection

@section('styles')
    <script src="{{ URL::to('tinymce/tinymce.min.js?apiKey=2zjwtevlfe01bcwqb75sin0jjbaer8nod0itzcpv0mffikph') }}"></script>
@endsection


@section('content')
    <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
        @include('partials.left-menu')
        <div class="col-sm-8 col-sm-offset-1">
            @include('partials.session-messages')
            <form action="{{ route('blogs.update', urlencode($blog->permalink)) }}" class="form-inline" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}">
                <select name="category" id="" class="form-control">
                    @foreach(\App\Category::get() as $cat)
                        <option value="{{ $cat->id }}"
                                @if($cat->id==old('category', $blog->category_id)) selected="selected" @endif >{{ $cat->title }}</option>
                    @endforeach
                </select>
                <div style="margin: 10px 0 10px 0;">
                    <textarea name="description" id="description" style="margin-top: 20px;">{{ old('description', $blog->description) }}</textarea>
                </div>
                <input type="submit" class="btn btn-block btn-info" value="Save">
            </form>
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