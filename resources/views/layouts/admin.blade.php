<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-link.active {
            background: rgba(65, 117, 203, 0.12);
            color: #1d3f78;
        }
    </style>
    @stack('admin-head')
</head>
<body class="bg-slate-100">
@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
            'match' => ['admin.dashboard'],
        ],
        [
            'label' => 'Ticket',
            'route' => 'admin.tickets.index',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
            'match' => ['admin.tickets.*'],
        ],
    ];
@endphp

<div class="min-h-screen md:flex md:bg-slate-50">
    <!-- Sidebar -->
    <aside id="adminSidebar"
           class="fixed inset-y-0 left-0 z-40 w-72 origin-left transform bg-white/95 shadow-lg transition-transform duration-300 ease-in-out md:static md:translate-x-0 md:w-64">
        <div class="flex h-full flex-col">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10 text-primary font-bold">HK</span>
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-[0.3em]">Admin Panel</p>
                        <h1 class="text-lg font-extrabold text-slate-900">Hakordia Night Run</h1>
                    </div>
                </div>
                <button class="md:hidden rounded-full bg-slate-100 p-2 text-slate-500 hover:text-primary" onclick="toggleSidebar()">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-6 py-6">
                <ul class="space-y-2 text-sm font-semibold text-slate-600">
                    @foreach ($navItems as $item)
                        @php
                            $active = false;
                            foreach ($item['match'] as $pattern) {
                                if (request()->routeIs($pattern)) {
                                    $active = true;
                                    break;
                                }
                            }
                        @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                               class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 transition hover:bg-primary/10 hover:text-primary {{ $active ? 'active' : '' }}">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {!! $item['icon'] !!}
                                </svg>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="border-t border-slate-100 px-6 py-5">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-red-50 hover:text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Overlay -->
    <div id="sidebarBackdrop" class="fixed inset-0 z-30 bg-slate-900/40 opacity-0 pointer-events-none transition-opacity md:hidden" onclick="toggleSidebar()"></div>

    <!-- Main Section -->
    <div class="flex min-h-screen flex-1 flex-col md:ml-0">
        <!-- Mobile Top Bar -->
        <div class="sticky top-0 z-20 flex items-center justify-between bg-white/95 px-4 py-3 shadow-md md:hidden">
            <button class="rounded-full bg-primary/10 p-2 text-primary" onclick="toggleSidebar()">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h14M4 18h10"/>
                </svg>
            </button>
            <span class="text-sm font-semibold uppercase tracking-[0.3em] text-primary">Admin Panel</span>
            <span class="h-8 w-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-semibold">HK</span>
        </div>

        <main class="flex-1 px-6 py-8 md:px-10">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white/70 px-6 py-4 text-xs font-medium text-slate-500 md:px-10">
            <div class="flex flex-col items-center gap-2 text-center md:flex-row md:justify-between md:text-left">
                <p>&copy; {{ date('Y') }} Hakordia Fun Night Run. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="transition hover:text-primary">Syarat & Ketentuan</a>
                    <a href="#" class="transition hover:text-primary">Kebijakan Privasi</a>
                    <span class="text-slate-400/80">Kontak akan diinformasikan</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('sidebarBackdrop');

    function toggleSidebar() {
        const isHidden = sidebar.classList.contains('-translate-x-full');
        if (isHidden) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('opacity-0');
            backdrop.classList.remove('pointer-events-none');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0');
            backdrop.classList.add('pointer-events-none');
        }
    }

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('opacity-0');
        backdrop.classList.remove('pointer-events-none');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('opacity-0');
        backdrop.classList.add('pointer-events-none');
    }

    if (window.innerWidth < 768) {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('pointer-events-none');
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.add('opacity-0');
            backdrop.classList.add('pointer-events-none');
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>
@stack('admin-scripts')
</body>
</html>

