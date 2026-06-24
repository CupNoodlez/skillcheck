<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f766e">
    <title>@yield('title', 'Authentication') · SkillCheck</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_skillcheck_square.png') }}">

    @vite(['resources/css/bootstrap.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-canvas text-ink dark:bg-brand-dark dark:text-brand-light antialiased">
    <x-ui.flash />
    @yield('content')
</body>
</html>
