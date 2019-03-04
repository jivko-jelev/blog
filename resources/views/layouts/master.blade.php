<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Blog</title>
    <link rel="stylesheet" href="{{ URL::asset ('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset ('css/app.css') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="icon" href="{{ URL::to('iconfinder_laravel_1006880.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/prism.css') }}">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @yield('styles')
</head>
<body>

@include('partials.header')

<div class="container">
@yield('content')
</div>

@include('partials.footer')


<script src="{{ URL::asset ('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset ('js/bootstrap.min.js') }}" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>
