<!-- Footer Section -->
<footer class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-slate-100">
    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-secondary via-primary to-secondary opacity-70"></div>
    <div class="relative mx-auto max-w-6xl px-6 pt-24 pb-16">
        <div class="grid gap-12 lg:grid-cols-[1.2fr_1fr] items-center">
            <div class="space-y-6 text-center lg:text-left">
                <div class="flex flex-col items-center gap-4 lg:flex-row lg:items-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/5 shadow-[0_10px_30px_-15px_rgba(15,23,42,0.8)]">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Hakordia Logo" class="h-11 w-11 rounded-full object-cover">
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold tracking-tight text-white">Hakordia Fun Night Run</h3>
                        <p class="text-sm text-slate-300">Energi malam untuk merayakan integritas dan kebersamaan.</p>
                    </div>
                </div>
                <div class="grid gap-4 text-sm text-slate-300 lg:grid-cols-2">
                    <div class="flex items-center gap-3 justify-center lg:justify-start">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-secondary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold text-white">Venue</p>
                            <p>Alun-Alun Jember Nusantara</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-center lg:justify-start">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-secondary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold text-white">Jadwal</p>
                            <p>Sabtu, 6 Desember 2025 · 19.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 text-center lg:text-left">
                <h4 class="text-lg font-semibold text-white">Hakordia Pride</h4>
                <p class="text-sm text-slate-300/90">Kami percaya energi komunitas akan menciptakan malam penuh semangat, cahaya, dan pesan antikorupsi yang menggema dari Jember untuk Indonesia.</p>
                <div class="inline-flex items-center gap-2 justify-center lg:justify-start rounded-full border border-white/10 bg-white/5 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-300/70">
                    Integrity · Solidarity · Celebration
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 border-t border-white/10 pt-6 text-center text-sm text-slate-400 md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} Hakordia Fun Night Run. All rights reserved.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('policy.privacy') }}" class="hover:text-primary transition">Kebijakan Privasi</a>
                <a href="{{ route('policy.terms') }}" class="hover:text-primary transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>

    <button id="btnBackToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" class="pointer-events-none fixed bottom-6 right-6 hidden h-12 w-12 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/40 ring-2 ring-white/10 transition hover:bg-primary/90">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
        <span class="sr-only">Kembali ke atas</span>
    </button>
    <script>
        document.addEventListener('scroll', () => {
            const btn = document.getElementById('btnBackToTop');
            if (!btn) return;
            const triggerHeight = document.body.scrollHeight - window.innerHeight - 200;
            if (window.scrollY >= triggerHeight) {
                btn.classList.remove('hidden');
                btn.classList.add('flex', 'pointer-events-auto');
            } else {
                btn.classList.remove('flex', 'pointer-events-auto');
                btn.classList.add('hidden', 'pointer-events-none');
            }
        });
    </script>
</footer>
