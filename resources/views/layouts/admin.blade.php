<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.12
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Admin Dashboard">
    <meta name="author" content="Jivko Jelev">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>@yield('title') | {{ env('SITE_TITLE') }}</title>
    <!-- Icons-->
    <link href="{{ URL::to('/node_modules/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('/node_modules/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('/node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('/node_modules/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ URL::to('/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>
    @yield('styles')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
@include('partials.admin-header')

<div class="app-body">
    @include('partials.admin-left-menu')
    <main class="main">
        @yield('content')
    </main>
    @include('partials.admin-right-menu')
</div>

<footer class="app-footer">
    <div>
        <a href="https://coreui.io">CoreUI</a>
        <span>&copy; 2018 creativeLabs.</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a href="https://coreui.io">CoreUI</a>
    </div>
</footer>
<!-- CoreUI and necessary plugins-->
<script src="{{ URL::to('/node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::to('/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ URL::to('/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('/node_modules/pace-progress/pace.min.js') }}"></script>
<script src="{{ URL::to('/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
<script src="{{ URL::to('/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
<!-- Plugins and scripts required by this view-->
@yield('scripts')
</body>
</html>
