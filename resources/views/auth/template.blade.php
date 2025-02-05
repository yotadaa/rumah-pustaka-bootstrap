<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('componen/login/fonts/icomoon/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('componen/login/css/owl.carousel.min.css') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('componen/login/css/bootstrap.min.css') }}" />

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('componen/login/css/style.css') }}" />
    <script src="{{ asset('componen/login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('componen/login/js/bootstrap.bundle.min.js') }}"></script>


    <title>@yield('title')</title>
    @yield('head')


    @livewireStyles
</head>

<body>
    @yield('main')
    @yield('script')
</body>

</html>
