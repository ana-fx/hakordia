<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4 border-b">
                <h1 class="text-xl font-bold text-gray-800">Admin Panel</h1>
            </div>
            <nav class="p-4">
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 bg-accent/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.export') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export Data
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-8">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4">
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- First Row -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-green-100 rounded-bl-full transform translate-x-10 -translate-y-10"></div>
                        <div class="flex items-center relative z-10">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Peserta Terdaftar</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totals['total_participants'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Peserta dengan status paid</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-red-100 rounded-bl-full transform translate-x-10 -translate-y-10"></div>
                        <div class="flex items-center relative z-10">
                            <div class="p-3 rounded-full bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                                <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totals['total_income'], 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 mt-1">Dari peserta dengan status paid</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-green-100 rounded-bl-full transform translate-x-10 -translate-y-10"></div>
                        <div class="flex items-center relative z-10">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Status Paid</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totals['paid'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Jumlah order dengan status paid</p>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-gray-100 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Expired</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totals['expired'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Peserta yang expired</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totals['pending'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Belum upload bukti pembayaran</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Waiting</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totals['waiting'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Sudah upload bukti pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col gap-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Order</h3>
                                <button onclick="toggleAdvancedSearch()" class="text-green-600 hover:text-green-800 font-medium flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                    Filter & Pencarian Lanjutan
                                </button>
                            </div>

                            <!-- Basic Search -->
                            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col md:flex-row gap-4" id="searchForm">
                                <div class="flex-1">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm"
                                        placeholder="Cari order, nama, email, NIK, WhatsApp, kota..." />
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-bold shadow hover:bg-green-700 transition text-sm flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Cari
                                    </button>
                                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'sort', 'direction']))
                                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-bold shadow hover:bg-gray-200 transition text-sm flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Reset
                                        </a>
                            @endif
                                </div>
                        </form>

                            <!-- Advanced Search (Hidden by default) -->
                            <div id="advancedSearch" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                                    <!-- Status Filter -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="status" form="searchForm" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                            <option value="">Semua Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </div>

                                    <!-- Date Range -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                        <input type="date" name="date_from" form="searchForm" value="{{ request('date_from') }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                                        <input type="date" name="date_to" form="searchForm" value="{{ request('date_to') }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                    </div>

                                    <!-- Sort Options -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
                                        <select name="sort" form="searchForm" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                            <option value="created_at" {{ $currentSort == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                            <option value="order_number" {{ $currentSort == 'order_number' ? 'selected' : '' }}>Nomor Order</option>
                                            <option value="total_amount" {{ $currentSort == 'total_amount' ? 'selected' : '' }}>Total Pembayaran</option>
                                            <option value="status" {{ $currentSort == 'status' ? 'selected' : '' }}>Status</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Arah Urutan</label>
                                        <select name="direction" form="searchForm" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 text-sm">
                                            <option value="desc" {{ $currentDirection == 'desc' ? 'selected' : '' }}>Terbaru ke Terlama</option>
                                            <option value="asc" {{ $currentDirection == 'asc' ? 'selected' : '' }}>Terlama ke Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran Baju</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WhatsApp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($checkouts as $checkout)
                                    <tr class="hover:bg-green-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $checkout->order_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($checkout->participants->count() > 0)
                                                @foreach($checkout->participants as $p)
                                                    <div>{{ $p->full_name }}</div>@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($checkout->participants->count() > 0)
                                                @foreach($checkout->participants as $p)
                                                    <div>{{ $p->jersey_size }}</div>@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($checkout->participants->count() > 0)
                                                @foreach($checkout->participants as $p)
                                                    <div>{{ $p->whatsapp_number }}</div>@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($checkout->payment_proof)
                                                <button onclick="showImageModal('{{ asset('storage/'.$checkout->payment_proof) }}')" title="Lihat Bukti Pembayaran" class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span id="badge-status-{{ $checkout->id }}" onclick="cycleStatus({{ $checkout->id }})" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full cursor-pointer transition duration-150 ease-in-out
                                                @if($checkout->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($checkout->status === 'waiting') bg-blue-100 text-blue-800
                                                @elseif($checkout->status === 'paid') bg-green-100 text-green-800
                                                @elseif($checkout->status === 'verified') bg-green-700 text-white
                                                @elseif($checkout->status === 'expired') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($checkout->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('admin.orderDetail', $checkout->order_number) }}" title="View" class="text-indigo-600 hover:text-indigo-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.editOrder', $checkout->order_number) }}" title="Edit" class="text-yellow-600 hover:text-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3h3z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.deleteOrder', $checkout->order_number) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Delete" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Menampilkan <span class="font-bold">{{ $checkouts->firstItem() }}</span> - <span class="font-bold">{{ $checkouts->lastItem() }}</span> dari <span class="font-bold">{{ $checkouts->total() }}</span> data
                        </div>
                        <div>
                            {{ $checkouts->appends(request()->query())->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Image Bukti Pembayaran -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="bg-white p-4 rounded-lg max-w-lg w-full mx-4 flex flex-col items-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-[70vh] rounded shadow border mb-4">
                <div class="flex flex-col items-center gap-4">
                    <a id="downloadButton" href="" download class="text-blue-600 hover:text-blue-800 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Bukti Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden min-w-[200px] max-w-xs px-4 py-3 rounded shadow-lg text-white text-sm font-semibold"></div>

    <script>
        const checkouts = @json($checkouts->load('participants'));
        const statusOrder = ['pending', 'waiting', 'paid', 'verified', 'expired'];

        function cycleStatus(id) {
            const badge = document.getElementById('badge-status-' + id);
            let current = badge.textContent.trim().toLowerCase();
            let idx = statusOrder.indexOf(current);
            let nextIdx = (idx + 1) % statusOrder.length;
            let nextStatus = statusOrder[nextIdx];

            fetch(`/admin/checkouts/${id}/update-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: nextStatus })
            })
            .then(res => res.json())
            .then(data => {
                updateBadgeStatus(id, nextStatus);
                showToast('Status berhasil diperbarui!', 'success');
            })
            .catch(err => {
                showToast('Gagal memperbarui status!', 'error');
            });
        }

        function updateBadgeStatus(id, status) {
            const badge = document.getElementById('badge-status-' + id);
            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            badge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full cursor-pointer transition duration-150 ease-in-out ';
            if(status === 'pending') badge.className += 'bg-yellow-100 text-yellow-800';
            else if(status === 'waiting') badge.className += 'bg-blue-100 text-blue-800';
            else if(status === 'paid') badge.className += 'bg-green-100 text-green-800';
            else if(status === 'verified') badge.className += 'bg-green-700 text-white';
            else if(status === 'expired') badge.className += 'bg-red-100 text-red-800';
        }

        function showImageModal(url) {
            document.getElementById('modalImage').src = url;
            document.getElementById('downloadButton').href = url;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `fixed bottom-6 right-6 z-50 min-w-[200px] max-w-xs px-4 py-3 rounded shadow-lg text-white text-sm font-semibold ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 2500);
        }

        function toggleAdvancedSearch() {
            const advancedSearch = document.getElementById('advancedSearch');
            advancedSearch.classList.toggle('hidden');
        }
    </script>
</body>
</html>
