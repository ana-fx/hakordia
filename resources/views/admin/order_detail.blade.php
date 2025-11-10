@extends('layouts.app')

@section('title', 'Detail Order ' . $checkout->order_number)

@section('content')
<div class="max-w-4xl mx-auto py-8 space-y-8">
    <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-8 items-start">
        <div class="flex-1">
            <h2 class="text-2xl font-bold mb-4">Detail Order #{{ $checkout->order_number }}</h2>
            <div class="mb-2">
                <span class="font-semibold">Status:</span>
                <span class="px-2 py-1 rounded text-xs font-semibold
                    @if($checkout->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($checkout->status === 'waiting') bg-blue-100 text-blue-800
                    @elseif($checkout->status === 'paid') bg-green-100 text-green-800
                    @elseif($checkout->status === 'verified') bg-green-700 text-white
                    @elseif($checkout->status === 'expired') bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($checkout->status) }}
                </span>
            </div>
            <div class="mb-2">
                <span class="font-semibold">Total Pembayaran:</span> Rp {{ number_format($checkout->total_amount, 0, ',', '.') }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Batas Pembayaran:</span> {{ $checkout->payment_deadline->format('d M Y H:i') }}
            </div>
        </div>
        <div class="flex flex-col items-center">
            <span class="font-semibold mb-2">Bukti Pembayaran:</span>
            @if($checkout->payment_proof)
                <img src="{{ asset('storage/'.$checkout->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-xs rounded shadow border">
            @else
                <span class="text-gray-400">-</span>
            @endif
        </div>
    </div>
    <div class="space-y-6">
        <h3 class="text-xl font-semibold mb-2">Data Peserta</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($checkout->participants as $i => $p)
            <div class="bg-white shadow rounded-lg p-5 flex flex-col gap-2">
                <div class="flex items-center mb-2">
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent/10 text-accent mr-2">Peserta #{{ $i+1 }}</span>
                    <span class="font-bold text-lg">{{ $p->full_name }}</span>
                </div>
                <div><span class="font-semibold">NIK:</span> {{ $p->nik }}</div>
                <div><span class="font-semibold">Email:</span> {{ $p->email }}</div>
                <div><span class="font-semibold">No. WA:</span> {{ $p->whatsapp_number }}</div>
                <div><span class="font-semibold">Ukuran Jersey:</span> {{ $p->jersey_size }}</div>
                <div><span class="font-semibold">Alamat:</span> {{ $p->address }}</div>
                <div><span class="font-semibold">Kota:</span> {{ $p->city }}</div>
                <div><span class="font-semibold">Tgl Lahir:</span> {{ $p->date_of_birth ? \Carbon\Carbon::parse($p->date_of_birth)->format('d-m-Y') : '-' }}</div>
                <div><span class="font-semibold">Gol. Darah:</span> {{ $p->blood_type }}</div>
                <div><span class="font-semibold">Kontak Darurat:</span> {{ $p->emergency_contact_number }}</div>
                <div><span class="font-semibold">Penyakit:</span> {{ $p->medical_conditions ?? '-' }}</div>
            </div>
            @empty
            <div class="text-gray-500 col-span-2">Tidak ada peserta.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
