<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Exports\ParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Checkout;
use App\Models\CheckoutParticipant;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Calculate global totals without search filter
        $globalTotals = [
            'total_participants' => CheckoutParticipant::whereHas('checkout', function($query) {
                $query->where('status', 'paid');
            })->count(),
            'total_income' => Checkout::where('status', 'paid')->sum('total_amount'),
            'pending' => Checkout::where('status', 'pending')->count(),
            'waiting' => Checkout::where('status', 'waiting')->count(),
            'paid' => Checkout::where('status', 'paid')->count(),
            'expired' => Checkout::where('status', 'expired')->count()
        ];

        // Build query with search and filters
        $query = Checkout::with(['participants' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        // Apply filters
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Search in checkout fields
                $q->where('order_number', 'like', "%{$searchTerm}%")
                    ->orWhere('status', 'like', "%{$searchTerm}%")
                    ->orWhere('total_amount', 'like', "%{$searchTerm}%")
                    // Search in participants through the relationship
                    ->orWhereHas('participants', function($q) use ($searchTerm) {
                        $q->where(function($subQ) use ($searchTerm) {
                            $subQ->where('full_name', 'like', "%{$searchTerm}%")
                                ->orWhere('whatsapp_number', 'like', "%{$searchTerm}%")
                                ->orWhere('email', 'like', "%{$searchTerm}%")
                                ->orWhere('nik', 'like', "%{$searchTerm}%")
                                ->orWhere('city', 'like', "%{$searchTerm}%")
                                ->orWhere('jersey_size', 'like', "%{$searchTerm}%")
                                ->orWhere('emergency_contact_number', 'like', "%{$searchTerm}%")
                                ->orWhere('address', 'like', "%{$searchTerm}%");
                        });
                    });
            });
        }

        // Apply sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['created_at', 'order_number', 'total_amount', 'status'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $checkouts = $query->paginate(10)->withQueryString();

        // Get unique cities for filter dropdown
        $cities = CheckoutParticipant::select('city')->distinct()->pluck('city');

        return view('admin.dashboard', [
            'checkouts' => $checkouts,
            'totals' => $globalTotals,
            'cities' => $cities,
            'currentSort' => $sortField,
            'currentDirection' => $sortDirection
        ]);
    }

    public function show($id)
    {
        $participant = Participant::with(['user', 'payment'])
            ->findOrFail($id);

        return view('admin.show', compact('participant'));
    }

    public function export()
    {
        return Excel::download(new ParticipantsExport, 'participants.xlsx');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,waiting,paid,expired,verified',
        ]);
        $checkout = \App\Models\Checkout::with('ticket')->findOrFail($id);
        $oldStatus = $checkout->status;
        $newStatus = $request->status;

        // Update status
        $checkout->status = $newStatus;

        // Handle quota reduction/increase when status changes
        if ($checkout->ticket && $checkout->ticket->quota !== null) {
            // If changing from non-paid to paid, reduce quota
            if ($oldStatus !== 'paid' && $newStatus === 'paid') {
                $remainingQuota = $checkout->ticket->getRemainingQuota();
                if ($remainingQuota < $checkout->total_participants) {
                    return response()->json([
                        'success' => false,
                        'message' => "Kuota tidak mencukupi. Sisa kuota: {$remainingQuota}, dibutuhkan: {$checkout->total_participants}"
                    ], 400);
                }
            }
            // If changing from paid to non-paid, quota will be recalculated automatically via getRemainingQuota()
        }

        $checkout->save();

        // Log quota info for debugging
        if ($checkout->ticket && $checkout->ticket->quota !== null) {
            \Illuminate\Support\Facades\Log::info('Quota updated', [
                'ticket_id' => $checkout->ticket_id,
                'ticket_name' => $checkout->ticket->name,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'participants' => $checkout->total_participants,
                'remaining_quota' => $checkout->ticket->getRemainingQuota(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getTotals()
    {
        $totals = [
            'total_participants' => CheckoutParticipant::whereHas('checkout', function($query) {
                $query->where('status', 'paid');
            })->count(),
            'total_income' => Checkout::where('status', 'paid')->sum('total_amount'),
            'pending' => Checkout::where('status', 'pending')->count(),
            'waiting' => Checkout::where('status', 'waiting')->count(),
            'paid' => Checkout::where('status', 'paid')->count(),
            'expired' => Checkout::where('status', 'expired')->count()
        ];

        return response()->json($totals);
    }

    public function orderDetail($order_number)
    {
        $checkout = \App\Models\Checkout::with('participants')->where('order_number', $order_number)->firstOrFail();
        // Ambil semua registration yang email/nik-nya sama dengan peserta di checkout
        $registrations = \App\Models\Registration::whereIn('nik', $checkout->participants->pluck('nik'))
            ->orWhereIn('email', $checkout->participants->pluck('email'))
            ->get();
        return view('admin.order_detail', compact('checkout', 'registrations'));
    }

    public function editOrder($order_number)
    {
        $checkout = \App\Models\Checkout::with('participants')->where('order_number', $order_number)->firstOrFail();
        $registrations = \App\Models\Registration::whereIn('nik', $checkout->participants->pluck('nik'))
            ->orWhereIn('email', $checkout->participants->pluck('email'))
            ->get();
        return view('admin.edit_order', compact('checkout', 'registrations'));
    }

    public function updateOrder(Request $request, $order_number)
    {
        $checkout = \App\Models\Checkout::with(['participants', 'ticket'])->where('order_number', $order_number)->firstOrFail();
        $registrations = \App\Models\Registration::whereIn('nik', $checkout->participants->pluck('nik'))
            ->orWhereIn('email', $checkout->participants->pluck('email'))
            ->get();
        // Validasi dan update data peserta
        foreach ($registrations as $reg) {
            $reg->update($request->input('registrations.'.$reg->id));
        }
        // Update status jika ada
        if ($request->has('status')) {
            $oldStatus = $checkout->status;
            $newStatus = $request->status;

            // Handle quota when status changes
            if ($checkout->ticket && $checkout->ticket->quota !== null) {
                if ($oldStatus !== 'paid' && $newStatus === 'paid') {
                    $remainingQuota = $checkout->ticket->getRemainingQuota();
                    if ($remainingQuota < $checkout->total_participants) {
                        return back()->withErrors([
                            'status' => "Kuota tidak mencukupi. Sisa kuota: {$remainingQuota}, dibutuhkan: {$checkout->total_participants}"
                        ]);
                    }
                }
            }

            $checkout->status = $newStatus;
            $checkout->save();
        }
        return redirect()->route('admin.orderDetail', $order_number)->with('success', 'Data order dan peserta berhasil diperbarui.');
    }

    public function deleteOrder($order_number)
    {
        $checkout = Checkout::where('order_number', $order_number)->firstOrFail();
        $checkout->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Order berhasil dihapus.');
    }
}
