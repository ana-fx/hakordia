<div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60">
    <div class="relative max-w-lg w-full mx-4">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 rounded-full bg-white/10 p-1 text-white transition hover:bg-white/20">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="rounded-3xl bg-white p-4 shadow-2xl">
            <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-h-[70vh] w-full rounded-2xl object-contain">
            <div class="mt-4 flex justify-center">
                <a id="downloadButton" href="" download class="inline-flex items-center gap-2 rounded-full border border-primary/30 bg-primary/10 px-5 py-2 text-sm font-semibold text-primary hover:bg-primary/20">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Bukti Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>

<div id="toast" class="fixed bottom-6 right-6 z-50 hidden min-w-[220px] max-w-xs rounded-full px-4 py-3 text-sm font-semibold text-white shadow-xl"></div>

