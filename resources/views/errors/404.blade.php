@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center py-16">
    <div class="flex flex-col items-center gap-6">
        <div class="bg-green-100 rounded-full p-6 shadow-lg mb-2">
            <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 48 48">
                <circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="3" fill="#fff"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 20c0-2 2-4 6-4s6 2 6 4m-8 8h4m-2 0v2"/>
            </svg>
        </div>
        <h1 class="text-6xl font-extrabold text-green-700 drop-shadow">404</h1>
        <h2 class="text-2xl font-bold text-gray-800">Halaman Tidak Ditemukan</h2>
        <p class="text-gray-600 text-center max-w-md">Oops! Sepertinya kamu tersesat di rute Night Run. Halaman yang kamu cari tidak tersedia atau sudah dipindahkan.</p>
        <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-full font-bold shadow hover:bg-green-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
