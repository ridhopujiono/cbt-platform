<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Exam')</title>
        <link rel="stylesheet" href="{{ asset('css/exam.css') }}">
    </head>
    <body>
        <main>
            @yield('content')
        </main>
        <script src="{{ asset('js/exam.js') }}"></script>
    </body>
</html>
