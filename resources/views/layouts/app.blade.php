<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($session)
        <meta name="autosave-url" content="{{ route('exam.autosave', $session->id) }}">
    @endisset

    <title>@yield('title', 'Login')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <main class="app-container">
        @yield('content')
    </main>

</body>

</html>