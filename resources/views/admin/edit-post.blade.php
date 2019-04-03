@extends('layouts.admin')

@section('title')Users @endsection

@section('styles')
    <style>
        .my-row{
            min-width: 384px;
        }
    </style>
    <script src="{{ URL::to('tinymce/tinymce.min.js?apiKey=2zjwtevlfe01bcwqb75sin0jjbaer8nod0itzcpv0mffikph') }}"></script>
@endsection

@section('content')
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">
                <a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Edit Post</li>
        </ol>
        @include('partials.admin-session-messages')
        <div class="container-fluid">
            <div class="animated fadeIn">

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Edit Post - <strong>{{ $blog->title }}</strong></div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <form action="{{ route('blogs.update', $blog->permalink) }}" class="form-horizontal" method="post">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="input-small">Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="input-small">Category</label>
                                        <div class="col-sm-10">
                                            <select name="category" id="" class="form-control">
                                                @foreach(\App\Category::get() as $cat)
                                                    <option value="{{ $cat->id }}"
                                                            @if($cat->id==old('category', $blog->category_id)) selected="selected" @endif >{{ $cat->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="input-small">Date</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" id="date-input" type="text" name="date-input" placeholder="date" value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->updated_at)->format('d-m-Y H:i') }}">
                                        </div>
                                    </div>

                                    <div style="margin: 10px 0 10px 0;">
                                        <textarea name="description" id="description" style="margin-top: 20px;">{{ old('description', $blog->description) }}</textarea>
                                    </div>
                                    <input type="submit" class="btn btn-block btn-success" value="Save">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/jquery.datetimepicker.css') }}"/ >
    <script src="{{ URL::to('js/jquery.datetimepicker.full.min.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#description',  // change this value according to your HTML
            plugins: 'codesample advlist autolink link image lists charmap print preview emoticons textcolor code',
            height: 500,
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
        $('#date-input').datetimepicker({
            format:'d.m.Y H:i'
        });
    </script>
@endsection