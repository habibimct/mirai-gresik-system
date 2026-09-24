@php($pwaBasePath = rtrim(request()->getBaseUrl(), '/'))
<meta name="theme-color" content="#4f46e5">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="MGS">
<link rel="manifest" href="{{ $pwaBasePath }}/manifest.webmanifest">
<link rel="apple-touch-icon" href="{{ $pwaBasePath }}/images/pwa-icon-192.png">
<script>window.pwaServiceWorkerUrl = @json($pwaBasePath . '/service-worker.js');</script>
