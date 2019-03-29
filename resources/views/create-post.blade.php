@extends('layouts.master')

@section('title')Create Post @endsection

@section('styles')
    <script src="{{ URL::to('tinymce/tinymce.min.js?apiKey=2zjwtevlfe01bcwqb75sin0jjbaer8nod0itzcpv0mffikph') }}"></script>
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
            <form action="{{ route('blogs.store') }}" method="post" class="form-inline">
                <div class="form-group">
                    <input type="text" name="title" class="form-control" placeholder="Title">
                </div>
                <select name="category" id="" class="form-control">
                    @foreach(\App\Category::get() as $cat)
                        <option value="{{ $cat->id }}" @if($cat->id==old('category')) selected="selected" @endif >{{ $cat->title }}</option>
                    @endforeach
                </select>
                <div style="margin: 10px 0 10px 0;">
                    <textarea name="description" id="description" class="form-control" style="margin-top: 20px;">{{old('description')}}</textarea>
                </div>
                <input type="submit" class="btn btn-block btn-info" value="Save">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
