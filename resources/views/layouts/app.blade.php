<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Hakordia Fun Night Run - Event lari malam spektakuler di Jember, Jawa Timur. Daftar sekarang untuk pengalaman lari yang tak terlupakan!">
        <meta name="keywords" content="Hakordia Fun Night Run, Night Run 2025, Event Lari Jember, Lari Malam, Daftar Lari, Event Jember, Running Event Indonesia">
        <meta property="og:title" content="Hakordia Fun Night Run">
        <meta property="og:description" content="Event lari malam spektakuler di Jember, Jawa Timur. Daftar sekarang untuk pengalaman lari yang tak terlupakan!">
        <meta property="og:image" content="{{ asset('images/logo.jpg') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Hakordia Fun Night Run">
        <meta name="twitter:description" content="Event lari malam spektakuler di Jember, Jawa Timur. Daftar sekarang untuk pengalaman lari yang tak terlupakan!">
        <meta name="twitter:image" content="{{ asset('images/logo.jpg') }}">
        <link rel="icon" type="image/png" href="{{ asset('images/logo.jpg') }}">

        <title>@yield('title', 'Hakordia Fun Night Run')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media print {
                body { background: #fff !important; }
                #mainHeader,
                footer,
                .print\:hidden { display: none !important; }
                .print\:border { border: 1px solid #cbd5f5 !important; }
                .print\:rounded-none { border-radius: 0 !important; }
                .print\:px-0 { padding-left: 0 !important; padding-right: 0 !important; }
                .print\:py-0 { padding-top: 0 !important; padding-bottom: 0 !important; }
            }
        </style>
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col" style="font-family: 'Inter', sans-serif;">
        @include('partials.header')

            <!-- Page Content -->
        <main class="flex-grow">
                @yield('content')
            </main>

        @include('partials.footer')
        @stack('scripts')
    </body>
</html>
