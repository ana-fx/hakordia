<header id="mainHeader" class="absolute top-0 left-0 z-50 w-full text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo + Title -->
        <a href="/" class="flex items-center gap-3 brand-title text-xl font-bold transition-colors duration-300">
            <img src="{{ asset('images/logo.jpg') }}" alt="Hakordia Fun Night Run" class="h-10 w-10 rounded-full border border-white/40 object-cover">
            <span>Hakordia Fun Night Run</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex gap-6 items-center font-semibold">
            @auth
                <a href="/dashboard" class="nav-link hover:text-secondary transition">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="nav-link hover:text-red-300 transition">Logout</button>
                </form>
            @else
                <a href="/login" class="login-btn px-4 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition">Login</a>
            @endauth
        </nav>

        <!-- Mobile Button -->
        <button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 border border-white/40 text-white rounded hover:bg-white/20 transition">
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
                <span class="flex items-center gap-2 text-lg font-bold text-primary">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Hakordia Logo" class="h-9 w-9 rounded-full object-cover border border-primary/30">
                    Hakordia Fun Night Run
                </span>
                <button onclick="toggleMobileMenu()" class="text-primary hover:bg-primary/10 rounded-full p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col gap-4 text-primary font-semibold">
                @auth
                    <a href="/dashboard" onclick="toggleMobileMenu()" class="hover:text-secondary transition">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-left hover:text-red-600 transition">Logout</button>
                    </form>
                @else
                    <a href="/login" onclick="toggleMobileMenu()" class="px-4 py-2 bg-primary text-white rounded-full hover:bg-primary/90 transition text-center">Login</a>
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
        #mainHeader .nav-link,
        #mainHeader .brand-title {
            color: rgba(255, 255, 255, 0.95);
        }
        #mainHeader .nav-link:hover {
            color: #a9c941;
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
