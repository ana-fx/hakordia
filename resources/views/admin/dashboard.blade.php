@extends('layouts.admin', ['title' => 'Dashboard Admin'])

@section('content')
@php
    use App\Support\StatusStyle;
@endphp

<div class="space-y-8">
    <header class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/70">Ringkasan Utama</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Dashboard Admin</h1>
            <p class="text-sm text-slate-500">Pantau peserta, pembayaran, dan progres registrasi Hakordia Fun Night Run.</p>
            </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.export') }}" class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-white px-4 py-2 text-sm font-semibold text-primary shadow-sm transition hover:bg-primary/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export Data
                    </a>
                </div>
            </header>

                @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-semibold text-emerald-700 shadow-sm">
            {{ session('success') }}
                    </div>
                @endif

    <section class="grid gap-6 md:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Total Peserta</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900"><span data-widget="total_participants">{{ $totals['total_participants'] }}</span></p>
                    <p class="text-xs text-slate-500">Peserta dengan status paid</p>
                            </div>
                        </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-secondary/15 text-secondary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Total Pendapatan</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">Rp <span data-widget="total_income">{{ number_format($totals['total_income'], 0, ',', '.') }}</span></p>
                    <p class="text-xs text-slate-500">Dari pesanan berstatus paid</p>
                            </div>
                        </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Status Paid</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900"><span data-widget="paid">{{ $totals['paid'] }}</span></p>
                    <p class="text-xs text-slate-500">Jumlah order berhasil dibayar</p>
                            </div>
                        </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-200 text-slate-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Expired</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900"><span data-widget="expired">{{ $totals['expired'] }}</span></p>
                    <p class="text-xs text-slate-500">Pesanan melewati batas waktu</p>
                            </div>
                        </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Pending</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900"><span data-widget="pending">{{ $totals['pending'] }}</span></p>
                    <p class="text-xs text-slate-500">Belum upload bukti pembayaran</p>
                            </div>
                        </div>
        </article>
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Waiting</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900"><span data-widget="waiting">{{ $totals['waiting'] }}</span></p>
                    <p class="text-xs text-slate-500">Sudah upload bukti pembayaran</p>
                            </div>
                        </div>
        </article>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Daftar Order</h2>
                    <p class="text-xs text-slate-500">Gunakan pencarian lanjutan untuk menyaring data peserta dengan cepat.</p>
                    </div>
                <button onclick="toggleAdvancedSearch()" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:bg-primary/10 hover:text-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    Filter &amp; Pencarian Lanjutan
                                </button>
                            </div>
        </div>
        <div class="px-6 py-5">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col gap-4 md:flex-row" id="searchForm">
                                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Cari order, nama, email, NIK, WhatsApp, kota...">
                                </div>
                                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        Cari
                                    </button>
                                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'sort', 'direction']))
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Reset
                                        </a>
                            @endif
                                </div>
                        </form>
        </div>

        <div id="advancedSearch" class="hidden border-t border-slate-100 bg-slate-50 px-6 py-5">
            <div class="grid gap-4 md:grid-cols-3">
                                    <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Status</label>
                    <select name="status" form="searchForm" class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            <option value="">Semua Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </div>
                                    <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Tanggal Mulai</label>
                    <input type="date" name="date_from" form="searchForm" value="{{ request('date_from') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-primary focus:ring-primary">
                                    </div>
                                    <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Tanggal Akhir</label>
                    <input type="date" name="date_to" form="searchForm" value="{{ request('date_to') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-primary focus:ring-primary">
                                    </div>
                                    <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Urutkan</label>
                    <select name="sort" form="searchForm" class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            <option value="created_at" {{ $currentSort == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                            <option value="order_number" {{ $currentSort == 'order_number' ? 'selected' : '' }}>Nomor Order</option>
                                            <option value="total_amount" {{ $currentSort == 'total_amount' ? 'selected' : '' }}>Total Pembayaran</option>
                                            <option value="status" {{ $currentSort == 'status' ? 'selected' : '' }}>Status</option>
                                        </select>
                                    </div>
                                    <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Arah</label>
                    <select name="direction" form="searchForm" class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            <option value="desc" {{ $currentDirection == 'desc' ? 'selected' : '' }}>Terbaru ke Terlama</option>
                                            <option value="asc" {{ $currentDirection == 'asc' ? 'selected' : '' }}>Terlama ke Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

        <div class="overflow-x-auto px-6 pb-6">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-[0.68rem] font-semibold uppercase tracking-[0.25em] text-slate-500">
                        <th class="px-4 py-3">Order Number</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Ukuran Baju</th>
                        <th class="px-4 py-3">WhatsApp</th>
                        <th class="px-4 py-3">Bukti Pembayaran</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                                @foreach ($checkouts as $checkout)
                                    <tr class="hover:bg-primary/5 transition">
                            <td class="px-4 py-4 font-semibold text-slate-900">{{ $checkout->order_number }}</td>
                            <td class="px-4 py-4 text-slate-600">
                                @forelse($checkout->participants as $p)
                                    <div>{{ $p->full_name }}</div>
                                @empty
                                    <span class="text-slate-400">—</span>
                                @endforelse
                                        </td>
                            <td class="px-4 py-4 text-slate-600">
                                @forelse($checkout->participants as $p)
                                    <div>{{ $p->jersey_size ?? 'All Size' }}</div>
                                @empty
                                    <span class="text-slate-400">—</span>
                                @endforelse
                                        </td>
                            <td class="px-4 py-4 text-slate-600">
                                @forelse($checkout->participants as $p)
                                    <div>{{ $p->whatsapp_number }}</div>
                                @empty
                                    <span class="text-slate-400">—</span>
                                @endforelse
                                        </td>
                            <td class="px-4 py-4">
                                            @if($checkout->payment_proof)
                                    <button onclick="showImageModal('{{ asset('storage/'.$checkout->payment_proof) }}')" class="text-primary hover:text-primary/80" title="Lihat Bukti">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </button>
                                            @else
                                    <span class="text-slate-400">—</span>
                                            @endif
                                        </td>
                            <td class="px-4 py-4">
                                <span id="badge-status-{{ $checkout->id }}" data-status-badge data-status="{{ $checkout->status }}" onclick="cycleStatus({{ $checkout->id }})" class="badge rounded-pill d-inline-flex align-items-center fw-semibold text-uppercase px-3 py-2 cursor-pointer gap-1 {{ StatusStyle::badgeClasses($checkout->status) }}">
                                                {{ ucfirst($checkout->status) }}
                                            </span>
                                        </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3 text-slate-500">
                                    <a href="{{ route('admin.orderDetail', $checkout->order_number) }}" class="hover:text-primary" title="Lihat Detail">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                    <a href="{{ route('admin.editOrder', $checkout->order_number) }}" class="hover:text-secondary" title="Edit Order">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3h3z"/></svg>
                                                </a>
                                                <form action="{{ route('admin.deleteOrder', $checkout->order_number) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                        <button type="submit" class="hover:text-red-500" title="Hapus Order">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
    </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 px-6 py-4 text-sm text-slate-500 md:flex-row md:items-center md:justify-between">
            <p>Menampilkan <span class="font-semibold text-slate-800">{{ $checkouts->firstItem() }}</span> - <span class="font-semibold text-slate-800">{{ $checkouts->lastItem() }}</span> dari <span class="font-semibold text-slate-800">{{ $checkouts->total() }}</span> data</p>
            <div>{{ $checkouts->appends(request()->query())->links('vendor.pagination.tailwind') }}</div>
                </div>
    </section>
    </div>

@include('admin.partials.modals')
@endsection

@push('admin-scripts')
@include('admin.partials.dashboard-scripts')
@endpush
