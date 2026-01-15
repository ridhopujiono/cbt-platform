<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Admin')</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('admin_assets/dist/assets/images/favicon.ico') }}"" type=" image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/dist/assets/css/style.css') }}">

    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">



</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    @include('admin.layouts.sidebar.index')

    @include('admin.layouts.header.index')

    @yield('content')

    <script src="{{ asset('admin_assets/dist/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('admin_assets/dist/assets/js/pcoded.min.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('admin_assets/dist/assets/js/plugins/apexcharts.min.js') }}"></script>


    <!-- custom-chart js -->
    <script src="{{ asset('admin_assets/dist/assets/js/pages/dashboard-main.js') }}"></script>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

   <script>
    window.MathJax = {
    tex: {
        inlineMath: [['$', '$']]
    },
    options: {
        ignoreHtmlClass: 'math-ignore',
        processHtmlClass: 'math-preview'
    }
    };
    </script>

    <script async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js">
    </script>


    @stack('scripts')
</body>

</html>