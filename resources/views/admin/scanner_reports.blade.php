@extends('layouts.admin', ['title' => 'Laporan Tiket Ter-scan'])

@section('content')
<div class="space-y-6">
    <header class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/70">Laporan Scanner</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Tiket Ter-scan</h1>
            <p class="text-sm text-slate-500">Daftar tiket yang sudah ditukarkan dengan barang fisik.</p>
        </div>
    </header>

    <!-- Statistics -->
    <section class="grid gap-4 md:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Ter-scan</p>
                    <p class="text-xl font-bold text-slate-900">{{ $stats['total_redeemed'] }}</p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Hari Ini</p>
                    <p class="text-xl font-bold text-slate-900">{{ $stats['today_redeemed'] }}</p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Peserta</p>
                    <p class="text-xl font-bold text-slate-900">{{ $stats['total_participants_redeemed'] }}</p>
                </div>
            </div>
        </article>
    </section>

    <!-- Filters -->
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.scanner.reports') }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari order, nama, email, NIK..."
                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
            </div>
            <div>
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
            </div>
            <div>
                <input 
                    type="date" 
                    name="date_to" 
                    value="{{ request('date_to') }}"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
            </div>
            <button 
                type="submit"
                class="rounded-lg bg-primary px-6 py-2 text-sm font-semibold text-white transition hover:bg-primary/90"
            >
                Filter
            </button>
            @if(request()->hasAny(['search', 'date_from', 'date_to']))
                <a 
                    href="{{ route('admin.scanner.reports') }}"
                    class="rounded-lg border border-slate-300 bg-white px-6 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Reset
                </a>
            @endif
        </form>
    </section>

    <!-- Table -->
    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Peserta</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tiket</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Diverifikasi Oleh</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Waktu Scan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($checkouts as $checkout)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <div class="text-sm font-semibold text-slate-900">{{ $checkout->order_number }}</div>
                                <div class="text-xs text-slate-500">{{ $checkout->total_participants }} peserta</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-slate-900">{{ $checkout->participants->first()->full_name ?? 'N/A' }}</div>
                                @if($checkout->participants->count() > 1)
                                    <div class="text-xs text-slate-500">+{{ $checkout->participants->count() - 1 }} lainnya</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-slate-900">{{ $checkout->ticket->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">Rp {{ number_format($checkout->total_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-slate-900">{{ $checkout->redeemedBy->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-slate-900">{{ $checkout->redeemed_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $checkout->redeemed_at->format('H:i') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <a 
                                    href="{{ route('admin.orderDetail', $checkout->order_number) }}"
                                    class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                                </svg>
                                <p class="mt-2 text-sm font-semibold text-slate-900">Belum ada tiket yang ter-scan</p>
                                <p class="text-xs text-slate-500">Tiket yang sudah ditukarkan akan muncul di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($checkouts->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $checkouts->links() }}
            </div>
        @endif
    </section>
</div>
@endsection

