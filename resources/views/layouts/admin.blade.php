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
    
    <!-- Vite CSS (compiled Tailwind) - Try to load from build -->
    @if(app()->environment('production') || file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @endif
    
    <!-- Tailwind CDN (Primary for development, fallback for production) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configure Tailwind CDN with custom colors
        if (typeof tailwind !== 'undefined') {
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#4175cb',
                            secondary: '#a9c941',
                        }
                    }
                }
            };
        }
    </script>
    
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          crossorigin="anonymous">

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
    $waitingCount = \App\Models\Checkout::where('status', 'waiting')->count();

    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
            'match' => ['admin.dashboard'],
            'badge' => $waitingCount > 0 ? $waitingCount : null,
        ],
        [
            'label' => 'Ticket',
            'route' => 'admin.tickets.index',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
            'match' => ['admin.tickets.*'],
        ],
        [
            'label' => 'Scanner',
            'route' => 'admin.scanner',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />',
            'match' => ['admin.scanner', 'admin.scanner.*'],
            'submenu' => [
                [
                    'label' => 'Scan QR Code',
                    'route' => 'admin.scanner',
                    'match' => ['admin.scanner'],
                ],
                [
                    'label' => 'Laporan Ter-scan',
                    'route' => 'admin.scanner.reports',
                    'match' => ['admin.scanner.reports'],
                ],
            ],
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
                            $hasActiveSubmenu = false;
                            foreach ($item['match'] as $pattern) {
                                if (request()->routeIs($pattern)) {
                                    $active = true;
                                    break;
                                }
                            }
                            
                            // Check if any submenu is active
                            if (isset($item['submenu'])) {
                                foreach ($item['submenu'] as $subItem) {
                                    foreach ($subItem['match'] as $pattern) {
                                        if (request()->routeIs($pattern)) {
                                            $hasActiveSubmenu = true;
                                            $active = true;
                                            break 2;
                                        }
                                    }
                                }
                            }
                        @endphp
                        <li>
                            @if(isset($item['submenu']))
                                <div class="space-y-1">
                                    <a href="{{ route($item['route']) }}"
                                       class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 transition hover:bg-primary/10 hover:text-primary {{ $active ? 'active' : '' }}">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $item['icon'] !!}
                                        </svg>
                                        <span class="flex-1">{{ $item['label'] }}</span>
                                        @if(isset($item['badge']) && $item['badge'] > 0)
                                            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold text-white bg-amber-500 animate-pulse">
                                                {{ $item['badge'] }}
                                            </span>
                                        @endif
                                        <svg class="h-4 w-4 transition-transform {{ $hasActiveSubmenu ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    <ul class="ml-4 space-y-1 {{ $hasActiveSubmenu ? '' : 'hidden' }}" id="submenu-{{ $loop->index }}">
                                        @foreach ($item['submenu'] as $subItem)
                                            @php
                                                $subActive = false;
                                                foreach ($subItem['match'] as $pattern) {
                                                    if (request()->routeIs($pattern)) {
                                                        $subActive = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <li>
                                                <a href="{{ route($subItem['route']) }}"
                                                   class="flex items-center gap-2 rounded-xl px-4 py-2 text-xs transition hover:bg-primary/10 hover:text-primary {{ $subActive ? 'bg-primary/10 text-primary font-bold' : 'text-slate-500' }}">
                                                    <span class="h-1.5 w-1.5 rounded-full {{ $subActive ? 'bg-primary' : 'bg-slate-300' }}"></span>
                                                    {{ $subItem['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route($item['route']) }}"
                                   class="sidebar-link flex items-center gap-3 rounded-2xl px-4 py-3 transition hover:bg-primary/10 hover:text-primary {{ $active ? 'active' : '' }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {!! $item['icon'] !!}
                                    </svg>
                                    <span class="flex-1">{{ $item['label'] }}</span>
                                    @if(isset($item['badge']) && $item['badge'] > 0)
                                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold text-white bg-amber-500 animate-pulse">
                                            {{ $item['badge'] }}
                                        </span>
                                    @endif
                                </a>
                            @endif
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

        <main class="flex-1 px-4 py-6 md:px-6 lg:px-10 md:py-8 overflow-x-hidden">
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

    // Submenu toggle
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^="submenu-"]').forEach(submenu => {
            const parentLink = submenu.previousElementSibling;
            if (parentLink && parentLink.classList.contains('sidebar-link')) {
                parentLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isHidden = submenu.classList.contains('hidden');
                    const arrow = parentLink.querySelector('svg:last-child');
                    
                    if (isHidden) {
                        submenu.classList.remove('hidden');
                        if (arrow) arrow.classList.add('rotate-90');
                    } else {
                        submenu.classList.add('hidden');
                        if (arrow) arrow.classList.remove('rotate-90');
                    }
                });
            }
        });
    });
</script>
@stack('admin-scripts')
</body>
</html>

