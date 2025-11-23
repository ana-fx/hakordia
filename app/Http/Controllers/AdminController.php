<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
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
                $query->whereIn('status', ['paid', 'verified']);
            })->count(),
            'total_income' => Checkout::whereIn('status', ['paid', 'verified'])->sum('total_amount'),
            'pending' => Checkout::where('status', 'pending')->count(),
            'waiting' => Checkout::where('status', 'waiting')->count(),
            'paid' => Checkout::whereIn('status', ['paid', 'verified'])->count(),
            'expired' => Checkout::where('status', 'expired')->count()
        ];

        // Build query with search and filters
        $query = Checkout::with(['participants' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'ticket']);

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
                    // Search in ticket name
                    ->orWhereHas('ticket', function($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%");
                    })
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
        $checkout = \App\Models\Checkout::with(['ticket', 'participants'])->findOrFail($id);
        $oldStatus = $checkout->status;
        $newStatus = $request->status;

        // Update status
        $checkout->status = $newStatus;

        // Set paid_at timestamp when status changes to paid
        if ($oldStatus !== 'paid' && $newStatus === 'paid') {
            $checkout->paid_at = now();
        } elseif ($oldStatus === 'paid' && $newStatus !== 'paid') {
            $checkout->paid_at = null;
        }

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

        // Send payment success email when status changes to paid
        if ($oldStatus !== 'paid' && $newStatus === 'paid') {
            try {
                $url = url(route('checkout.public', $checkout->unique_id, false));
                $paidAt = $checkout->paid_at ? $checkout->paid_at->format('d F Y, H:i') : now()->format('d F Y, H:i');
                $ticketName = $checkout->ticket ? $checkout->ticket->name : null;

                // Send email to all participants
                foreach ($checkout->participants as $participant) {
                    \App\Jobs\SendPaymentSuccessEmail::dispatch(
                        $participant->email,
                        $url,
                        $checkout->order_number,
                        $checkout->total_amount,
                        $paidAt,
                        $ticketName
                    );
                }

                \Illuminate\Support\Facades\Log::info('Payment success emails dispatched', [
                    'checkout_id' => $checkout->id,
                    'order_number' => $checkout->order_number,
                    'participants_count' => $checkout->participants->count()
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal dispatch payment success email: ' . $e->getMessage());
            }
        }

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
                $query->whereIn('status', ['paid', 'verified']);
            })->count(),
            'total_income' => Checkout::whereIn('status', ['paid', 'verified'])->sum('total_amount'),
            'pending' => Checkout::where('status', 'pending')->count(),
            'waiting' => Checkout::where('status', 'waiting')->count(),
            'paid' => Checkout::whereIn('status', ['paid', 'verified'])->count(),
            'expired' => Checkout::where('status', 'expired')->count()
        ];

        return response()->json($totals);
    }

    public function orderDetail($order_number)
    {
        $checkout = \App\Models\Checkout::with(['participants', 'ticket', 'redeemedBy'])->where('order_number', $order_number)->firstOrFail();
        // Ambil semua registration yang email/nik-nya sama dengan peserta di checkout
        $registrations = \App\Models\Registration::whereIn('nik', $checkout->participants->pluck('nik'))
            ->orWhereIn('email', $checkout->participants->pluck('email'))
            ->get();
        return view('admin.order_detail', compact('checkout', 'registrations'));
    }

    public function editOrder($order_number)
    {
        $checkout = \App\Models\Checkout::with(['participants', 'ticket'])->where('order_number', $order_number)->firstOrFail();
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

            // Set paid_at timestamp when status changes to paid
            if ($oldStatus !== 'paid' && $newStatus === 'paid') {
                $checkout->paid_at = now();
            } elseif ($oldStatus === 'paid' && $newStatus !== 'paid') {
                $checkout->paid_at = null;
            }

            $checkout->status = $newStatus;
            $checkout->save();

            // Send payment success email when status changes to paid
            if ($oldStatus !== 'paid' && $newStatus === 'paid') {
                try {
                    $url = url(route('checkout.public', $checkout->unique_id, false));
                    $paidAt = $checkout->paid_at ? $checkout->paid_at->format('d F Y, H:i') : now()->format('d F Y, H:i');
                    $ticketName = $checkout->ticket ? $checkout->ticket->name : null;

                    // Send email to all participants
                    foreach ($checkout->participants as $participant) {
                        \App\Jobs\SendPaymentSuccessEmail::dispatch(
                            $participant->email,
                            $url,
                            $checkout->order_number,
                            $checkout->total_amount,
                            $paidAt,
                            $ticketName
                        );
                    }

                    \Illuminate\Support\Facades\Log::info('Payment success emails dispatched from updateOrder', [
                        'checkout_id' => $checkout->id,
                        'order_number' => $checkout->order_number,
                        'participants_count' => $checkout->participants->count()
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal dispatch payment success email from updateOrder: ' . $e->getMessage());
                }
            }
        }
        return redirect()->route('admin.orderDetail', $order_number)->with('success', 'Data order dan peserta berhasil diperbarui.');
    }

    public function deleteOrder($order_number)
    {
        $checkout = Checkout::where('order_number', $order_number)->firstOrFail();
        $checkout->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Order berhasil dihapus.');
    }

    /**
     * Resend payment success email untuk transaksi yang sudah paid
     */
    public function resendPaymentEmail(Request $request, $order_number)
    {
        $checkout = Checkout::with(['participants', 'ticket'])->where('order_number', $order_number)->firstOrFail();

        // Hanya bisa resend untuk checkout yang statusnya paid atau verified
        if (!in_array($checkout->status, ['paid', 'verified'])) {
            $errorMessage = 'Email hanya dapat dikirim ulang untuk transaksi yang sudah dibayar (paid/verified).';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }

            return back()->with('error', $errorMessage);
        }

        try {
            $url = url(route('checkout.public', $checkout->unique_id, false));
            $paidAt = $checkout->paid_at ? $checkout->paid_at->format('d F Y, H:i') : now()->format('d F Y, H:i');
            $ticketName = $checkout->ticket ? $checkout->ticket->name : null;

            $emailsSent = 0;
            $emailsFailed = [];

            // Send email to all participants menggunakan data asli
            foreach ($checkout->participants as $participant) {
                try {
                    \App\Jobs\SendPaymentSuccessEmail::dispatch(
                        $participant->email,
                        $url,
                        $checkout->order_number,
                        $checkout->total_amount,
                        $paidAt,
                        $ticketName
                    );
                    $emailsSent++;
                } catch (\Exception $e) {
                    $emailsFailed[] = $participant->email . ': ' . $e->getMessage();
                    \Illuminate\Support\Facades\Log::error('Gagal kirim email ke ' . $participant->email . ': ' . $e->getMessage());
                }
            }

            \Illuminate\Support\Facades\Log::info('Payment success emails resent', [
                'checkout_id' => $checkout->id,
                'order_number' => $checkout->order_number,
                'participants_count' => $checkout->participants->count(),
                'emails_sent' => $emailsSent,
                'emails_failed' => count($emailsFailed)
            ]);

            if ($emailsSent > 0) {
                $message = "Email berhasil dikirim ulang ke {$emailsSent} peserta.";
                if (count($emailsFailed) > 0) {
                    $message .= " Gagal: " . implode(', ', $emailsFailed);
                }

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => $message
                    ]);
                }

                return back()->with('success', $message);
            } else {
                $errorMessage = 'Gagal mengirim email ke semua peserta: ' . implode(', ', $emailsFailed);

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage
                    ], 400);
                }

                return back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal resend payment success email: ' . $e->getMessage());
            $errorMessage = 'Gagal mengirim email: ' . $e->getMessage();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Show scanner page for ticket verification
     */
    public function scanner()
    {
        return view('admin.scanner');
    }

    /**
     * Verify ticket from QR code scan
     */
    public function verifyTicket(Request $request)
    {
        $request->validate([
            'unique_id' => 'required|string',
        ]);

        try {
            // Extract unique_id from URL if full URL is provided
            $uniqueId = $request->unique_id;
            if (filter_var($uniqueId, FILTER_VALIDATE_URL)) {
                // Extract UUID from URL like: https://www.hakordia.online/register/{uuid}
                if (preg_match('/\/register\/([a-f0-9\-]{36})/i', $uniqueId, $matches)) {
                    $uniqueId = $matches[1];
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Format URL tidak valid. Pastikan QR code dari tiket yang benar.'
                    ], 400);
                }
            }

            // Validate UUID format
            if (!preg_match('/^[a-f0-9\-]{36}$/i', $uniqueId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format unique ID tidak valid.'
                ], 400);
            }

            // Find checkout by unique_id
            $checkout = Checkout::with(['participants', 'ticket', 'redeemedBy'])
                ->where('unique_id', $uniqueId)
                ->first();

            if (!$checkout) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket tidak ditemukan. Pastikan QR code valid dan belum expired.'
                ], 404);
            }

            // Check if ticket is paid or verified
            if (!in_array($checkout->status, ['paid', 'verified'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket belum dibayar. Status: ' . ucfirst($checkout->status),
                    'checkout' => [
                        'order_number' => $checkout->order_number,
                        'status' => $checkout->status,
                    ]
                ], 400);
            }

            // Check if already redeemed
            if ($checkout->redeemed_at !== null) {
                $redeemedBy = $checkout->redeemedBy ? $checkout->redeemedBy->name : 'Unknown';
                $redeemedAt = $checkout->redeemed_at->format('d M Y, H:i');

                return response()->json([
                    'success' => false,
                    'message' => 'Tiket sudah ditukarkan sebelumnya.',
                    'already_redeemed' => true,
                    'checkout' => [
                        'order_number' => $checkout->order_number,
                        'redeemed_at' => $redeemedAt,
                        'redeemed_by' => $redeemedBy,
                    ]
                ], 400);
            }

            // Verify ticket (mark as redeemed)
            $checkout->redeemed_at = now();
            $checkout->redeemed_by = Auth::id();
            $checkout->status_verifikasi = 'verified';
            $checkout->save();

            // Log verification
            \Illuminate\Support\Facades\Log::info('Ticket verified', [
                'checkout_id' => $checkout->id,
                'order_number' => $checkout->order_number,
                'unique_id' => $checkout->unique_id,
                'verified_by' => Auth::id(),
                'verified_at' => $checkout->redeemed_at,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil diverifikasi dan ditukarkan!',
                'checkout' => [
                    'id' => $checkout->id,
                    'order_number' => $checkout->order_number,
                    'total_participants' => $checkout->total_participants,
                    'ticket_name' => $checkout->ticket ? $checkout->ticket->name : 'N/A',
                    'participants' => $checkout->participants->map(function($p) {
                        return [
                            'name' => $p->full_name,
                            'email' => $p->email,
                            'whatsapp' => $p->whatsapp_number,
                        ];
                    }),
                    'redeemed_at' => $checkout->redeemed_at->format('d M Y, H:i'),
                    'redeemed_by' => Auth::user()->name,
                ]
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error verifying ticket', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memverifikasi tiket: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show scanner reports - list of redeemed tickets
     */
    public function scannerReports(Request $request)
    {
        // Build query for redeemed checkouts
        $query = Checkout::with(['participants', 'ticket', 'redeemedBy'])
            ->whereNotNull('redeemed_at');

        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('order_number', 'like', "%{$searchTerm}%")
                    ->orWhereHas('participants', function($q) use ($searchTerm) {
                        $q->where('full_name', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%")
                            ->orWhere('whatsapp_number', 'like', "%{$searchTerm}%")
                            ->orWhere('nik', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('redeemedBy', function($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Apply date filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('redeemed_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('redeemed_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sortField = $request->get('sort', 'redeemed_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSortFields = ['redeemed_at', 'order_number', 'total_amount', 'total_participants'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $checkouts = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total_redeemed' => Checkout::whereNotNull('redeemed_at')->count(),
            'today_redeemed' => Checkout::whereNotNull('redeemed_at')
                ->whereDate('redeemed_at', today())
                ->count(),
            'total_participants_redeemed' => CheckoutParticipant::whereHas('checkout', function($q) {
                $q->whereNotNull('redeemed_at');
            })->count(),
        ];

        return view('admin.scanner_reports', [
            'checkouts' => $checkouts,
            'stats' => $stats,
            'currentSort' => $sortField,
            'currentDirection' => $sortDirection,
        ]);
    }
}
