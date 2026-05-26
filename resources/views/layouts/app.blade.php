<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-KRY5MKQRS3"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-KRY5MKQRS3');
        </script>
        <!-- Google tag (gtag.js) -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('meta', view('partials.meta'))

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/common/iso_vocerito.svg') }}">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/scss/styles.scss', 'resources/js/app.js'])
    </head>
    <body data-page="{{ request()->route()->getName() ?? '' }}">
        <div id="body-content">
            @include('layouts.navigation')
            <main id="swup" data-page="{{ request()->route()->getName() ?? '' }}">
                {{ $slot }}
            </main>            
            @include('layouts.footer')
            @include('components.search-modal')            
        </div>
        {{-- Agente Chat --}}
        <div id="agente-app">
            <agente-chat></agente-chat>
        </div>
    </body>
</html>