<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"  lang="en"> <![endif]-->
<!--[if IE 7 ]> <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]> <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]> <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
<head>
    <!-- meta begins -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <!-- meta ends -->

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- title begins -->
    <title>Salestrack</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <!-- stylesheet begins -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Google Font: Montserrat -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    @yield('style')
    <!-- stylesheet ends -->

    {{--Head--}}
    @yield('head')
</head>
    <body class="@yield('body_class') {{ $class ?? '' }}">
        @if(\Sentinel::check())
            @include('layouts.admin.page_templates.auth')
        @else
            @include('layouts.admin.page_templates.guest')
        @endif

        {{--
            <div class="wrapper">
                @yield('page')
            </div>
        --}}

        {{--Scripts--}}
        <script>
            // global app configuration object
            var config = {
                user_login: "{{ (Sentinel::getUser()) ? encrypt(Sentinel::getUser()->id) : '' }}",
                routes: {
                    url: "{{ url('/') }}",
                    current_route: "{{ \Route::currentRouteName() }}"
                }
            };
        </script>

        <script src="{{ asset('js/build.js') }}"></script>
        <script src="{{ asset('js/EditableSelect.js') }}"></script>

        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>

        @yield('script')
        @yield('scripts')

    </body>
</html>

