@extends('layouts.admin', ['title' => 'Kelola Tiket'])

@section('content')
<div class="space-y-8">
    <header class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/70">Konfigurasi</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Pengaturan Tahap Tiket</h1>
            <p class="text-sm text-slate-500">Kelola harga, periode, dan kuota registrasi supaya peserta mengetahui jadwal terbaru.</p>
        </div>
        <a href="{{ route('admin.tickets.create') }}" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Tahap
        </a>
    </header>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-semibold text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <section class="grid gap-4 lg:grid-cols-2">
        @forelse($tickets as $ticket)
            <article class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.35em] text-primary/80">Tahap</span>
                        <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $ticket->name }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $ticket->notes ?? 'Tidak ada catatan tambahan.' }}</p>
                    </div>
                    <div class="rounded-2xl bg-primary/10 px-4 py-2 text-right">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-primary/80">Harga</p>
                        <p class="text-xl font-extrabold text-primary">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <dl class="mt-6 grid gap-4 text-sm text-slate-600 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-500">Mulai</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $ticket->start_date->translatedFormat('d M Y') }}</dd>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-500">Berakhir</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $ticket->end_date->translatedFormat('d M Y') }}</dd>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <dt class="text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-500">Kuota</dt>
                        <dd class="mt-1 font-semibold text-slate-800">{{ $ticket->quota ? number_format($ticket->quota) . ' peserta' : 'Tanpa batas' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 flex flex-wrap gap-2">
                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="inline-flex items-center gap-2 rounded-full border border-primary/20 px-4 py-2 text-xs font-semibold text-primary transition hover:bg-primary/10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3h3z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Hapus tahap {{ $ticket->name }}?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                Belum ada data tiket. Tambahkan tahap registrasi pertama untuk memulai.
            </div>
        @endforelse
    </section>
</div>
@endsection


