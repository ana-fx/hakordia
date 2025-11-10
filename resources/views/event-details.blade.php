@extends('layouts.app')

@section('title', 'Detail Event - Night Run 2025')

@section('content')
<div class="flex flex-col min-h-screen">
    <!-- Prize Section as Hero -->
    <div class="bg-gradient-to-b from-green-200 via-emerald-100 to-white pt-16 pb-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Logo Section -->
            <div class="flex justify-between items-center gap-16 mb-16">
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

            <div class="text-center mb-16">
                <span class="text-green-700 text-lg font-bold tracking-wider mb-3 block">PANDALUNGAN FESTIVAL NIGHT RUN 2025</span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-green-900 mb-4 drop-shadow">Hadiah Juara</h1>
                <p class="text-xl text-green-800/80 max-w-2xl mx-auto">
                    Raih kesempatan memenangkan total hadiah jutaan rupiah dan berbagai hadiah menarik lainnya dalam Night Run 2025
                </p>
                <div class="mt-8">
                    <a href="/" class="inline-flex items-center px-10 py-4 rounded-full bg-green-600 text-white font-bold text-lg shadow-lg hover:bg-green-700 transition-all duration-300">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

            <!-- Hadiah Juara Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Kategori Putra -->
                <div class="relative bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-8 py-2 rounded-full shadow-lg">
                        <h3 class="text-xl font-bold">Kategori Putra</h3>
                    </div>
                    <div class="mt-8 space-y-6">
                        <!-- Juara 1 -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-600 transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl font-bold text-white">1</span>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-green-800">Juara I</h4>
                                        <p class="text-sm text-green-600">Medali + Hadiah</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-900">Rp 1.000.000</div>
                                </div>
                            </div>
                        </div>
                        <!-- Juara 2 -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500 transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl font-bold text-white">2</span>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-green-800">Juara II</h4>
                                        <p class="text-sm text-green-600">Medali + Hadiah</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-900">Rp 750.000</div>
                                </div>
                            </div>
                        </div>
                        <!-- Juara 3 -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-400 transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl font-bold text-white">3</span>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-green-800">Juara III</h4>
                                        <p class="text-sm text-green-600">Medali + Hadiah</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-900">Rp 500.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori Putri -->
                <div class="relative bg-gradient-to-br from-emerald-50 to-green-50 rounded-3xl p-8 shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-emerald-600 text-white px-8 py-2 rounded-full shadow-lg">
                        <h3 class="text-xl font-bold">Kategori Putri</h3>
                    </div>
                    <div class="mt-8 space-y-6">
                        <!-- Juara 1 -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-600 transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl font-bold text-white">1</span>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-green-800">Juara I</h4>
                                        <p class="text-sm text-green-600">Medali + Hadiah</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-900">Rp 1.000.000</div>
                                </div>
                            </div>
                        </div>
                        <!-- Juara 2 -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500 transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl font-bold text-white">2</span>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-green-800">Juara II</h4>
                                        <p class="text-sm text-green-600">Medali + Hadiah</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-900">Rp 750.000</div>
                                </div>
                            </div>
                        </div>
                        <!-- Juara 3 -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-400 transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-xl font-bold text-white">3</span>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-green-800">Juara III</h4>
                                        <p class="text-sm text-green-600">Medali + Hadiah</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-900">Rp 500.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-16 space-y-6">
                <!-- Prize Note -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-green-100 to-emerald-100 rounded-2xl p-6 shadow-lg">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-lg font-semibold text-green-800">Hadiah berupa uang dan medali</p>
                        </div>
                    </div>
                </div>

                <!-- Finisher Note -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-emerald-100 to-green-100 rounded-2xl p-6 shadow-lg">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-lg font-semibold text-green-800">Sertifikat eksklusif untuk 500 finisher pertama</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Event Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-16">
                <!-- Event Details Card -->
                <div class="bg-green-50 rounded-2xl shadow-lg overflow-hidden flex flex-col h-full">
                    <div class="bg-green-100 px-6 py-5">
                        <h2 class="text-xl font-bold text-green-800">Detail Event</h2>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        <ul class="space-y-5">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-700 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-800">Tanggal Event</p>
                                    <p class="text-green-700/80">4 Juli 2025</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-700 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-800">Lokasi</p>
                                    <p class="text-green-700/80">Alun-alun Jember</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-700 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-800">Waktu Mulai</p>
                                    <p class="text-green-700/80">19:00 WIB</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-700 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-800">Jarak</p>
                                    <p class="text-green-700/80">5KM dengan 1 water station</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Registration Info Card -->
                <div class="bg-green-50 rounded-2xl shadow-lg overflow-hidden flex flex-col h-full">
                    <div class="bg-green-100 px-6 py-5">
                        <h2 class="text-xl font-bold text-green-800">Pendaftaran</h2>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        <div class="text-center mb-6">
                            <p class="text-3xl font-bold text-green-700">Rp 150.000</p>
                            <p class="text-green-800/80 mt-1">Per Peserta</p>
                        </div>
                        <div class="space-y-5">
                            <div>
                                <p class="font-semibold text-green-800 mb-2">Periode Pendaftaran:</p>
                                <p class="text-green-700/80">16 - 30 Juni 2025</p>
                            </div>
                            <div>
                                <p class="font-semibold text-green-800 mb-2">Fasilitas:</p>
                                <ul class="space-y-2 text-green-700/80">
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Jersey Exclusive
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Race Number
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Refreshment
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Timeline Card -->
                <div class="bg-green-50 rounded-2xl shadow-lg overflow-hidden flex flex-col h-full">
                    <div class="bg-green-100 px-6 py-5">
                        <h2 class="text-xl font-bold text-green-800">Timeline Event</h2>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-center">
                        <div class="space-y-6">
                            <div class="text-center p-4 bg-green-100/60 rounded-lg">
                                <div class="font-bold text-green-700 mb-2">Pendaftaran</div>
                                <p class="text-green-800">16 - 30 Juni 2025</p>
                            </div>
                            <div class="text-center p-4 bg-green-100/60 rounded-lg">
                                <div class="font-bold text-green-700 mb-2">Race Pack Collection</div>
                                <p class="text-green-800">1 - 2 Juli 2025</p>
                            </div>
                            <div class="text-center p-4 bg-green-100/60 rounded-lg">
                                <div class="font-bold text-green-700 mb-2">Hari Event</div>
                                <p class="text-green-800">4 Juli 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FAQ Card -->
            <div class="bg-green-50 rounded-2xl shadow-lg overflow-hidden max-w-4xl mx-auto">
                <div class="bg-green-100 px-6 py-5">
                    <h2 class="text-xl font-bold text-green-800">FAQ</h2>
                </div>
                <div class="p-8">
                    <div class="space-y-8">
                        @foreach([
                            [
                                'question' => 'Apa saja yang perlu dibawa saat event?',
                                'answer' => 'Jersey yang telah diberikan (wajib), headlamp (disarankan), dan ID untuk verifikasi.'
                            ],
                            [
                                'question' => 'Bagaimana dengan timing system?',
                                'answer' => 'Menggunakan timing chip dengan hasil berdasarkan waktu tercepat. Chip akan diberikan saat pengambilan race pack.'
                            ],
                            [
                                'question' => 'Apakah ada batasan usia?',
                                'answer' => 'Minimal 17 tahun pada hari pelaksanaan event.'
                            ],
                            [
                                'question' => 'Bagaimana jika hujan?',
                                'answer' => 'Event akan tetap berlangsung kecuali ada kondisi cuaca ekstrem yang membahayakan peserta.'
                            ]
                        ] as $faq)
                        <div class="border-b border-green-200 last:border-0 pb-6 last:pb-0">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">{{ $faq['question'] }}</h3>
                            <p class="text-green-700/80">{{ $faq['answer'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CTA Section -->
    <div class="bg-green-700 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-16">
            <h2 class="text-3xl font-bold text-white mb-8">Siap Untuk Bergabung?</h2>
            <a href="/#registrationForm" class="inline-block bg-yellow-400 text-green-900 px-12 py-5 rounded-full font-bold text-lg shadow-lg hover:bg-yellow-300 transition-colors duration-300">
                Daftar Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
