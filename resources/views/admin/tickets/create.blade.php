@extends('layouts.admin', ['title' => 'Tambah Tiket'])

@section('content')
<div class="mx-auto max-w-3xl space-y-8">
    <header class="space-y-2">
        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary/70">Tambah Data</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Tahap Tiket Baru</h1>
        <p class="text-sm text-slate-500">Masukkan detail harga, periode, serta kuota untuk tahap registrasi ini.</p>
    </header>

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-sm text-red-700 shadow-sm">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tickets.store') }}" method="POST" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @include('admin.tickets._form', ['ticket' => new \App\Models\Ticket()])
    </form>
</div>
@endsection


