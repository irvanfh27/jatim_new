<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- Favicons -->
    <link href="{{ asset('/') }}img/favicon.png" rel="icon">
    <link href="{{ asset('/') }}img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/') }}lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('/') }}lib/font-awesome/css/font-awesome.css" rel="stylesheet"/>
@stack('css')
<!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/style.css" rel="stylesheet">
    <link href="{{ asset('/') }}css/style-responsive.css" rel="stylesheet">

    <!-- =======================================================
      Template Name: Dashio
      Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
      Author: TemplateMag.com
      License: https://templatemag.com/license/
    ======================================================= -->
</head>

<body>
<div id="app">
    <section id="container">
        <!--header start-->
    @include('layouts.header')
    <!--header end-->
        <!--sidebar start-->
    @include('layouts.sidebar')
    <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div>
                    @yield('content')
                </div>
            </section>
            <!-- /wrapper -->
        </section>
        <!-- /MAIN CONTENT -->
        <!--main content end-->
        <!--footer start-->
    {{--    <footer class="site-footer">--}}
    {{--        <div class="text-center">--}}
    {{--            <p>--}}
    {{--                &copy; Copyrights <strong>Dashio</strong>. All Rights Reserved--}}
    {{--            </p>--}}
    {{--            <div class="credits">--}}
    {{--                <!----}}
    {{--                  You are NOT allowed to delete the credit link to TemplateMag with free version.--}}
    {{--                  You can delete the credit link only if you bought the pro version.--}}
    {{--                  Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/--}}
    {{--                  Licensing information: https://templatemag.com/license/--}}
    {{--                -->--}}
    {{--                Created with Dashio template by <a href="https://templatemag.com/">TemplateMag</a>--}}
    {{--            </div>--}}
    {{--            <a href="blank.html#" class="go-top">--}}
    {{--                <i class="fa fa-angle-up"></i>--}}
    {{--            </a>--}}
    {{--        </div>--}}
    {{--    </footer>--}}
    <!--footer end-->
    </section>

</div>

<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ route('js.dynamic') }}"></script>
<script src="{{ asset('js/app.js') }}?{{ uniqid() }}"></script>
<script src="{{ asset('/') }}lib/jquery/jquery.min.js"></script>
<script src="{{ asset('/') }}lib/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('/') }}lib/jquery-ui-1.9.2.custom.min.js"></script>
<script src="{{ asset('/') }}lib/jquery.ui.touch-punch.min.js"></script>
<script class="include" type="text/javascript" src="{{ asset('/') }}lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="{{ asset('/') }}lib/jquery.scrollTo.min.js"></script>
<script src="{{ asset('/') }}lib/jquery.nicescroll.js" type="text/javascript"></script>
@stack('js')
<!--common script for all pages-->
<script src="{{ asset('/') }}lib/common-scripts.js"></script>
<!--script for this page-->
</body>

</html>
