@extends('layouts.app')

@section('title', 'Form Pendaftaran Event')

@section('content')

@include('partials.hero')

<section class="relative overflow-hidden py-16 sm:py-24">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/15 via-white/95 to-secondary/15"></div>

    <div class="relative max-w-6xl mx-auto px-6">
        @if($quotaReached)
            <div class="mx-auto max-w-4xl space-y-8 rounded-[36px] border border-primary/30 bg-white/95 px-10 py-16 text-center shadow-[0_35px_80px_-30px_rgba(15,23,42,0.45)] backdrop-blur-xl">
                <span class="inline-flex items-center gap-3 rounded-full bg-primary/10 px-5 py-2 text-sm font-semibold text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pendaftaran Ditutup
                        </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900">Terima kasih, kuota peserta telah terpenuhi!</h1>
                <p class="mx-auto max-w-2xl text-base sm:text-lg text-slate-600">
                    Antusiasme luar biasa membuat Hakordia Fun Night Run mencapai kapasitas maksimal. Tetap pantau kanal resmi kami untuk pengumuman berikutnya dan informasi teknis bagi peserta terdaftar.
                </p>
                <div class="grid gap-5 text-left sm:grid-cols-2">
                    <div class="rounded-2xl border border-primary/15 bg-primary/5 px-5 py-4 text-sm text-slate-700">
                        <p class="font-semibold text-primary">Cek status pembayaran</p>
                        <p class="mt-1 text-slate-600">Pastikan bukti pembayaran sudah diunggah dan diverifikasi oleh tim admin.</p>
                    </div>
                    <div class="rounded-2xl border border-primary/15 bg-primary/5 px-5 py-4 text-sm text-slate-700">
                        <p class="font-semibold text-primary">Simpan nomor order</p>
                        <p class="mt-1 text-slate-600">Nomor order diperlukan untuk pengambilan race kit dan verifikasi saat race day.</p>
                    </div>
                    <div class="rounded-2xl border border-primary/15 bg-primary/5 px-5 py-4 text-sm text-slate-700">
                        <p class="font-semibold text-primary">Info terbaru</p>
                        <p class="mt-1 text-slate-600">Detail teknis event akan dibagikan melalui WhatsApp broadcast dan email resmi.</p>
                    </div>
                    <div class="rounded-2xl border border-primary/15 bg-primary/5 px-5 py-4 text-sm text-slate-700">
                        <p class="font-semibold text-primary">Race kit & jersey</p>
                        <p class="mt-1 text-slate-600">Pengambilan race pack & registrasi ulang: 4 & 5 Desember 2025 di Kopi Naga Jember. Siapkan identitas diri & nomor order.</p>
                        </div>
                        </div>
                <div class="flex flex-col items-center gap-4">
                    <p class="text-sm text-slate-500">Perlu bantuan tambahan? Tim kami siap membantu melalui kanal berikut.</p>
                    <div class="flex flex-wrap justify-center gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-500">
                                Informasi kontak akan diumumkan
                            </span>
                    </div>
                </div>
            </div>
        @else
            <div class="space-y-12">
        <div class="text-center space-y-5">
                    <span class="inline-flex items-center gap-3 rounded-full bg-white px-5 py-2 text-xs font-semibold uppercase tracking-[.35em] text-primary shadow-sm">
                        Hakordia Fun Night Run 2025
                    </span>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900">Daftarkan timmu, lengkapkan data hanya dalam sekali duduk</h1>
                    <p class="mx-auto max-w-3xl text-base sm:text-lg text-slate-600">
                        Lari malam 3,9K ini menghadirkan pengalaman kota yang hidup, nuansa komunitas yang hangat, serta momentum kebersamaan dalam memperingati Hari Antikorupsi Sedunia.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 text-sm text-slate-600">
                        <div class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-white px-4 py-2 shadow-sm">
                            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Deadline pembayaran: +24 jam setelah submit
                        </div>
                    </div>
                </div>

                <div class="grid gap-10 lg:grid-cols-[minmax(0,1.75fr)_minmax(0,0.9fr)]">
                    <div class="space-y-10">
                        <div class="rounded-[34px] border border-primary/20 bg-white/95 px-6 py-8 shadow-xl backdrop-blur">
                            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                                <div class="max-w-2xl text-left">
                                    <h2 class="text-2xl font-bold text-slate-900">Lengkapi data dalam beberapa langkah ringkas</h2>
                                    <p class="mt-2 text-sm text-slate-600">Setiap peserta membutuhkan informasi identitas, kontak darurat, dan preferensi yang valid sesuai panduan lomba.</p>
                                </div>
                                <button type="button" onclick="addRegistrant()" id="addRegistrantBtn" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary/90">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pendaftar
                </button>
                </div>
            </div>

            @if(session('success'))
                            <div class="rounded-[28px] border border-secondary/30 bg-secondary/10 px-6 py-4 text-secondary shadow">
                                <div class="flex items-center gap-3">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                                </div>
                </div>
            @endif
            @if($errors->any())
                            <div class="rounded-[28px] border border-red-300 bg-red-50 px-6 py-4 text-red-700 shadow">
                                <div class="flex items-start gap-3">
                                    <svg class="mt-1 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                                </div>
                </div>
            @endif


            <form action="{{ route('registration.store') }}" method="POST" class="space-y-8" id="registrationForm" onsubmit="return validateCoupleBundle(event)">
                @csrf
                            @php
                                $selectedTicketId = old('ticket_id', $availableTickets->first()->id ?? null);
                            @endphp

                            @if($availableTickets->isNotEmpty())
                                <div class="rounded-[30px] border border-primary/20 bg-white/95 px-6 py-6 shadow-xl backdrop-blur sm:px-8 sm:py-7 relative z-40">
                                        <div>
                                            <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-1 text-[11px] font-semibold uppercase tracking-[0.35em] text-primary/70">Pilih Tahap</span>
                                            <h3 class="mt-2 text-xl font-bold text-slate-900">Tahap tiket untuk order ini</h3>
                                            <p class="text-sm text-slate-500">Harga dan batas waktu pembayaran mengikuti tahap yang dipilih.</p>
                                    </div>
                                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tahap Registrasi</label>
                                            <div class="relative z-50" id="ticketDropdown">
                                                <button type="button" class="ticket-toggle flex w-full items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                                    <span id="ticketSelectedLabel">
                                                        @php
                                                            $selectedTicket = $availableTickets->firstWhere('id', $selectedTicketId);
                                                        @endphp
                                                        {{ $selectedTicket ? $selectedTicket->name : 'Pilih Tahap Ticket' }}
                                                    </span>
                                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                                </button>
                                                <div class="ticket-panel absolute z-50 mt-2 hidden w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
                                                    <ul class="max-h-56 overflow-auto text-sm text-slate-600">
                                                        @foreach($availableTickets as $ticket)
                                                            <li>
                                                                <button type="button" class="ticket-option flex w-full flex-col items-start gap-1 px-4 py-3 text-left transition hover:bg-primary/5 @if($selectedTicketId == $ticket->id) bg-primary/5 @endif" data-ticket-id="{{ $ticket->id }}" data-ticket-name="{{ $ticket->name }}" data-participant-count="{{ $ticket->participant_count ?? '' }}" data-price="{{ $ticket->price }}">
                                                                    <div class="flex items-center justify-between w-full">
                                                                    <span class="font-semibold text-slate-900">{{ $ticket->name }}</span>
                                                                        @if($ticket->participant_count)
                                                                            <span class="text-xs font-semibold text-primary bg-primary/10 px-2 py-0.5 rounded-full">{{ $ticket->participant_count }} tiket</span>
                                                                        @endif
                                                                    </div>
                                                                    <span class="text-xs text-slate-500">Harga Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="ticket_id" id="ticketSelectedValue" value="{{ $selectedTicketId }}">
                                            </div>
                                            @error('ticket_id')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="rounded-2xl border border-primary/15 bg-primary/5 px-5 py-4 text-sm text-slate-600">
                                            <ul class="space-y-2">
                                                <li><span class="font-semibold text-primary">Catatan:</span> Harga total dihitung otomatis sesuai jumlah peserta.</li>
                                                <li><span class="font-semibold text-primary">Deadline pembayaran:</span> 24 jam setelah submit.</li>
                                                <li><span class="font-semibold text-primary">Hubungi admin:</span> jika kuota tahap ini penuh.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="rounded-[30px] border border-amber-200 bg-amber-50 px-6 py-6 text-sm text-amber-700 shadow-sm sm:px-8">
                                    Tahap tiket belum tersedia saat ini. Silakan pantau kembali atau hubungi admin melalui WhatsApp untuk informasi terbaru.
                                </div>
                            @endif

                            <div id="registrantsContainer" class="space-y-8 relative z-10">
                                <div class="registrant-form relative rounded-[30px] border border-primary/20 bg-white/95 px-6 py-6 shadow-xl transition hover:shadow-2xl sm:px-8 sm:py-8">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex items-center gap-3">
                                            <span data-registrant-number class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10 text-primary font-semibold">1</span>
                                            <div>
                                                <h3 class="text-lg font-semibold text-slate-900">Data Pendaftar #1</h3>
                                                <p class="text-xs text-slate-500">Pastikan identitas dan kontak sesuai dokumen resmi.</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="removeRegistrant(this)" class="remove-btn hidden rounded-full bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                                            Hapus Pendaftar
                            </button>
                        </div>

                                    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">NIK</label>
                                            <input type="text" name="registrations[0][nik]" required pattern="\d{16}" minlength="16" maxlength="16" inputmode="numeric" autocomplete="off" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Masukkan 16 digit NIK" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                                            <input type="text" name="registrations[0][full_name]" required maxlength="255" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Masukkan nama lengkap">
                        </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                                            <input type="email" name="registrations[0][email]" required maxlength="255" autocomplete="email" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Masukkan alamat email">
                        </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
                                            <input type="tel" name="registrations[0][whatsapp_number]" required pattern="\d{10,20}" minlength="10" maxlength="20" inputmode="numeric" autocomplete="off" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Contoh: 081234567890" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                            <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                                            <textarea name="registrations[0][address]" rows="2" required maxlength="500" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                                            <input type="text" name="registrations[0][date_of_birth]" required class="date-input block w-full rounded-xl border border-gray-300 bg-white px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="dd/mm/yyyy" autocomplete="off">
                        </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kota</label>
                                            <input type="text" name="registrations[0][city]" required maxlength="255" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Masukkan kota domisili">
                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin</label>
                                            <div class="relative gender-dropdown" data-registrant-index="0">
                                                <button type="button" class="gender-toggle flex w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2 text-base shadow focus:outline-none focus:ring-2 focus:ring-primary">
                                                    <span class="gender-selected-label">Pilih jenis kelamin</span>
                                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                                </button>
                                                <div class="gender-panel absolute z-20 mt-2 hidden w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                                                    <ul class="max-h-56 overflow-auto text-sm text-slate-600">
                                                        <li>
                                                            <button type="button" class="gender-option flex w-full items-center px-4 py-3 text-left transition hover:bg-primary/5" data-gender="Laki-laki">
                                                                <span class="font-semibold text-slate-900">Laki-laki</span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="gender-option flex w-full items-center px-4 py-3 text-left transition hover:bg-primary/5" data-gender="Perempuan">
                                                                <span class="font-semibold text-slate-900">Perempuan</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="registrations[0][gender]" class="gender-selected-value" value="">
                                            </div>
                        </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Golongan Darah</label>
                                            <div class="relative blood-type-dropdown" data-registrant-index="0">
                                                <button type="button" class="blood-type-toggle flex w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-4 py-2 text-base shadow focus:outline-none focus:ring-2 focus:ring-primary">
                                                    <span class="blood-type-selected-label">Pilih golongan darah</span>
                                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                                </button>
                                                <div class="blood-type-panel absolute z-20 mt-2 hidden w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                                                    <ul class="max-h-56 overflow-auto text-sm text-slate-600">
                                                        <li>
                                                            <button type="button" class="blood-type-option flex w-full items-center px-4 py-3 text-left transition hover:bg-primary/5" data-blood-type="A">
                                                                <span class="font-semibold text-slate-900">A</span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="blood-type-option flex w-full items-center px-4 py-3 text-left transition hover:bg-primary/5" data-blood-type="B">
                                                                <span class="font-semibold text-slate-900">B</span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="blood-type-option flex w-full items-center px-4 py-3 text-left transition hover:bg-primary/5" data-blood-type="AB">
                                                                <span class="font-semibold text-slate-900">AB</span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="blood-type-option flex w-full items-center px-4 py-3 text-left transition hover:bg-primary/5" data-blood-type="O">
                                                                <span class="font-semibold text-slate-900">O</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="registrations[0][blood_type]" class="blood-type-selected-value" value="" required>
                                            </div>
                            </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Riwayat Penyakit <span class="text-gray-400 font-normal">(opsional)</span></label>
                                            <textarea name="registrations[0][medical_conditions]" rows="2" maxlength="255" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Masukkan riwayat penyakit (opsional)"></textarea>
                            </div>
                            <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Kontak Darurat</label>
                                            <input type="tel" name="registrations[0][emergency_contact_number]" required pattern="\d{10,20}" minlength="10" maxlength="20" inputmode="numeric" autocomplete="off" class="mt-1 block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Contoh: 081234567890" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                        </div>
                    </div>
                </div>

                            <div class="rounded-[30px] border border-primary/20 bg-white/95 px-6 py-6 shadow-xl space-y-5">
                                <h4 class="text-lg font-semibold text-slate-900">Konfirmasi & Persetujuan</h4>
                                <label class="flex items-start gap-3">
                                    <input id="terms" name="terms" type="checkbox" required class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="text-sm text-slate-600">Saya menyetujui <a href="#" onclick="openTerms(); return false;" class="text-primary underline hover:text-primary/80">syarat dan ketentuan</a> yang berlaku.</span>
                                </label>
                                <label class="flex items-start gap-3">
                                    <input id="data_confirmation" name="data_confirmation" type="checkbox" required class="mt-1 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="text-sm text-slate-600">Data yang saya masukkan benar dan dapat dipertanggungjawabkan.</span>
                                </label>
                </div>

                            <div class="flex flex-col-reverse gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm text-slate-500">Setelah klik daftar, kamu akan diarahkan ke halaman checkout untuk melengkapi pembayaran.</p>
                                <button type="submit" @if($availableTickets->isEmpty()) disabled class="inline-flex cursor-not-allowed items-center gap-2 rounded-full bg-slate-300 px-8 py-3 text-lg font-bold text-white" @else class="inline-flex items-center gap-2 rounded-full bg-primary px-8 py-3 text-lg font-bold text-white shadow-lg shadow-primary/30 transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2" @endif>
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <!-- Toast Notification -->
            <div id="toast" class="fixed bottom-6 right-6 z-50 hidden min-w-[220px] max-w-xs rounded-full px-4 py-3 text-sm font-semibold text-white shadow-xl"></div>
                    </div>

                    <aside class="space-y-8 rounded-[34px] border border-white/10 bg-slate-950 px-6 py-8 text-slate-50 shadow-[0_30px_90px_-30px_rgba(15,23,42,0.8)] md:sticky md:top-24 md:self-start">
                        <div class="space-y-3">
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-400">Sneak peek</p>
                            <h3 class="text-2xl font-bold">Kenapa harus ikut Hakordia Fun Night Run?</h3>
                            <p class="text-sm text-slate-300">Festival lari malam dengan instalasi cahaya dan musik live siap menyambut kamu dan tim.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-400">Event & Lokasi</p>
                                <div class="mt-4 space-y-4 text-xs text-slate-300">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-xl bg-primary/20 text-primary">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </span>
                                <div>
                                            <p class="text-sm font-semibold text-white">Sabtu, 6 Desember 2025</p>
                                            <p>Mulai pukul 19.00 WIB</p>
                                </div>
                            </div>
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 flex h-9 w-9 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </span>
                                <div>
                                            <p class="text-sm font-semibold text-white">Alun-Alun Jember Nusantara</p>
                                            <p>Jl. Nusantara No. 1, Jember</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3 rounded-2xl border border-white/10 bg-white/5 px-5 py-5 items-start min-h-[120px]">
                                <span class="mt-1 flex h-10 w-10 items-center justify-center rounded-xl bg-secondary/20 text-secondary">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold">Timeline Penting</p>
                                    <ul class="mt-1 space-y-1 text-xs text-slate-300">
                                        <li>4 & 5 Desember 2025 · Pengambilan race pack & registrasi ulang · Kopi Naga Jember</li>
                                        <li>6 Desember 2025 · Start Hakordia Fun Night Run 3.9K · 19.00 WIB</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                            <div class="rounded-2xl border border-primary/30 bg-primary/10 px-5 py-6 text-slate-50">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/80">Prize Pool</p>
                                <div class="mt-3 space-y-4">
                                    <div>
                                        <p class="text-sm font-semibold text-primary/90">Total Hadiah</p>
                                        <div class="mt-1 flex items-baseline gap-2">
                                            <span class="text-xl font-semibold text-primary/80">Rp</span>
                                            <span class="text-4xl font-extrabold text-primary">9.000.000</span>
                                        </div>
                                        <p class="mt-1 text-xs font-medium uppercase text-slate-200">Podium 1, 2, 3 · Male & Female</p>
                                    </div>
                                    <div class="rounded-2xl bg-white/10 px-4 py-3 text-xs space-y-2">
                                        <p class="flex items-baseline justify-between gap-4">
                                            <span class="font-semibold text-primary/70">Juara 1</span>
                                            <span class="flex items-baseline gap-1"><span>Rp</span><span class="font-semibold text-slate-50">2.000.000</span></span>
                                        </p>
                                        <p class="flex items-baseline justify-between gap-4">
                                            <span class="font-semibold text-primary/70">Juara 2</span>
                                            <span class="flex items-baseline gap-1"><span>Rp</span><span class="font-semibold text-slate-50">1.500.000</span></span>
                                        </p>
                                        <p class="flex items-baseline justify-between gap-4">
                                            <span class="font-semibold text-primary/70">Juara 3</span>
                                            <span class="flex items-baseline gap-1"><span>Rp</span><span class="font-semibold text-slate-50">1.000.000</span></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-5 text-slate-50">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-400">Include</p>
                                <div class="mt-4 grid grid-cols-1 gap-3 text-sm text-slate-200 sm:grid-cols-2">
                                    <div class="space-y-2">
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Race Pack</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Jersey</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Glow Stick</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Kacamata</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Bib</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Foto Race</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Medal</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Refreshment</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Guest Star</p>
                                        <p class="flex items-start gap-2"><span class="mt-1 h-4 w-4 flex items-center justify-center rounded-full bg-lime-400/20 text-lime-300">✔</span>Doorprize</p>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-5">
                            <p class="text-sm font-semibold text-white">Tips cepat registrasi</p>
                            <ul class="mt-3 space-y-2 text-xs text-slate-300">
                                <li>• Siapkan foto/scan KTP setiap peserta sebelum mengisi.</li>
                                <li>• Gunakan email & nomor WhatsApp yang aktif untuk menerima konfirmasi.</li>
                                <li>• Setelah submit, selesaikan pembayaran sebelum 24 jam agar slot tidak hangus.</li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Terms Modal -->
<div id="termsModal" class="fixed inset-0 z-50 hidden bg-primary/20 backdrop-blur-sm">
    <div class="grid min-h-full place-items-center px-4">
        <div class="relative w-full max-w-2xl max-h-[80vh] overflow-y-auto rounded-3xl border border-primary/30 bg-white p-8 shadow-2xl animate-fade-in">
        <button onclick="closeTerms()" class="absolute top-4 right-4 rounded-full bg-primary/10 p-2 text-primary transition hover:bg-primary/20" aria-label="Tutup">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="flex items-center gap-3 mb-2">
            <div class="rounded-full bg-primary/10 p-2 text-primary">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M9 17H7a2 2 0 01-2-2v-5a2 2 0 012-2h2a2 2 0 012 2zm0 0v2a2 2 0 002 2h2a2 2 0 002-2v-2"/></svg>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-primary">Syarat & Ketentuan Event</h3>
                <p class="text-sm font-medium text-primary/70">Baca dengan seksama sebelum mendaftar</p>
            </div>
        </div>
        <div class="mt-4 space-y-6 text-sm text-slate-700">
            <div>
                <h4 class="mb-1 font-semibold text-primary">1. Persyaratan Peserta</h4>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Dalam kondisi sehat dan fit untuk berlari.</li>
                    <li>Memiliki identitas yang valid untuk verifikasi.</li>
                </ul>
            </div>
            <div>
                <h4 class="mb-1 font-semibold text-primary">2. Ketentuan Event</h4>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Peserta wajib menggunakan jersey resmi Hakordia saat berlomba.</li>
                    <li>Briefing wajib diikuti sebelum event dimulai.</li>
                    <li>Rute harus dipatuhi; pelanggaran dapat menyebabkan diskualifikasi.</li>
                    <li>Protokol kesehatan berlaku mengikuti aturan pemerintah setempat.</li>
                </ul>
            </div>
            <div>
                <h4 class="mb-1 font-semibold text-primary">3. Tanggung Jawab & Risiko</h4>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Peserta bertanggung jawab atas kondisi kesehatan pribadi.</li>
                    <li>Panitia tidak bertanggung jawab atas kehilangan barang pribadi.</li>
                    <li>Peserta memahami risiko cedera yang mungkin terjadi selama event.</li>
                </ul>
            </div>
            <div>
                <h4 class="mb-1 font-semibold text-primary">4. Pembatalan & Refund</h4>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Tidak ada pengembalian biaya pendaftaran.</li>
                    <li>Event dapat ditunda jika terjadi force majeure; notifikasi akan dikirimkan.</li>
                    <li>Pendaftaran tidak dapat dialihkan ke orang lain tanpa persetujuan panitia.</li>
                </ul>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <button onclick="closeTerms()" class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 font-bold text-white shadow hover:bg-primary/90 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Tutup
            </button>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    // Toast notification function (similar to admin dashboard)
    function showToast(message, type = 'error') {
        const toast = document.getElementById('toast');
        if (!toast) return;

        toast.textContent = message;
        toast.className = `fixed bottom-6 right-6 z-50 min-w-[220px] max-w-xs rounded-full px-4 py-3 text-sm font-semibold text-white shadow-xl ${type === 'success' ? 'bg-primary' : 'bg-red-500'}`;
        toast.classList.remove('hidden');
        toast.style.display = 'block';

        setTimeout(() => {
            toast.style.display = 'none';
            toast.classList.add('hidden');
        }, 3000);
    }

    function validateCoupleBundle(event) {
        const ticketId = document.getElementById('ticketSelectedValue')?.value;
        if (!ticketId) return true;

        // Check if selected ticket is Couple Bundle
        const selectedOption = document.querySelector(`.ticket-option[data-ticket-id="${ticketId}"]`);
        if (!selectedOption) return true;

        const ticketName = selectedOption.dataset.ticketName;
        const participantCount = selectedOption.dataset.participantCount;

        // Validate Couple Bundle
        if (ticketName === 'Couple Bundle' && participantCount == 2) {
            const genderInputs = document.querySelectorAll('.gender-selected-value');
            const genders = Array.from(genderInputs).map(input => input.value).filter(val => val !== '');

            if (genders.length !== 2) {
                event.preventDefault();
                showToast('Silakan lengkapi jenis kelamin untuk kedua peserta.', 'error');
                return false;
            }

            const maleCount = genders.filter(g => g === 'Laki-laki').length;
            const femaleCount = genders.filter(g => g === 'Perempuan').length;

            if (maleCount !== 1 || femaleCount !== 1) {
                event.preventDefault();
                showToast('Paket Couple Bundle harus terdiri dari 1 Laki-laki dan 1 Perempuan. Silakan periksa kembali pilihan jenis kelamin Anda.', 'error');
                return false;
            }
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('ticketDropdown');
        if (!dropdown) return;

        const toggle = dropdown.querySelector('.ticket-toggle');
        const panel = dropdown.querySelector('.ticket-panel');
        const options = dropdown.querySelectorAll('.ticket-option');
        const selectedLabel = document.getElementById('ticketSelectedLabel');
        const selectedValue = document.getElementById('ticketSelectedValue');

        toggle.addEventListener('click', function () {
            panel.classList.toggle('hidden');
        });

        options.forEach(option => {
            option.addEventListener('click', function () {
                const id = this.dataset.ticketId;
                const name = this.dataset.ticketName;
                const participantCount = this.dataset.participantCount;

                selectedLabel.textContent = name;
                selectedValue.value = id;
                panel.classList.add('hidden');

                options.forEach(btn => btn.classList.remove('bg-primary/5'));
                this.classList.add('bg-primary/5');

                // Auto-populate registrants if bundle is selected
                if (participantCount && participantCount !== '') {
                    const targetCount = parseInt(participantCount);
                    const currentCount = document.querySelectorAll('.registrant-form').length;

                    // Remove excess registrants if current count > target
                    if (currentCount > targetCount) {
                        while (document.querySelectorAll('.registrant-form').length > targetCount) {
                            const forms = document.querySelectorAll('.registrant-form');
                            if (forms.length > 1) {
                                const lastForm = forms[forms.length - 1];
                                const removeBtn = lastForm.querySelector('.remove-btn');
                                if (removeBtn) {
                                    lastForm.remove();
                                    registrantCount--;
                                }
                            }
                        }
                    }

                    // Add registrants if current count < target (skip bundle check for auto-populate)
                    while (document.querySelectorAll('.registrant-form').length < targetCount) {
                        addRegistrant(true);
                    }

                    // Hide add button and remove buttons if bundle is selected
                    const addBtn = document.getElementById('addRegistrantBtn');
                    if (addBtn) {
                        addBtn.classList.add('hidden');
                    }

                    // Hide all remove buttons for bundle tickets
                    document.querySelectorAll('.remove-btn').forEach(btn => {
                        btn.classList.add('hidden');
                    });
                } else {
                    // Show add button for non-bundle tickets
                    const addBtn = document.getElementById('addRegistrantBtn');
                    if (addBtn) {
                        addBtn.classList.remove('hidden');
                    }

                    // Show remove buttons for non-bundle tickets (except first one)
                    document.querySelectorAll('.registrant-form').forEach((form, index) => {
                        const removeBtn = form.querySelector('.remove-btn');
                        if (removeBtn) {
                            if (index === 0) {
                                removeBtn.classList.add('hidden');
                            } else {
                                removeBtn.classList.remove('hidden');
                            }
                        }
                    });
                }
            });
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                panel.classList.add('hidden');
            }
        });
    });
</script>
<style>
    .flatpickr-calendar {
        border-radius: 16px;
        font-family: inherit;
    }
</style>
<script>
    let registrantCount = 1;
    const maxRegistrants = 5;
    let registrantTemplateHTML = '';

    const datePickerOptions = {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd/m/Y',
        maxDate: new Date(),
        locale: {
            firstDayOfWeek: 1
        }
    };

    function initDatePickers(root = document) {
        const inputs = root.querySelectorAll('.date-input:not([data-has-flatpickr])');
        inputs.forEach((input) => {
            flatpickr(input, datePickerOptions);
            input.setAttribute('data-has-flatpickr', 'true');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const firstForm = document.querySelector('.registrant-form');
        if (firstForm) {
            registrantTemplateHTML = firstForm.outerHTML;
        }
        initDatePickers();
        initBloodTypeDropdowns();
        initGenderDropdowns();
    });

    function initBloodTypeDropdowns(root = document) {
        const dropdowns = root.querySelectorAll('.blood-type-dropdown');
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.blood-type-toggle');
            const panel = dropdown.querySelector('.blood-type-panel');
            const options = dropdown.querySelectorAll('.blood-type-option');
            const selectedLabel = dropdown.querySelector('.blood-type-selected-label');
            const selectedValue = dropdown.querySelector('.blood-type-selected-value');

            if (!toggle || !panel || !selectedLabel || !selectedValue) return;

            toggle.addEventListener('click', function (e) {
                e.stopPropagation();
                panel.classList.toggle('hidden');
            });

            options.forEach(option => {
                option.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const bloodType = this.dataset.bloodType;
                    selectedLabel.textContent = bloodType;
                    selectedValue.value = bloodType;
                    panel.classList.add('hidden');

                    options.forEach(btn => btn.classList.remove('bg-primary/5'));
                    this.classList.add('bg-primary/5');
                });
            });

            document.addEventListener('click', function (event) {
                if (!dropdown.contains(event.target)) {
                    panel.classList.add('hidden');
                }
            });
        });
    }

    function initGenderDropdowns(root = document) {
        const dropdowns = root.querySelectorAll('.gender-dropdown');
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.gender-toggle');
            const panel = dropdown.querySelector('.gender-panel');
            const options = dropdown.querySelectorAll('.gender-option');
            const selectedLabel = dropdown.querySelector('.gender-selected-label');
            const selectedValue = dropdown.querySelector('.gender-selected-value');

            if (!toggle || !panel || !selectedLabel || !selectedValue) return;

            toggle.addEventListener('click', function (e) {
                e.stopPropagation();
                panel.classList.toggle('hidden');
            });

            options.forEach(option => {
                option.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const gender = this.dataset.gender;
                    selectedLabel.textContent = gender;
                    selectedValue.value = gender;
                    panel.classList.add('hidden');

                    options.forEach(btn => btn.classList.remove('bg-primary/5'));
                    this.classList.add('bg-primary/5');
                });
            });

            document.addEventListener('click', function (event) {
                if (!dropdown.contains(event.target)) {
                    panel.classList.add('hidden');
                }
            });
        });
    }

    function addRegistrant(skipBundleCheck = false) {
        // Check if bundle ticket is selected (skip if called from auto-populate)
        if (!skipBundleCheck) {
            const selectedTicketValue = document.getElementById('ticketSelectedValue');
            if (selectedTicketValue) {
                const selectedOption = document.querySelector(`.ticket-option[data-ticket-id="${selectedTicketValue.value}"]`);
                if (selectedOption && selectedOption.dataset.participantCount && selectedOption.dataset.participantCount !== '') {
                    alert('Paket bundle tidak dapat menambah atau mengurangi jumlah peserta. Jumlah peserta sudah ditentukan.');
                    return;
                }
            }
        }

        if (registrantCount >= maxRegistrants) {
            alert('Maksimal 5 pendaftar');
            return;
        }

        registrantCount++;
        const wrapper = document.createElement('div');
        wrapper.innerHTML = registrantTemplateHTML;
        const template = wrapper.firstElementChild;

        const numberBadge = template.querySelector('[data-registrant-number]');
        if (numberBadge) {
            numberBadge.textContent = registrantCount;
        }
        template.querySelector('h3').textContent = `Data Pendaftar #${registrantCount}`;
        template.querySelector('.remove-btn').classList.remove('hidden');

        template.querySelectorAll('input, select, textarea').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace('[0]', `[${registrantCount - 1}]`));
            }
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                const defaultValue = input.dataset.defaultValue !== undefined ? input.dataset.defaultValue : '';
                input.value = defaultValue;
            }
            if (input.classList.contains('date-input')) {
                input.removeAttribute('data-has-flatpickr');
            }
        });

        // Update blood type dropdown attributes
        const bloodTypeDropdown = template.querySelector('.blood-type-dropdown');
        if (bloodTypeDropdown) {
            bloodTypeDropdown.setAttribute('data-registrant-index', registrantCount - 1);
            const bloodTypeLabel = bloodTypeDropdown.querySelector('.blood-type-selected-label');
            const bloodTypeValue = bloodTypeDropdown.querySelector('.blood-type-selected-value');
            if (bloodTypeLabel) bloodTypeLabel.textContent = 'Pilih golongan darah';
            if (bloodTypeValue) {
                bloodTypeValue.value = '';
                bloodTypeValue.setAttribute('name', `registrations[${registrantCount - 1}][blood_type]`);
            }
            // Reset selected state
            bloodTypeDropdown.querySelectorAll('.blood-type-option').forEach(opt => {
                opt.classList.remove('bg-primary/5');
            });
        }

        // Update gender dropdown attributes
        const genderDropdown = template.querySelector('.gender-dropdown');
        if (genderDropdown) {
            genderDropdown.setAttribute('data-registrant-index', registrantCount - 1);
            const genderLabel = genderDropdown.querySelector('.gender-selected-label');
            const genderValue = genderDropdown.querySelector('.gender-selected-value');
            if (genderLabel) genderLabel.textContent = 'Pilih jenis kelamin';
            if (genderValue) {
                genderValue.value = '';
                genderValue.setAttribute('name', `registrations[${registrantCount - 1}][gender]`);
            }
            // Reset selected state
            genderDropdown.querySelectorAll('.gender-option').forEach(opt => {
                opt.classList.remove('bg-primary/5');
            });
        }

        document.getElementById('registrantsContainer').appendChild(template);
        initDatePickers(template);
        initBloodTypeDropdowns(template);
        initGenderDropdowns(template);

        if (registrantCount >= maxRegistrants) {
            document.getElementById('addRegistrantBtn').classList.add('hidden');
        }
    }

    function removeRegistrant(button, skipBundleCheck = false) {
        // Check if bundle ticket is selected (skip if called from auto-populate)
        if (!skipBundleCheck) {
            const selectedTicketValue = document.getElementById('ticketSelectedValue');
            if (selectedTicketValue) {
                const selectedOption = document.querySelector(`.ticket-option[data-ticket-id="${selectedTicketValue.value}"]`);
                if (selectedOption && selectedOption.dataset.participantCount && selectedOption.dataset.participantCount !== '') {
                    alert('Paket bundle tidak dapat menambah atau mengurangi jumlah peserta. Jumlah peserta sudah ditentukan.');
                    return;
                }
            }
        }

        const form = button.closest('.registrant-form');
        form.remove();
        registrantCount--;
        document.getElementById('addRegistrantBtn').classList.remove('hidden');

        document.querySelectorAll('.registrant-form').forEach((form, index) => {
            const badge = form.querySelector('[data-registrant-number]');
            if (badge) {
                badge.textContent = index + 1;
            }
            form.querySelector('h3').textContent = `Data Pendaftar #${index + 1}`;
            form.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });

            // Update blood type dropdown
            const bloodTypeDropdown = form.querySelector('.blood-type-dropdown');
            if (bloodTypeDropdown) {
                bloodTypeDropdown.setAttribute('data-registrant-index', index);
                const bloodTypeValue = bloodTypeDropdown.querySelector('.blood-type-selected-value');
                if (bloodTypeValue) {
                    bloodTypeValue.setAttribute('name', `registrations[${index}][blood_type]`);
                }
            }

            // Update gender dropdown
            const genderDropdown = form.querySelector('.gender-dropdown');
            if (genderDropdown) {
                genderDropdown.setAttribute('data-registrant-index', index);
                const genderValue = genderDropdown.querySelector('.gender-selected-value');
                if (genderValue) {
                    genderValue.setAttribute('name', `registrations[${index}][gender]`);
                }
            }

            if (index === 0) {
                form.querySelector('.remove-btn').classList.add('hidden');
            }
        });

        // Reinitialize dropdowns after reindexing
        initBloodTypeDropdowns();
        initGenderDropdowns();
    }


    function openTerms() {
        const modal = document.getElementById('termsModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTerms() {
        const modal = document.getElementById('termsModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endpush
