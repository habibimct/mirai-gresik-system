<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php($adminAssetBase = rtrim(request()->getBaseUrl(), '/'))
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.pwa-meta')
    @yield('meta_tags')

    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    <style>body.iframe-mode .preloader { display: none !important; }</style>
    @yield('adminlte_css_pre')

    @if(config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_css_path', 'css/app.css')) }}">
                @break
            @case('vite')
                @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
                @break
            @case('vite_js_only')
                @vite(config('adminlte.laravel_js_path', 'resources/js/app.js'))
                @break
            @default
                <link rel="stylesheet" href="{{ $adminAssetBase }}/vendor/fontawesome-free/css/all.min.css">
                <link rel="stylesheet" href="{{ $adminAssetBase }}/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
                <link rel="stylesheet" href="{{ $adminAssetBase }}/vendor/adminlte/dist/css/adminlte.min.css">
                @if(config('adminlte.google_fonts.allowed', true))
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic">
                @endif
        @endswitch
    @endif

    @include('adminlte::plugins', ['type' => 'css'])
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif
    @yield('adminlte_css')
</head>

<body class="@yield('classes_body')" @yield('body_data')>
    @yield('body')

    @if(config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <script src="{{ mix(config('adminlte.laravel_js_path', 'js/app.js')) }}"></script>
                @break
            @case('vite')
            @case('vite_js_only')
                @break
            @default
                <script src="{{ $adminAssetBase }}/vendor/jquery/jquery.min.js"></script>
                <script src="{{ $adminAssetBase }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="{{ $adminAssetBase }}/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
                <script src="{{ $adminAssetBase }}/vendor/adminlte/dist/js/adminlte.min.js"></script>
        @endswitch
    @endif

    @include('adminlte::plugins', ['type' => 'js'])
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif
    @yield('adminlte_js')
</body>

</html>
