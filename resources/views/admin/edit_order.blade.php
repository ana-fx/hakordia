@extends('layouts.app')

@section('title', 'Edit Order ' . $checkout->order_number)

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Edit Order #{{ $checkout->order_number }}</h2>
        <p class="mt-2 text-sm text-gray-600">Update informasi order dan data peserta</p>
    </div>

    <form action="{{ route('admin.updateOrder', $checkout->order_number) }}" method="POST">
        @csrf
        <!-- Order Information Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Order</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Order</label>
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            <option value="pending" {{ $checkout->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="waiting" {{ $checkout->status == 'waiting' ? 'selected' : '' }}>Waiting</option>
                            <option value="paid" {{ $checkout->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="expired" {{ $checkout->status == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="verified" {{ $checkout->status == 'verified' ? 'selected' : '' }}>Verified</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Pembayaran</label>
                        <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($checkout->total_amount, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Batas Pembayaran</label>
                        <div class="text-gray-900">{{ $checkout->payment_deadline->format('d M Y H:i') }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                        @if($checkout->payment_proof)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$checkout->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-xs rounded-lg shadow-sm border border-gray-200">
                            </div>
                        @else
                            <span class="text-gray-500">Belum ada bukti pembayaran</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants Information -->
        <div class="space-y-6">
            <h3 class="text-xl font-semibold text-gray-900">Data Peserta</h3>
            <div class="grid grid-cols-1 gap-6">
                @forelse($checkout->participants as $i => $p)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $p->full_name }}</h4>
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent/10 text-accent">
                                Peserta #{{ $i+1 }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input type="text" name="participants[{{ $p->id }}][nik]" value="{{ $p->nik }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="participants[{{ $p->id }}][email]" value="{{ $p->email }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. WhatsApp</label>
                                <input type="text" name="participants[{{ $p->id }}][whatsapp_number]" value="{{ $p->whatsapp_number }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Jersey</label>
                                <input type="text" name="participants[{{ $p->id }}][jersey_size]" value="{{ $p->jersey_size }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <input type="text" name="participants[{{ $p->id }}][address]" value="{{ $p->address }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                                <input type="text" name="participants[{{ $p->id }}][city]" value="{{ $p->city }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                <input type="date" name="participants[{{ $p->id }}][date_of_birth]" value="{{ $p->date_of_birth ? $p->date_of_birth->format('Y-m-d') : '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Golongan Darah</label>
                                <input type="text" name="participants[{{ $p->id }}][blood_type]" value="{{ $p->blood_type }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kontak Darurat</label>
                                <input type="text" name="participants[{{ $p->id }}][emergency_contact_number]" value="{{ $p->emergency_contact_number }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit</label>
                                <input type="text" name="participants[{{ $p->id }}][medical_conditions]" value="{{ $p->medical_conditions }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring focus:ring-accent focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-gray-500">Tidak ada peserta.</div>
                @endforelse
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.orderDetail', $checkout->order_number) }}"
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                Kembali
            </a>
            <button type="submit"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
