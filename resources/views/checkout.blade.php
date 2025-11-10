@extends('layouts.app')

@section('title', 'Checkout Pendaftaran - Night Run 2025')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-1 drop-shadow">Checkout Pendaftaran</h1>
                <p class="text-gray-600">Order <span class="font-semibold">#{{ $checkout->order_number }}</span></p>
                <p class="text-gray-500 text-sm mt-1">Batas pembayaran: <span class="font-semibold">{{ $checkout->payment_deadline->format('d M Y H:i') }}</span></p>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold
                            @if($checkout->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($checkout->status === 'paid') bg-blue-100 text-blue-800
                            @elseif($checkout->status === 'verified') bg-green-100 text-green-800
                            @elseif($checkout->status === 'expired') bg-red-100 text-red-800
                            @endif">
                            Status: {{ ucfirst($checkout->status) }}
                        </span>
            </div>
        </div>
        <div class="p-8 space-y-8">
            <!-- Ringkasan Pendaftaran -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ringkasan Pendaftaran</h2>
                <div class="grid gap-6">
                    @foreach($registrants as $index => $registrant)
                    <div class="bg-gray-50 rounded-xl shadow p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Nama Lengkap</p>
                                <p class="font-semibold text-lg">{{ $registrant['full_name'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">NIK</p>
                                <p class="font-medium">{{ $registrant['nik'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="font-medium">{{ $registrant['email'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">No. WhatsApp</p>
                                <p class="font-medium">{{ $registrant['whatsapp_number'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Ukuran Jersey</p>
                                <p class="font-medium">{{ $registrant['jersey_size'] }}</p>
                            </div>
                        </div>
                        <div class="hidden md:block border-l border-gray-200 h-16 mx-6"></div>
                        <div class="flex flex-col items-center gap-2">
                            <span class="text-xs text-gray-400">Pendaftar #{{ $index + 1 }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Rincian Pembayaran -->
            <div class="bg-gradient-to-r from-green-100 via-emerald-50 to-white rounded-xl shadow p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 0a8 8 0 110 16 8 8 0 010-16z"/></svg>
                    Rincian Pembayaran
                </h3>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Pendaftaran ({{ count($registrants) }}x)</span>
                        <span class="font-medium">Rp {{ number_format($checkout->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200 mt-2">
                        <span class="font-bold">Total Pembayaran</span>
                        <span class="font-bold text-xl text-green-700">Rp {{ number_format($checkout->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            <!-- Instruksi Pembayaran & Upload -->
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-6">
            <!-- Bank Info -->
                    <div class="bg-white rounded-xl border shadow p-6">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('images/bank-jatim.png') }}" alt="Bank Jatim" class="h-8 mr-3">
                    <span class="font-semibold text-lg">Bank Jatim</span>
                </div>
                <div class="space-y-2">
                        <div class="flex items-center gap-2">
                                <p class="text-xs text-gray-500">Nomor Rekening</p>
                                <button onclick="copyToClipboard('0032836836')" class="ml-2 text-accent hover:text-accent/80 text-xs flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    Salin
                            </button>
                            </div>
                            <p class="font-mono text-lg font-bold">0032836836</p>
                            <div>
                                <p class="text-xs text-gray-500">Atas Nama</p>
                                <p class="font-medium">Andi Reza Zulkarnaen</p>
                            </div>
                        </div>
                    </div>
                    <!-- WhatsApp Admin Link -->
                    <div class="bg-white rounded-xl border shadow p-6">
                        <h4 class="font-semibold text-lg mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Konfirmasi via WhatsApp
                        </h4>
                        <p class="text-gray-600 mb-2 text-sm">Setelah upload bukti pembayaran, silakan konfirmasi ke admin melalui WhatsApp dengan menyertakan:</p>
                        <ul class="list-disc list-inside text-gray-600 mb-2 text-sm space-y-1">
                            <li>Nomor Order: <span class="font-medium">{{ $checkout->order_number }}</span></li>
                            <li>Screenshot bukti pembayaran</li>
                            <li>Nama lengkap peserta</li>
                        </ul>
                        <a href="https://wa.me/6281515788271?text=Halo Admin, saya ingin konfirmasi pembayaran untuk Order %23{{ $checkout->order_number }}"
                           target="_blank"
                           class="inline-flex items-center justify-center w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Hubungi Admin via WhatsApp
                        </a>
                    </div>
                </div>
            <!-- Upload Bukti Pembayaran -->
                <div class="bg-white rounded-xl border shadow p-6 flex flex-col gap-4">
                    <h4 class="font-semibold text-lg mb-2">Upload Bukti Pembayaran</h4>
                @if($checkout->payment_proof)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Bukti pembayaran yang sudah diupload:</p>
                        <img src="{{ asset('storage/'.$checkout->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-xs rounded shadow border">
                    </div>
                @endif
                @if($checkout->status === 'pending' || $checkout->status === 'waiting')
                    <form action="{{ route('checkout.upload-payment', $checkout->unique_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                Pilih File Bukti Pembayaran
                            </label>
                            <input type="file" name="payment_proof" accept="image/*" {{ $checkout->payment_proof ? '' : 'required' }}
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent/90">
                                <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG (Max. 2MB)</p>
                            @error('payment_proof')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                            {{ $checkout->payment_proof ? 'Ganti Bukti Pembayaran' : 'Upload Bukti Pembayaran' }}
                        </button>
                    </form>
                @endif
            </div>
            </div>
            <!-- Penting! -->
            <div class="mt-8 p-5 bg-yellow-50 rounded-xl flex items-start gap-3 shadow">
                    <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                <div>
                    <h3 class="text-sm font-bold text-yellow-800">Penting!</h3>
                    <ul class="list-disc list-inside text-sm text-yellow-700 mt-1">
                                <li>Pembayaran harus dilakukan dalam waktu 24 jam</li>
                                <li>Pendaftaran akan dibatalkan otomatis jika pembayaran tidak dilakukan</li>
                                <li>Simpan nomor order Anda: <span class="font-medium">{{ $checkout->order_number }}</span></li>
                            </ul>
                        </div>
                    </div>
            <!-- Aksi -->
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
            </a>
            <button onclick="window.print()" class="flex items-center px-4 py-2 bg-accent text-white rounded hover:bg-accent/90 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Halaman
            </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor rekening berhasil disalin!');
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}
</script>
@endpush
