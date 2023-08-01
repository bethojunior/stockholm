@extends('adminlte::page')

@vite(['resources/sass/app.scss'])

{{--@section('content')--}}

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="manifest" href="{{ asset('manifest.json') }}">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="#FF006C">

<meta name="mobile-web-app-capable" content="yes">
<meta name="application-name" content="PWA">
<link rel="icon" sizes="512x512" href="{{ asset('images/logo.png') }}">
<link rel="icon" href="{{ asset('images/logo.png') }}">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="PWA">
<link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('Stockholm PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('Stockholm PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">

{{--@endsection--}}
