@csrf

<div class="space-y-6">
    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Tahap</label>
            <input type="text" name="name" value="{{ old('name', $ticket->name ?? '') }}" required class="block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Misal: Presale 1">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Harga (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $ticket->price ?? '') }}" required min="0" class="block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="140000">
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ old('start_date', optional($ticket->start_date ?? null)->format('Y-m-d')) }}" required class="block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Berakhir</label>
            <input type="date" name="end_date" value="{{ old('end_date', optional($ticket->end_date ?? null)->format('Y-m-d')) }}" required class="block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary">
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Kuota</label>
            <input type="number" name="quota" value="{{ old('quota', $ticket->quota ?? '') }}" min="0" class="block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Kosongkan jika tidak terbatas">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Catatan</label>
            <input type="text" name="notes" value="{{ old('notes', $ticket->notes ?? '') }}" class="block w-full rounded-xl border-gray-300 px-4 py-2 text-base shadow focus:border-primary focus:ring-primary" placeholder="Opsional">
        </div>
    </div>
</div>

<div class="mt-8 flex items-center justify-between">
    <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Kembali</a>
    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-2.5 text-sm font-semibold text-white shadow hover:bg-primary/90 transition">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Simpan
    </button>
</div>


