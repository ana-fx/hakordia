<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-green-200 via-emerald-100 to-white overflow-hidden py-16">
    <!-- Logo Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="flex justify-between items-center gap-16">
            <div class="w-48 h-48 relative">
                <img src="{{ asset('images/sayap-jatim.png') }}" alt="Sayap Jatim" class="w-full h-full object-contain">
            </div>
            <div class="w-48 h-48 relative">
                <img src="{{ asset('images/pandalungan.png') }}" alt="Logo Pandalungan" class="w-full h-full object-contain">
            </div>
            <div class="w-48 h-48 relative">
                <img src="{{ asset('images/bank-jatim.png') }}" alt="Bank Jatim" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <!-- Left: Text Content -->
            <div class="z-10 flex-1 max-w-xl order-2 md:order-1">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-block bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">PANDALUNGAN FESTIVAL 2025</span>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-4 drop-shadow-lg">
                    NIGHT <span class="text-green-700">RUN</span>
                </h1>
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <div class="flex items-center gap-2 bg-white/80 px-4 py-2 rounded shadow">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="font-semibold">Jumat, 4 Juli 2025</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/80 px-4 py-2 rounded shadow">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="font-semibold">Alun-Alun Jember Nusantara</span>
                    </div>
                </div>
                <div class="mb-6">
                    <span class="block text-lg font-medium text-gray-700 mb-1">Total Prizepool</span>
                    <span class="text-3xl sm:text-4xl font-extrabold text-green-700 drop-shadow">Rp 4.500.000</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="#registrationForm" class="inline-block px-8 py-3 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700 transition text-lg">Daftar Sekarang</a>
                    <a href="/event-details" class="inline-block px-8 py-3 bg-white text-green-700 font-bold rounded-lg shadow border border-green-600 hover:bg-green-50 transition text-lg">Detail Event</a>
                </div>
                <div class="flex items-center gap-4 text-gray-600 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="font-bold">5KM Race Individual</span>
                    </div>
                    <span class="hidden sm:inline">|</span>
                    <div class="flex items-center gap-2">
                        <span>Registrasi: <span class="font-semibold text-green-700">Rp 150.000</span></span>
                    </div>
                </div>
            </div>
            <!-- Right: Single Main Illustration -->
            <div class="relative flex-1 flex justify-center items-center order-1 md:order-2">
                <img src="{{ asset('images/night-run.jpg') }}" alt="Night Run Main Illustration" class="w-full max-w-[420px] rounded-2xl shadow-2xl" loading="lazy">
            </div>
        </div>
    </div>
</section>

<style>
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-18px); }
}
.animate-bounce-slow {
  animation: bounce-slow 2.5s infinite;
}
@keyframes float {
  0%, 100% { transform: translateY(0) rotate(-2deg); }
  50% { transform: translateY(-10px) rotate(2deg); }
}
.animate-float {
  animation: float 4s ease-in-out infinite;
}
</style>
