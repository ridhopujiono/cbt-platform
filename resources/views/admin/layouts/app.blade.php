<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
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
    <link rel="icon" href="{{ asset('admin_assets/assets/images/favicon.ico') }}"" type=" image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/style.css') }}">



</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    @include('admin.layouts.sidebar')

    @include('admin.layouts.header')

    @yield('content')

    <script src="{{ asset('admin_assets/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/pcoded.min.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('admin_assets/assets/js/plugins/apexcharts.min.js') }}"></script>


    <!-- custom-chart js -->
    <script src="{{ asset('admin_assets/assets/js/pages/dashboard-main.js') }}"></script>
</body>

</html>