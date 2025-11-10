<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        $tickets = Ticket::orderBy('start_date')->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create(): View
    {
        return view('admin.tickets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Ticket::create($data);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil dibuat.');
    }

    public function edit(Ticket $ticket): View
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $data = $this->validatedData($request, $ticket->id);

        $ticket->update($data);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket berhasil dihapus.');
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tickets', 'name')->ignore($ignoreId)],
            'price' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'quota' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);
    }
}


