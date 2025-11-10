<!-- Hero Section -->
<section class="relative overflow-hidden bg-slate-950 text-slate-50">
    <div class="absolute inset-0 bg-[url('/images/landing%20page.png')] bg-cover bg-center opacity-35 mix-blend-lighten"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-slate-950/80 to-primary/60"></div>

    <div class="relative max-w-6xl mx-auto px-6 py-24 lg:py-28">
        <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] items-center">
            <div class="space-y-8">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.35em] text-primary">
                    Hakordia Night Run 3.9K
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">
                    Rute 3,9K penuh cahaya untuk merayakan Hari Anti Korupsi Sedunia.
                </h1>
                <p class="text-base sm:text-lg text-slate-200/80 max-w-xl">
                    Bergerak bersama seluruh masyarakat Jember, Hakordia Fun Night Run 3.9K mengajak kita merayakan semangat antikorupsi lewat olahraga malam penuh kebersamaan, lintasan kota yang hidup, dan momen solidaritas yang tak terlupakan.
                </p>
                <div class="grid gap-4 sm:grid-cols-2 text-sm text-slate-200/80">
                    <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/20 text-primary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        Sabtu, 6 Desember 2025 · 19.00 WIB
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        Alun-Alun Jember Nusantara
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/20 text-primary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Route Course spesial 3.9K – Fun Run penuh experience
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Peserta terverifikasi: {{ number_format($totalPaidParticipants ?? 0) }} orang
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="#registrationForm" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary/90">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Mulai Daftar
                    </a>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white shadow-sm">
                        Info kontak segera tersedia
                    </span>
                </div>
                </div>
            <div class="relative">
                <div class="relative overflow-hidden rounded-[32px] border border-white/15 bg-white/10 px-4 py-4 shadow-[0_40px_120px_-50px_rgba(15,23,42,0.9)] backdrop-blur">
                    <div class="aspect-[16/9] w-full">
                        <img src="{{ asset('images/landing page.png') }}" alt="Runner collage" class="h-full w-full rounded-[24px] object-cover" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
