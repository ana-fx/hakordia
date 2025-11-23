@extends('layouts.app')

@section('title', 'Detail Order ' . $checkout->order_number)

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
    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm print:border print:rounded-none print:shadow-none">
        <header class="flex flex-col gap-3 border-b border-slate-200 px-6 py-6 print:px-4 print:py-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Detail Order</h1>
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
                @if($checkout->redeemed_at)
                    <span class="rounded-full border-2 border-green-500 bg-green-50 px-3 py-1 text-xs font-semibold text-green-700 flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Scanned
                    </span>
                @endif
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
                    @if($checkout->paid_at)
                        <div>Dibayar pada: {{ $checkout->paid_at->format('d M Y H:i') }}</div>
                    @endif
                    @if($checkout->redeemed_at)
                        <div class="sm:col-span-2 rounded-lg border-2 border-green-200 bg-green-50 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-green-700">Status: Scanned</p>
                                    <p class="mt-1 text-sm font-semibold text-green-900">Ditukarkan: {{ $checkout->redeemed_at->format('d M Y, H:i') }}</p>
                                    @if($checkout->redeemedBy)
                                        <p class="text-xs text-green-700">Oleh: {{ $checkout->redeemedBy->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="sm:col-span-2 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status: Not Scanned</p>
                                    <p class="mt-1 text-xs text-slate-600">Tiket belum ditukarkan dengan barang fisik</p>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                <th class="px-4 py-3">Alamat</th>
                                <th class="px-4 py-3">Kota</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($checkout->participants as $index => $participant)
                                <tr>
                                    <td class="px-4 py-3 text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $participant->full_name }}</td>
                                    <td class="px-4 py-3">{{ $participant->nik }}</td>
                                    <td class="px-4 py-3">{{ $participant->email }}</td>
                                    <td class="px-4 py-3">{{ $participant->whatsapp_number }}</td>
                                    <td class="px-4 py-3">{{ $participant->address }}</td>
                                    <td class="px-4 py-3">{{ $participant->city }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-3 text-center text-slate-500">Tidak ada peserta.</td>
                                </tr>
                            @endforelse
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
                    <h3 class="text-lg font-semibold text-slate-900">Bukti Pembayaran</h3>
                    @if($checkout->payment_proof)
                        <div class="mt-3 space-y-2">
                            <p class="text-xs text-slate-500">Bukti pembayaran:</p>
                            <img src="{{ asset('storage/'.$checkout->payment_proof) }}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-slate-200 object-cover">
                        </div>
                    @else
                        <p class="mt-4 rounded-md bg-slate-100 px-3 py-2 text-xs text-slate-600">Belum ada bukti pembayaran yang diunggah.</p>
                    @endif
                </div>
            </section>

            @if(in_array($checkout->status, ['paid', 'verified']))
            <section class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 print:bg-white print:border">
                <h2 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">QR Code Akses Cepat</h2>
                <div class="mt-3">
                    @php
                        $checkoutUrl = url(route('checkout.public', $checkout->unique_id, false));
                        $qrCode = null;
                        try {
                            $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                                ->size(200)
                                ->margin(1)
                                ->generate($checkoutUrl);
                            $qrCode = 'data:image/png;base64,' . base64_encode($qrCodeImage);
                        } catch (\Exception $e) {
                            try {
                                $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                                    ->size(200)
                                    ->margin(1)
                                    ->generate($checkoutUrl);
                                $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
                            } catch (\Exception $svgError) {
                                $qrCode = null;
                            }
                        }
                    @endphp
                    @if($qrCode)
                        <div class="flex flex-col items-center">
                            <div class="bg-white p-4 rounded-lg border border-slate-200">
                                <img src="{{ $qrCode }}" alt="QR Code" class="w-48 h-48 mx-auto">
                            </div>
                        </div>
                    @else
                        <div class="rounded-lg bg-amber-50 border border-amber-200 px-3 py-2 text-xs text-amber-800">
                            <p class="font-semibold mb-1">⚠ QR Code tidak tersedia</p>
                            <p>Status checkout: <strong>{{ $checkout->status }}</strong></p>
                            <p class="mt-1">Silakan refresh halaman atau hubungi admin jika masalah berlanjut.</p>
                        </div>
                    @endif
                </div>
            </section>
            @endif

            <section class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-xs text-amber-800 print:border print:bg-white print:border-amber-200">
                <strong class="block text-sm">Catatan Penting</strong>
                <ul class="mt-2 list-disc list-inside space-y-1">
                    <li>Pembayaran wajib dilakukan dalam 24 jam setelah order dibuat.</li>
                    <li>Pendaftaran dibatalkan otomatis bila melewati batas waktu pembayaran.</li>
                    <li>Simpan nomor order <strong>{{ $checkout->order_number }}</strong> untuk keperluan konfirmasi dan pengambilan race kit.</li>
                </ul>
            </section>

            <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 text-sm text-slate-600 print:hidden md:flex-row md:items-center md:justify-between">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-primary">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Dashboard
                </a>
                <div class="flex flex-wrap gap-3">
                    @if(in_array($checkout->status, ['paid', 'verified']))
                        <form id="resendEmailForm" action="{{ route('admin.resendPaymentEmail', $checkout->order_number) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" id="resendEmailBtn" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2 text-sm font-semibold text-white transition hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span id="resendEmailBtnText">Kirim Ulang Email</span>
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.editOrder', $checkout->order_number) }}" class="inline-flex items-center gap-2 rounded-full bg-secondary px-5 py-2 text-sm font-semibold text-white transition hover:bg-secondary/90">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 00-4-4l-8 8v3h3z"/></svg>
                        Edit Order
                    </a>
                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-full bg-slate-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak Halaman
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

<!-- Confirmation Modal -->
<div id="resendEmailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-md transform scale-95 rounded-2xl bg-white shadow-2xl opacity-0 transition-all duration-200">
        <div class="px-6 py-5">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-slate-900">Konfirmasi Kirim Ulang Email</h3>
                    <p class="mt-1 text-sm text-slate-600">Apakah Anda yakin ingin mengirim ulang email payment success ke semua peserta?</p>
                </div>
            </div>
        </div>
        <div class="flex gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
            <button id="resendEmailModalCancel" type="button" class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Batal
            </button>
            <button id="resendEmailModalConfirm" type="button" class="flex-1 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                Ya, Kirim Ulang
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => showToast('Nomor rekening berhasil disalin!', 'success'))
        .catch(() => showToast('Gagal menyalin nomor rekening.', 'error'));
}

// Toast notification function dengan Tailwind CSS
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'pointer-events-auto flex items-center gap-3 min-w-[280px] max-w-md rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-2xl transform transition-all duration-300 ease-out translate-x-full opacity-0';

    // Set background color based on type
    if (type === 'success') {
        toast.classList.add('bg-green-500');
    } else if (type === 'error') {
        toast.classList.add('bg-red-500');
    } else if (type === 'warning') {
        toast.classList.add('bg-amber-500');
    } else if (type === 'info') {
        toast.classList.add('bg-blue-500');
    } else {
        toast.classList.add('bg-primary');
    }

    // Create icon based on type
    let iconSvg = '';
    if (type === 'success') {
        iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
    } else if (type === 'error') {
        iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
    } else if (type === 'warning') {
        iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
    } else {
        iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    // Create close button
    const closeBtn = document.createElement('button');
    closeBtn.className = 'ml-auto flex-shrink-0 rounded-full p-1 text-white/80 hover:bg-white/20 transition';
    closeBtn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
    closeBtn.onclick = () => removeToast(toast);

    // Build toast content
    toast.innerHTML = `
        ${iconSvg}
        <span class="flex-1">${message}</span>
    `;
    toast.appendChild(closeBtn);

    // Add to container
    container.appendChild(toast);

    // Trigger animation
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    });

    // Auto remove after 4 seconds
    const timeout = setTimeout(() => {
        removeToast(toast);
    }, 4000);

    // Store timeout ID for cleanup
    toast.dataset.timeout = timeout;
}

function removeToast(toast) {
    if (!toast) return;

    // Clear timeout if exists
    if (toast.dataset.timeout) {
        clearTimeout(toast.dataset.timeout);
    }

    // Animate out
    toast.classList.add('translate-x-full', 'opacity-0');
    toast.classList.remove('translate-x-0', 'opacity-100');

    // Remove from DOM after animation
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

// Handle resend email form dengan AJAX dan Modal
document.addEventListener('DOMContentLoaded', function() {
    const resendEmailForm = document.getElementById('resendEmailForm');
    const resendEmailBtn = document.getElementById('resendEmailBtn');
    const resendEmailBtnText = document.getElementById('resendEmailBtnText');
    const resendEmailModal = document.getElementById('resendEmailModal');
    const resendEmailModalConfirm = document.getElementById('resendEmailModalConfirm');
    const resendEmailModalCancel = document.getElementById('resendEmailModalCancel');

    // Function to show modal
    function showModal() {
        if (resendEmailModal) {
            resendEmailModal.classList.remove('hidden');
            resendEmailModal.classList.add('flex');
            // Add animation
            setTimeout(() => {
                const modalContent = resendEmailModal.querySelector('div > div');
                if (modalContent) {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }
            }, 10);
        }
    }

    // Function to hide modal
    function hideModal() {
        if (resendEmailModal) {
            const modalContent = resendEmailModal.querySelector('div > div');
            if (modalContent) {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
            }
            setTimeout(() => {
                resendEmailModal.classList.add('hidden');
                resendEmailModal.classList.remove('flex');
            }, 200);
        }
    }

    // Function to send email
    function sendEmail() {
        hideModal();

        // Disable button
        resendEmailBtn.disabled = true;
        resendEmailBtnText.textContent = 'Mengirim...';

        // Get form data
        const formData = new FormData(resendEmailForm);
        const url = resendEmailForm.action;
        const token = formData.get('_token');

        // Send AJAX request
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json().then(data => {
                    if (data && data.message) {
                        showToast(data.message, data.success ? 'success' : 'error');
                    } else {
                        showToast('Email berhasil dikirim ulang!', 'success');
                    }
                });
            } else {
                // If redirected or HTML response, show success message
                showToast('Email berhasil dikirim ulang!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Gagal mengirim email. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Re-enable button
            resendEmailBtn.disabled = false;
            resendEmailBtnText.textContent = 'Kirim Ulang Email';
        });
    }

    // Handle form submit - show modal instead of direct submit
    if (resendEmailForm) {
        resendEmailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            showModal();
        });
    }

    // Handle confirm button
    if (resendEmailModalConfirm) {
        resendEmailModalConfirm.addEventListener('click', function() {
            sendEmail();
        });
    }

    // Handle cancel button
    if (resendEmailModalCancel) {
        resendEmailModalCancel.addEventListener('click', function() {
            hideModal();
        });
    }

    // Close modal when clicking outside
    if (resendEmailModal) {
        resendEmailModal.addEventListener('click', function(e) {
            if (e.target === resendEmailModal) {
                hideModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && resendEmailModal && !resendEmailModal.classList.contains('hidden')) {
            hideModal();
        }
    });
});
</script>
@endpush
