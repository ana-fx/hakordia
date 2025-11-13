@extends('layouts.app')

@section('title', 'Checkout Pendaftaran - Hakordia Fun Night Run')

@section('content')
@php
    use App\Support\StatusStyle;

    $statusSteps = [
        ['key' => 'pending', 'label' => 'Menunggu Pembayaran'],
        ['key' => 'waiting', 'label' => 'Menunggu Verifikasi'],
        ['key' => 'paid', 'label' => 'Pembayaran Diterima'],
        ['key' => 'verified', 'label' => 'Terverifikasi'],
    ];
@endphp

<div class="mx-auto max-w-4xl px-4 py-12 print:px-0">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm print:border print:rounded-none print:shadow-none">
        <header class="flex flex-col gap-3 border-b border-slate-200 px-6 py-6 print:px-4 print:py-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Checkout Pendaftaran</h1>
                <p class="text-sm text-slate-600">Order <span class="font-semibold text-primary">#{{ $checkout->order_number }}</span></p>
                <p class="text-xs text-slate-500">Batas pembayaran: {{ $checkout->payment_deadline->format('d M Y H:i') }}</p>
                @if($checkout->ticket)
                    <p class="text-xs text-slate-500">Tahap tiket: {{ $checkout->ticket->name }} · Rp {{ number_format($checkout->ticket->price, 0, ',', '.') }}</p>
                @endif
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($statusSteps as $step)
                    @php $active = $step['key'] === $checkout->status; @endphp
                    <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $active ? 'border-primary bg-primary/10 text-primary' : 'border-slate-200 text-slate-500' }}">
                        {{ $step['label'] }}
                        </span>
                @endforeach
            </div>
        </header>

        <div class="space-y-8 px-6 py-6 print:px-4 print:py-0">
            <section class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 print:bg-white print:border">
                <h2 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Ringkasan Pembayaran</h2>
                <div class="mt-3 grid gap-2 text-sm text-slate-700 sm:grid-cols-2">
                    <div>Jumlah peserta: <span class="font-semibold text-slate-900">{{ $checkout->total_participants }}</span></div>
                    <div>Total pembayaran: <span class="font-semibold text-primary">Rp {{ number_format($checkout->total_amount, 0, ',', '.') }}</span></div>
                    <div>Status terakhir: <span class="font-semibold">{{ ucfirst($checkout->status) }}</span></div>
                    <div>Order dibuat: {{ $checkout->created_at->format('d M Y H:i') }}</div>
                    @if($checkout->ticket)
                        <div class="flex items-start gap-2 sm:col-span-2 rounded-lg border border-primary/10 bg-white px-4 py-3 text-xs text-slate-600">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-slate-900">Jenis Ticket: {{ $checkout->ticket->name }}</p>
                                <p>Harga tahap: Rp {{ number_format($checkout->ticket->price, 0, ',', '.') }}</p>
                                <p class="mt-1 text-[11px] text-slate-500">Periode {{ \Carbon\Carbon::parse($checkout->ticket->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($checkout->ticket->end_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-900">Data Peserta</h3>
                <div class="overflow-x-auto rounded-xl border border-slate-200 print:border print:rounded-none">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700 print:border">
                        <thead class="bg-slate-50 print:bg-white">
                            <tr class="text-left text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Nama Lengkap</th>
                                <th class="px-4 py-3">NIK</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">No. WhatsApp</th>
                                <th class="px-4 py-3">Ukuran Jersey</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                    @foreach($registrants as $index => $registrant)
                                <tr>
                                    <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $registrant['full_name'] }}</td>
                                    <td class="px-4 py-3">{{ $registrant['nik'] }}</td>
                                    <td class="px-4 py-3">{{ $registrant['email'] }}</td>
                                    <td class="px-4 py-3">{{ $registrant['whatsapp_number'] }}</td>
                                    <td class="px-4 py-3">{{ $registrant['jersey_size'] ?? 'All Size' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                            </div>
            </section>

            <section class="grid gap-6 md:grid-cols-2">
                <div class="rounded-xl border border-slate-200 px-4 py-4 print:border">
                    <h3 class="text-lg font-semibold text-slate-900">Instruksi Pembayaran</h3>
                    <div class="mt-3 space-y-3 text-sm text-slate-700">
                            <div>
                            <p class="text-xs text-slate-500">Bank</p>
                            <p class="font-semibold text-slate-900">BCA</p>
                            </div>
                            <div>
                            <p class="text-xs text-slate-500">Nomor Rekening</p>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="font-mono text-base font-semibold text-slate-900">2000937676</span>
                                <button type="button" onclick="copyToClipboard('2000937676')" class="text-xs font-semibold text-primary hover:text-primary/80">Salin</button>
                            </div>
                            </div>
                            <div>
                            <p class="text-xs text-slate-500">Atas Nama</p>
                            <p class="font-semibold text-slate-900">Andy Reza Zulkarnaen</p>
                            </div>
                        <ul class="list-disc list-inside text-xs text-slate-600">
                            <li>Tulis berita transfer: {{ $checkout->order_number }}</li>
                            <li>Konfirmasi pembayaran melalui WhatsApp admin (+6285183360304).</li>
                            <li>Simpan bukti transfer untuk diunggah.</li>
                        </ul>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 px-4 py-4 print:border">
                    <h3 class="text-lg font-semibold text-slate-900">Upload Bukti Pembayaran</h3>
                @if($checkout->payment_proof)
                        <div class="mt-3 space-y-2">
                            <p class="text-xs text-slate-500">Bukti pembayaran saat ini:</p>
                            <img src="{{ asset('storage/'.$checkout->payment_proof) }}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-slate-200 object-cover">
                        </div>
                @endif

                    @if(in_array($checkout->status, ['pending', 'waiting']))
                        <form id="paymentProofForm" action="{{ route('checkout.upload-payment', $checkout->unique_id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                        @csrf
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-6 text-center text-sm text-slate-600">
                            <label for="payment_proof" class="flex flex-col items-center gap-2 cursor-pointer">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <span class="font-semibold text-slate-900">Pilih file bukti transfer</span>
                                <span class="text-xs text-slate-500">Klik atau seret file JPG/PNG (maks 2 MB)</span>
                            </label>
                            <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="hidden" {{ $checkout->payment_proof ? '' : 'required' }}>
                            @error('payment_proof')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>
                    @else
                        <p class="mt-4 rounded-md bg-slate-100 px-3 py-2 text-xs text-slate-600">Status pembayaran telah <strong>{{ ucfirst($checkout->status) }}</strong>. Upload tambahan tidak diperlukan.</p>
                @endif
            </div>
            </section>

            <section class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-xs text-amber-800 print:border print:bg-white print:border-amber-200">
                <strong class="block text-sm">Catatan Penting</strong>
                <ul class="mt-2 list-disc list-inside space-y-1">
                    <li>Pembayaran wajib dilakukan dalam 24 jam setelah order dibuat.</li>
                    <li>Pendaftaran dibatalkan otomatis bila melewati batas waktu pembayaran.</li>
                    <li>Simpan nomor order <strong>{{ $checkout->order_number }}</strong> untuk keperluan konfirmasi dan pengambilan race kit.</li>
                            </ul>
            </section>

            <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 text-sm text-slate-600 print:hidden md:flex-row md:items-center md:justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
            </a>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-full bg-secondary px-5 py-2 text-sm font-semibold text-white transition hover:bg-secondary/90">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
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
    navigator.clipboard.writeText(text)
        .then(() => alert('Nomor rekening berhasil disalin!'))
        .catch(() => alert('Gagal menyalin nomor rekening.'));
}

document.addEventListener('DOMContentLoaded', function () {
    const paymentInput = document.getElementById('payment_proof');
    const paymentForm = document.getElementById('paymentProofForm');

    if (paymentInput && paymentForm) {
        paymentInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                paymentForm.submit();
            }
        });
    }
});
</script>
@endpush
