<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ \App\Models\Setting::get('site_tagline') }} — {{ \App\Models\Setting::get('event_dates') }} à {{ strip_tags(\App\Models\Setting::get('event_location')) }}.">
    <title>@yield('title', \App\Models\Setting::get('site_name')) — {{ \App\Models\Setting::get('site_tagline') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/brand/logo-mark.svg') }}">
</head>
<body class="theme-salmete">
    @include('partials.public-navbar')

    <main>
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.public-footer')
    @stack('scripts')
</body>
</html>
