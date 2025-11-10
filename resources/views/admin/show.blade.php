<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">← Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-6">Detail Pembayaran</h2>

                    <!-- Payment Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pembayaran</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="font-medium">ID Pembayaran</dt>
                                <dd>{{ $payment->id }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium">Status</dt>
                                <dd>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($payment->status === 'paid') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium">Total Pembayaran</dt>
                                <dd>Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium">Tanggal Pembayaran</dt>
                                <dd>{{ $payment->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </div>
                    </div>

                    <!-- Participants Information -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Data Peserta ({{ $payment->participants->count() }} orang)</h3>
                        @if($payment->participants->count() > 0)
                            @foreach($payment->participants as $i => $participant)
                                <div class="border rounded-lg p-6 mb-4 bg-gray-50">
                                    <div class="flex items-center mb-4">
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent/10 text-accent mr-2">Peserta #{{ $i+1 }}</span>
                                        <span class="font-semibold text-lg text-gray-900">{{ $participant->full_name }}</span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <h4 class="text-md font-semibold mb-2">Data Pribadi</h4>
                                            <dl class="space-y-2">
                                                <div>
                                                    <dt class="font-medium">NIK</dt>
                                                    <dd>{{ $participant->nik }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Email</dt>
                                                    <dd>{{ $participant->email }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">WhatsApp</dt>
                                                    <dd>{{ $participant->whatsapp_number }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Tanggal Lahir</dt>
                                                    <dd>{{ $participant->date_of_birth ? $participant->date_of_birth->format('d/m/Y') : '-' }}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                        <div>
                                            <h4 class="text-md font-semibold mb-2">Informasi Tambahan</h4>
                                            <dl class="space-y-2">
                                                <div>
                                                    <dt class="font-medium">Alamat</dt>
                                                    <dd>{{ $participant->address }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Kota</dt>
                                                    <dd>{{ $participant->city }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Ukuran Jersey</dt>
                                                    <dd>{{ $participant->jersey_size }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Golongan Darah</dt>
                                                    <dd>{{ $participant->blood_type ?? 'Tidak diisi' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Kontak Darurat</dt>
                                                    <dd>{{ $participant->emergency_contact_number }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium">Penyakit Bawaan</dt>
                                                    <dd>{{ $participant->medical_conditions ?? 'Tidak ada' }}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-gray-500">Tidak ada peserta.</div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
