<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Pandalungan Night Run 2025 - Event lari malam spektakuler di Jember, Jawa Timur. Daftar sekarang untuk pengalaman lari yang tak terlupakan!">
        <meta name="keywords" content="Pandalungan Night Run, Night Run 2025, Event Lari Jember, Lari Malam, Daftar Lari, Event Jember, Running Event Indonesia">
        <meta property="og:title" content="Pandalungan Night Run 2025">
        <meta property="og:description" content="Event lari malam spektakuler di Jember, Jawa Timur. Daftar sekarang untuk pengalaman lari yang tak terlupakan!">
        <meta property="og:image" content="/images/night-run.jpg">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Pandalungan Night Run 2025">
        <meta name="twitter:description" content="Event lari malam spektakuler di Jember, Jawa Timur. Daftar sekarang untuk pengalaman lari yang tak terlupakan!">
        <meta name="twitter:image" content="/images/night-run.jpg">
        <link rel="icon" type="image/x-icon" href="/images/image.png">

        <title>@yield('title', 'Form Pendaftaran')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col" style="font-family: 'Inter', sans-serif;">
        @include('partials.header')

        @if(request()->routeIs('home'))
            @include('partials.hero')
        @endif

            <!-- Page Content -->
        <main class="flex-grow">
                @yield('content')
            </main>

        @include('partials.footer')
        @stack('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('mainHeader');
            function onScroll() {
                if (window.scrollY > 10) {
                    header.classList.add('bg-white', 'shadow-md');
                    header.classList.remove('bg-transparent', 'bg-white/80');
                } else {
                    header.classList.remove('bg-white', 'shadow-md', 'bg-white/80');
                    header.classList.add('bg-transparent');
                }
            }
            window.addEventListener('scroll', onScroll);
            onScroll();
        });
        </script>
    </body>
</html>
