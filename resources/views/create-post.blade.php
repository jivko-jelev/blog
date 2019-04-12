@extends('layouts.master')

@section('title')Create Post @endsection

@section('styles')
    <script src="{{ URL::to('tinymce/tinymce.min.js?apiKey=2zjwtevlfe01bcwqb75sin0jjbaer8nod0itzcpv0mffikph') }}"></script>
    <script type="text/javascript">
        var editor_config = {
            path_absolute : "{{ URL::to('/') }}/",
            selector: "#description",
            height: 500,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern codesample"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | fontselect | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code codesample",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
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
        <div class="col-sm-10">
            @include('partials.session-messages')
            <form action="{{ route('blogs.store') }}" method="post" class="form-inline">
                <input type="text" name="title" class="form-control" placeholder="Title">
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
