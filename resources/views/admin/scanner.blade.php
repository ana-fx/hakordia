@extends('layouts.admin', ['title' => 'Scanner Verifikasi Tiket'])

@section('content')
<div class="space-y-6">
    <header class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/70">Verifikasi Tiket</p>
            <h1 class="text-3xl font-extrabold text-slate-900">Scanner QR Code</h1>
            <p class="text-sm text-slate-500">Scan QR code tiket untuk memverifikasi penukaran barang fisik.</p>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Scanner Section -->
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-900">Scan QR Code</h2>

            <div class="space-y-4">
                <!-- Camera Scanner -->
                <div class="relative">
                    <div id="qr-reader" class="w-full rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 overflow-hidden" style="min-height: 300px;"></div>
                    <div id="qr-reader-results" class="mt-4 hidden rounded-lg border border-slate-200 bg-slate-50 p-4"></div>
                </div>

                <!-- Manual Input -->
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Atau Input Manual</label>
                    <div class="flex gap-2">
                        <input
                            type="text"
                            id="manual-input"
                            placeholder="Masukkan unique_id atau URL tiket"
                            class="flex-1 rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        >
                        <button
                            id="verify-manual-btn"
                            class="rounded-lg bg-primary px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20"
                        >
                            Verifikasi
                        </button>
                    </div>
                </div>

                <!-- Control Buttons -->
                <div class="flex gap-3">
                    <button
                        id="start-scanner-btn"
                        class="flex-1 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                        <svg class="mr-2 inline h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Mulai Scan
                    </button>
                    <button
                        id="stop-scanner-btn"
                        class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300"
                        style="display: none;"
                    >
                        <svg class="mr-2 inline h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                        </svg>
                        Stop Scan
                    </button>
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-900">Hasil Verifikasi</h2>

            <div id="verification-result" class="space-y-4">
                <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
                    <svg class="mb-4 h-16 w-16 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M12 3a9 9 0 00-9 9c0 4.97 4.03 9 9 9s9-4.03 9-9a9 9 0 00-9-9z"/>
                    </svg>
                    <p class="text-sm font-semibold text-slate-500">Belum ada hasil verifikasi</p>
                    <p class="mt-1 text-xs text-slate-400">Scan QR code atau input manual untuk memverifikasi tiket</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="pointer-events-none fixed right-4 top-4 z-50 flex flex-col gap-3"></div>

<!-- Camera Permission Modal -->
<div id="camera-permission-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="mx-4 w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl">
        <div class="text-center">
            <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="mb-2 text-xl font-bold text-slate-900">Izin Akses Kamera</h3>
            <p class="mb-6 text-sm text-slate-600">
                Untuk memindai QR code, aplikasi memerlukan akses ke kamera Anda.
                Klik tombol di bawah untuk memberikan izin.
            </p>
            <div class="flex gap-3">
                <button
                    id="permission-cancel-btn"
                    class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </button>
                <button
                    id="permission-allow-btn"
                    class="flex-1 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90"
                >
                    Berikan Izin
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('admin-head')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@push('admin-scripts')
<script>
let html5QrCode = null;
let isScanning = false;

// Toast notification function
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'pointer-events-auto flex items-center gap-3 min-w-[280px] max-w-md rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-2xl transform transition-all duration-300 ease-out translate-x-full opacity-0';

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

    const closeBtn = document.createElement('button');
    closeBtn.className = 'ml-auto flex-shrink-0 rounded-full p-1 text-white/80 hover:bg-white/20 transition';
    closeBtn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
    closeBtn.onclick = () => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    };

    toast.innerHTML = `${iconSvg}<span class="flex-1">${message}</span>`;
    toast.appendChild(closeBtn);
    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    });

    const timeout = setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
    toast.dataset.timeout = timeout;
}

// Check if library is loaded
function checkLibraryLoaded() {
    if (typeof Html5Qrcode === 'undefined') {
        const qrReader = document.getElementById('qr-reader');
        if (qrReader) {
            qrReader.innerHTML = `
                <div class="flex flex-col items-center justify-center p-8 text-center">
                    <svg class="mb-4 h-16 w-16 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="mb-2 text-sm font-semibold text-slate-900">Library Tidak Ter-load</p>
                    <p class="text-xs text-slate-600">Html5Qrcode library gagal dimuat. Silakan refresh halaman.</p>
                    <button onclick="location.reload()" class="mt-4 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">Refresh Halaman</button>
                </div>
            `;
        }
        return false;
    }
    return true;
}

// Show camera permission modal
function showCameraPermissionModal() {
    const modal = document.getElementById('camera-permission-modal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

// Hide camera permission modal
function hideCameraPermissionModal() {
    const modal = document.getElementById('camera-permission-modal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Initialize scanner
document.addEventListener('DOMContentLoaded', function() {
    // Wait for library to load
    let checkCount = 0;
    const maxChecks = 10;

    function waitForLibrary() {
        if (checkLibraryLoaded()) {
            initializeScanner();
        } else if (checkCount < maxChecks) {
            checkCount++;
            setTimeout(waitForLibrary, 200);
        }
    }

    waitForLibrary();
});

function initializeScanner() {
    const startBtn = document.getElementById('start-scanner-btn');
    const stopBtn = document.getElementById('stop-scanner-btn');
    const verifyManualBtn = document.getElementById('verify-manual-btn');
    const manualInput = document.getElementById('manual-input');
    const permissionModal = document.getElementById('camera-permission-modal');
    const permissionAllowBtn = document.getElementById('permission-allow-btn');
    const permissionCancelBtn = document.getElementById('permission-cancel-btn');

    if (!startBtn || !stopBtn || !verifyManualBtn || !manualInput) {
        return;
    }

    // Start scanner - show permission modal first
    startBtn.addEventListener('click', function() {
        showCameraPermissionModal();
    });

    // Permission allow button
    if (permissionAllowBtn) {
        permissionAllowBtn.addEventListener('click', function() {
            hideCameraPermissionModal();
            startScanner();
        });
    }

    // Permission cancel button
    if (permissionCancelBtn) {
        permissionCancelBtn.addEventListener('click', function() {
            hideCameraPermissionModal();
        });
    }

    // Stop scanner
    stopBtn.addEventListener('click', function() {
        stopScanner();
    });

    // Manual verify
    verifyManualBtn.addEventListener('click', function() {
        const value = manualInput.value.trim();
        if (value) {
            verifyTicket(value);
        } else {
            showToast('Masukkan unique_id atau URL tiket', 'warning');
        }
    });

    // Enter key on manual input
    manualInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            verifyManualBtn.click();
        }
    });
}

function startScanner() {
    if (isScanning) {
        return;
    }

    // Check if secure context (HTTPS or localhost)
    if (!window.isSecureContext && location.protocol !== 'https:' && !location.hostname.match(/^(localhost|127\.0\.0\.1|\[::1\])$/)) {
        const qrReader = document.getElementById('qr-reader');
        const startBtn = document.getElementById('start-scanner-btn');
        const stopBtn = document.getElementById('stop-scanner-btn');
        
        qrReader.innerHTML = `
            <div class="flex flex-col items-center justify-center p-8 text-center">
                <svg class="mb-4 h-16 w-16 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="mb-2 text-sm font-semibold text-slate-900">Secure Context Diperlukan</p>
                <p class="mb-4 text-xs text-slate-600">Browser memerlukan HTTPS atau localhost untuk mengakses kamera.</p>
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-left text-xs w-full max-w-md">
                    <p class="mb-2 font-semibold text-slate-700">Solusi:</p>
                    <ol class="list-inside list-decimal space-y-1 text-slate-600">
                        <li>Gunakan <code class="bg-slate-200 px-1 rounded">localhost</code> atau <code class="bg-slate-200 px-1 rounded">127.0.0.1</code></li>
                        <li>Atau setup HTTPS di Laravel Herd</li>
                        <li>Atau gunakan input manual di bawah</li>
                    </ol>
                    <p class="mt-3 text-slate-600">
                        <strong>URL saat ini:</strong> <code class="bg-slate-200 px-1 rounded">${location.protocol}//${location.hostname}</code>
                    </p>
                </div>
            </div>
        `;
        
        if (startBtn) startBtn.style.display = 'flex';
        if (stopBtn) stopBtn.style.display = 'none';
        showToast('Browser memerlukan HTTPS atau localhost untuk mengakses kamera', 'warning');
        return;
    }

    // Check if getUserMedia is available
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        const qrReader = document.getElementById('qr-reader');
        const startBtn = document.getElementById('start-scanner-btn');
        const stopBtn = document.getElementById('stop-scanner-btn');
        
        qrReader.innerHTML = `
            <div class="flex flex-col items-center justify-center p-8 text-center">
                <svg class="mb-4 h-16 w-16 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="mb-2 text-sm font-semibold text-slate-900">getUserMedia Tidak Tersedia</p>
                <p class="mb-4 text-xs text-slate-600">Browser Anda tidak mendukung akses kamera. Gunakan input manual di bawah.</p>
            </div>
        `;
        
        if (startBtn) startBtn.style.display = 'flex';
        if (stopBtn) stopBtn.style.display = 'none';
        showToast('Browser tidak mendukung akses kamera', 'error');
        return;
    }

    if (typeof Html5Qrcode === 'undefined') {
        showToast('Library scanner tidak tersedia. Silakan refresh halaman.', 'error');
        return;
    }

    const qrReader = document.getElementById('qr-reader');
    const startBtn = document.getElementById('start-scanner-btn');
    const stopBtn = document.getElementById('stop-scanner-btn');

    if (!qrReader) {
        return;
    }

    // Clear previous scanner
    qrReader.innerHTML = '';

    try {
        html5QrCode = new Html5Qrcode("qr-reader");
    } catch (error) {
        showToast('Gagal menginisialisasi scanner: ' + error.message, 'error');
        return;
    }
    
    // Try to start with environment camera first, fallback to any camera
    html5QrCode.start(
        { facingMode: "environment" }, // Use back camera
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0,
        },
        (decodedText, decodedResult) => {
            // Success callback
            handleScanSuccess(decodedText);
        },
        (errorMessage) => {
            // Error callback (ignore)
        }
    ).then(() => {
        isScanning = true;
        startBtn.style.display = 'none';
        stopBtn.style.display = 'flex';
        showToast('Scanner aktif. Arahkan kamera ke QR code', 'info');
    }).catch((err) => {
        // If environment camera fails, try with any available camera
        if (err.message && err.message.includes('environment')) {
            html5QrCode.start(
                { facingMode: "user" }, // Try front camera
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0,
                },
                (decodedText, decodedResult) => {
                    handleScanSuccess(decodedText);
                },
                (errorMessage) => {
                    // Error callback (ignore)
                }
            ).then(() => {
                isScanning = true;
                startBtn.style.display = 'none';
                stopBtn.style.display = 'flex';
                showToast('Scanner aktif (kamera depan). Arahkan kamera ke QR code', 'info');
            }).catch((err2) => {
                // Both failed, show error
                handleCameraError(err2);
            });
        } else {
            handleCameraError(err);
        }
    });
}

function handleCameraError(err) {
    const qrReader = document.getElementById('qr-reader');
    const startBtn = document.getElementById('start-scanner-btn');
    const stopBtn = document.getElementById('stop-scanner-btn');
    
    let errorMessage = 'Gagal mengaktifkan kamera. ';
    let helpMessage = '';

    if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
        errorMessage += 'Izin kamera ditolak. Silakan berikan izin kamera di pengaturan browser.';
        helpMessage = 'Klik ikon kamera di address bar browser dan pilih "Allow" untuk memberikan izin.';
    } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
        errorMessage += 'Kamera tidak ditemukan. Pastikan perangkat memiliki kamera.';
        helpMessage = 'Pastikan perangkat Anda memiliki kamera yang terhubung dan berfungsi.';
    } else if (err.name === 'NotReadableError' || err.name === 'TrackStartError') {
        errorMessage += 'Kamera sedang digunakan aplikasi lain. Tutup aplikasi lain yang menggunakan kamera.';
        helpMessage = 'Tutup aplikasi lain yang menggunakan kamera (Zoom, Teams, dll) dan coba lagi.';
    } else if (err.name === 'OverconstrainedError' || err.name === 'ConstraintNotSatisfiedError') {
        errorMessage += 'Kamera tidak mendukung mode yang diminta.';
        helpMessage = 'Coba gunakan input manual atau gunakan browser yang berbeda.';
    } else if (err.message && (err.message.includes('streaming not supported') || err.message.includes('Camera streaming'))) {
        errorMessage += 'Browser tidak mendukung streaming kamera. Gunakan localhost atau HTTPS.';
        helpMessage = `
            <p class="mb-2">Browser memerlukan secure context untuk mengakses kamera:</p>
            <ol class="list-inside list-decimal space-y-1">
                <li>Gunakan <code class="bg-slate-200 px-1 rounded">http://localhost:8000</code> (jika menggunakan php artisan serve)</li>
                <li>Atau setup HTTPS di Laravel Herd</li>
                <li>Atau gunakan input manual di bawah</li>
            </ol>
            <p class="mt-2"><strong>URL saat ini:</strong> <code class="bg-slate-200 px-1 rounded">${location.protocol}//${location.hostname}</code></p>
        `;
    } else {
        errorMessage += 'Pastikan aplikasi berjalan di localhost atau HTTPS, dan izin kamera diberikan.';
        helpMessage = 'Pastikan aplikasi berjalan di localhost atau HTTPS, dan berikan izin kamera saat diminta.';
    }

    if (typeof showToast === 'function') {
        showToast(errorMessage, 'error');
    }

    if (qrReader) {
        qrReader.innerHTML = `
            <div class="flex flex-col items-center justify-center p-8 text-center">
                <svg class="mb-4 h-16 w-16 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="mb-2 text-sm font-semibold text-slate-900">Gagal Mengaktifkan Kamera</p>
                <p class="mb-4 text-xs text-slate-600">${errorMessage}</p>
                ${helpMessage ? `
                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-left text-xs w-full max-w-md">
                    <p class="mb-2 font-semibold text-slate-700">Solusi:</p>
                    <div class="text-slate-600">${helpMessage}</div>
                    <p class="mt-3 text-slate-600">Atau gunakan input manual di bawah untuk memasukkan unique_id atau URL tiket.</p>
                </div>
                ` : ''}
            </div>
        `;
    }
    
    // Reset button states
    if (startBtn) startBtn.style.display = 'flex';
    if (stopBtn) stopBtn.style.display = 'none';
    isScanning = false;
}

function stopScanner() {
    if (!html5QrCode || !isScanning) return;

    const startBtn = document.getElementById('start-scanner-btn');
    const stopBtn = document.getElementById('stop-scanner-btn');
    const qrReader = document.getElementById('qr-reader');

    html5QrCode.stop().then(() => {
        html5QrCode.clear();
        isScanning = false;
        startBtn.style.display = 'flex';
        stopBtn.style.display = 'none';
        qrReader.innerHTML = '';
        showToast('Scanner dihentikan', 'info');
    }).catch((err) => {
        console.error('Error stopping scanner:', err);
    });
}

function handleScanSuccess(decodedText) {
    // Stop scanner after successful scan
    stopScanner();

    // Verify ticket
    verifyTicket(decodedText);
}

function verifyTicket(uniqueId) {
    const resultDiv = document.getElementById('verification-result');
    const manualInput = document.getElementById('manual-input');

    // Show loading
    resultDiv.innerHTML = `
        <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-primary/30 bg-primary/5 p-12 text-center">
            <div class="mb-4 h-12 w-12 animate-spin rounded-full border-4 border-primary border-t-transparent"></div>
            <p class="text-sm font-semibold text-primary">Memverifikasi tiket...</p>
        </div>
    `;

    // Clear manual input
    manualInput.value = '';

    const verifyUrl = '{{ route("admin.scanner.verify") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // Make API request
    fetch(verifyUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            unique_id: uniqueId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessResult(data.checkout);
            showToast(data.message, 'success');
        } else {
            showErrorResult(data.message, data.checkout, data.already_redeemed);
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showErrorResult('Terjadi kesalahan saat memverifikasi tiket. Silakan coba lagi.');
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
    });
}

function showSuccessResult(checkout) {
    const resultDiv = document.getElementById('verification-result');

    let participantsHtml = '';
    checkout.participants.forEach((participant, index) => {
        participantsHtml += `
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                <p class="font-semibold text-slate-900">${participant.name}</p>
                <p class="text-xs text-slate-500">${participant.email}</p>
                <p class="text-xs text-slate-500">${participant.whatsapp}</p>
            </div>
        `;
    });

    resultDiv.innerHTML = `
        <div class="space-y-4">
            <div class="rounded-xl border-2 border-emerald-200 bg-emerald-50 p-6 text-center">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-emerald-900">Tiket Berhasil Diverifikasi!</h3>
                <p class="text-sm text-emerald-700">Tiket telah ditukarkan dengan barang fisik</p>
            </div>

            <div class="space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Order Number</span>
                    <span class="font-bold text-slate-900">${checkout.order_number}</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Tiket</span>
                    <span class="font-semibold text-slate-900">${checkout.ticket_name}</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Jumlah Peserta</span>
                    <span class="font-semibold text-slate-900">${checkout.total_participants}</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Diverifikasi Oleh</span>
                    <span class="font-semibold text-slate-900">${checkout.redeemed_by}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Waktu</span>
                    <span class="font-semibold text-slate-900">${checkout.redeemed_at}</span>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-500">Daftar Peserta</h4>
                <div class="space-y-2">
                    ${participantsHtml}
                </div>
            </div>
        </div>
    `;
}

function showErrorResult(message, checkout = null, alreadyRedeemed = false) {
    const resultDiv = document.getElementById('verification-result');

    let additionalInfo = '';
    if (checkout) {
        if (alreadyRedeemed) {
            additionalInfo = `
                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <p class="text-xs font-semibold text-amber-900">Informasi Penukaran Sebelumnya</p>
                    <p class="mt-1 text-xs text-amber-700">Order: ${checkout.order_number}</p>
                    <p class="text-xs text-amber-700">Ditukarkan: ${checkout.redeemed_at}</p>
                    <p class="text-xs text-amber-700">Oleh: ${checkout.redeemed_by}</p>
                </div>
            `;
        } else {
            additionalInfo = `
                <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-900">Order: ${checkout.order_number}</p>
                    <p class="text-xs text-slate-600">Status: ${checkout.status}</p>
                </div>
            `;
        }
    }

    resultDiv.innerHTML = `
        <div class="space-y-4">
            <div class="rounded-xl border-2 border-red-200 bg-red-50 p-6 text-center">
                <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-500">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-red-900">Verifikasi Gagal</h3>
                <p class="text-sm text-red-700">${message}</p>
            </div>
            ${additionalInfo}
        </div>
    `;
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (html5QrCode && isScanning) {
        stopScanner();
    }
});
</script>
@endpush

