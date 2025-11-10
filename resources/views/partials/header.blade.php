<header id="mainHeader" class="sticky top-0 z-50 w-full bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Title only, no logo -->
        <a href="/" class="text-xl font-bold text-green-800">
            Pandalungan Festival
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex gap-6 items-center font-semibold text-green-900">
            <a href="/" class="hover:text-green-700 transition">Home</a>
            <a href="/event-details" class="hover:text-green-700 transition">Event</a>
            <a href="/#registrationForm" class="hover:text-green-700 transition">Daftar</a>
            @auth
                <a href="/dashboard" class="hover:text-green-700 transition">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-green-700 transition">Logout</button>
                </form>
            @else
                <a href="/login" class="px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition">Login</a>
            @endauth
        </nav>

        <!-- Mobile Button -->
        <button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 text-green-700 border border-green-300 rounded hover:bg-green-100 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Drawer -->
    <div id="mobileMenuDrawer" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-30" onclick="toggleMobileMenu()"></div>
        <div class="absolute right-0 top-0 w-72 h-full bg-white shadow-xl p-6 flex flex-col gap-5 animate-slide-in">
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-green-800">Pandalungan Festival</span>
                <button onclick="toggleMobileMenu()" class="text-green-700 hover:bg-green-100 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col gap-4 text-green-900 font-semibold">
                <a href="/" onclick="toggleMobileMenu()" class="hover:text-green-700 transition">Home</a>
                <a href="/event-details" onclick="toggleMobileMenu()" class="hover:text-green-700 transition">Event</a>
                <a href="/#registrationForm" onclick="toggleMobileMenu()" class="hover:text-green-700 transition">Daftar</a>
                @auth
                    <a href="/dashboard" onclick="toggleMobileMenu()" class="hover:text-green-700 transition">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-left hover:text-red-600 transition">Logout</button>
                    </form>
                @else
                    <a href="/login" onclick="toggleMobileMenu()" class="px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition text-center">Login</a>
                @endauth
            </nav>
        </div>
    </div>

    <style>
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out forwards;
        }
    </style>

    <script>
        function toggleMobileMenu() {
            const drawer = document.getElementById('mobileMenuDrawer');
            drawer.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') toggleMobileMenu();
        });
    </script>
</header>
