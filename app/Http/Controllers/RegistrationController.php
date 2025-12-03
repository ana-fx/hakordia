<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use App\Models\Checkout;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendEmailNotification;
use App\Models\Setting;
use App\Models\Ticket;

class RegistrationController extends Controller
{
    private const DEFAULT_JERSEY_SIZE = 'All Size';

    public function index()
    {
        // Check total paid participants
        $totalPaidParticipants = \App\Models\CheckoutParticipant::whereHas('checkout', function($query) {
            $query->where('status', 'paid');
        })->count();

        $registrationClosed = Setting::getValue('registration_closed', false);

        // Get available tickets and filter by quota
        $allAvailableTickets = Ticket::available()->orderBy('start_date')->get();

        // Filter tickets that still have quota available
        $availableTickets = $allAvailableTickets->filter(function($ticket) {
            return $ticket->hasAvailableQuota(1);
        });

        // Check if all tickets have exhausted their quota
        // Form will be closed if:
        // 1. Manual setting registration_closed = true, OR
        // 2. All available tickets have exhausted their quota (no tickets with remaining quota)
        $allTicketsExhausted = $allAvailableTickets->count() > 0 && $availableTickets->isEmpty();

        return view('home', [
            'totalPaidParticipants' => $totalPaidParticipants,
            'quotaReached' => $registrationClosed || $allTicketsExhausted,
            'availableTickets' => $availableTickets,
        ]);
    }

    public function __invoke(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->index();
        }

        $request->validate([
            'registrants' => ['required', 'array', 'min:1'],
            'registrants.*.nik' => ['required', 'string', 'size:16', 'distinct', 'unique:registrations,nik'],
            'registrants.*.full_name' => ['required', 'string', 'max:255'],
            'registrants.*.whatsapp_number' => ['required', 'string', 'max:20', 'distinct', 'unique:registrations,whatsapp_number'],
            'registrants.*.email' => ['required', 'email', 'distinct', 'unique:registrations,email'],
            'registrants.*.address' => ['required', 'string'],
            'registrants.*.date_of_birth' => ['required', 'date'],
            'registrants.*.city' => ['required', 'string', 'max:255'],
            'registrants.*.jersey_size' => ['nullable', 'string'],
            'registrants.*.blood_type' => ['nullable', 'string', 'in:A,B,AB,O'],
            'registrants.*.emergency_contact_number' => ['required', 'string', 'max:20'],
            'registrants.*.medical_conditions' => ['nullable', 'string'],
        ], [
            'registrants.*.nik.unique' => 'NIK sudah terdaftar.',
            'registrants.*.nik.distinct' => 'NIK tidak boleh sama dengan pendaftar lain.',
            'registrants.*.whatsapp_number.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'registrants.*.whatsapp_number.distinct' => 'Nomor WhatsApp tidak boleh sama dengan pendaftar lain.',
            'registrants.*.email.unique' => 'Email sudah terdaftar.',
            'registrants.*.email.distinct' => 'Email tidak boleh sama dengan pendaftar lain.',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->registrants as $registrantData) {
                Registration::create(array_merge($registrantData, [
                    'jersey_size' => self::DEFAULT_JERSEY_SIZE,
                ]));
            }

            DB::commit();

            $count = count($request->registrants);
            $message = $count > 1
                ? "Berhasil mendaftarkan {$count} peserta!"
                : "Berhasil mendaftarkan 1 peserta!";

            return redirect()->route('home')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    public function store(Request $request)
    {
        if (Setting::getValue('registration_closed', false)) {
        return back()->withErrors(['error' => 'Mohon maaf, pendaftaran Night Run 2025 sudah ditutup.']);
        }

        Log::info('Memulai proses pendaftaran', ['request' => $request->all()]);

        // First validate ticket_id to get ticket info
        $ticketIdValidated = $request->validate([
            'ticket_id' => ['required', 'exists:tickets,id'],
        ]);

        $ticket = Ticket::available()->find($ticketIdValidated['ticket_id']);

        if (! $ticket) {
            return back()->withInput()->withErrors(['ticket_id' => 'Pilihan tiket tidak tersedia saat ini.']);
        }

        // Determine max participants based on ticket type
        $maxParticipants = $ticket->participant_count !== null
            ? $ticket->participant_count  // Bundle ticket: use participant_count
            : 10;  // Regular ticket: allow up to 10 participants

        // Now validate registrations with dynamic max
        $validatedData = $request->validate([
            'registrations' => ['required', 'array', 'min:1', "max:{$maxParticipants}"],
            'registrations.*.nik' => ['required', 'string', 'size:16', 'distinct', 'unique:registrations,nik'],
            'registrations.*.full_name' => ['required', 'string', 'max:255'],
            'registrations.*.whatsapp_number' => ['required', 'string', 'max:20', 'distinct', 'unique:registrations,whatsapp_number'],
            'registrations.*.email' => ['required', 'email', 'distinct', 'unique:registrations,email'],
            'registrations.*.address' => ['required', 'string'],
            'registrations.*.date_of_birth' => ['required', 'date'],
            'registrations.*.city' => ['required', 'string', 'max:255'],
            'registrations.*.gender' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'registrations.*.jersey_size' => ['nullable', 'string'],
            'registrations.*.blood_type' => ['nullable', 'string', 'in:A,B,AB,O'],
            'registrations.*.emergency_contact_number' => ['required', 'string', 'max:20'],
            'registrations.*.medical_conditions' => ['nullable', 'string'],
            'terms' => 'required|accepted',
            'data_confirmation' => 'required|accepted',
        ], [
            'registrations.max' => "Maksimal {$maxParticipants} peserta untuk tiket ini.",
            'registrations.*.nik.unique' => 'NIK sudah terdaftar.',
            'registrations.*.nik.distinct' => 'NIK tidak boleh sama dengan pendaftar lain.',
            'registrations.*.whatsapp_number.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'registrations.*.whatsapp_number.distinct' => 'Nomor WhatsApp tidak boleh sama dengan pendaftar lain.',
            'registrations.*.email.unique' => 'Email sudah terdaftar.',
            'registrations.*.email.distinct' => 'Email tidak boleh sama dengan pendaftar lain.',
        ]);

        // Merge ticket_id into validated data
        $validatedData['ticket_id'] = $ticketIdValidated['ticket_id'];

        Log::info('Validasi berhasil', ['validated' => $validatedData]);
        $totalParticipants = count($validatedData['registrations']);

        // Validate participant count for bundle tickets
        if ($ticket->participant_count !== null) {
            if ($totalParticipants != $ticket->participant_count) {
                return back()->withInput()->withErrors([
                    'ticket_id' => "Paket {$ticket->name} harus untuk {$ticket->participant_count} peserta. Jumlah peserta saat ini: {$totalParticipants}."
                ]);
            }
        }

        // Check if ticket has available quota
        if (!$ticket->hasAvailableQuota($totalParticipants)) {
            $remaining = $ticket->getRemainingQuota();
            return back()->withInput()->withErrors([
                'ticket_id' => "Maaf, kuota tiket ini sudah habis. Sisa kuota: {$remaining} peserta."
            ]);
        }

        try {
            DB::beginTransaction();

            // For bundle tickets, use fixed price. For regular tickets, multiply by participant count
            $totalAmount = $ticket->participant_count !== null
                ? $ticket->price
                : $ticket->price * $totalParticipants;

            // For free tickets (price = 0), automatically set status to 'paid'
            $status = $totalAmount == 0 ? 'paid' : 'pending';
            $paidAt = $totalAmount == 0 ? now() : null;

            $checkout = Checkout::create([
                'order_number' => Checkout::generateOrderNumber(),
                'ticket_id' => $ticket->id,
                'total_amount' => $totalAmount,
                'total_participants' => $totalParticipants,
                'status' => $status,
                'payment_deadline' => $totalAmount == 0 ? null : now()->addHours(24),
                'paid_at' => $paidAt,
            ]);

            // Create participants
            foreach ($validatedData['registrations'] as &$participant) {
                $participant['jersey_size'] = self::DEFAULT_JERSEY_SIZE;
            }
            unset($participant);

            foreach ($validatedData['registrations'] as $participant) {
                $participant['checkout_id'] = $checkout->id;
                $checkoutParticipant = \App\Models\CheckoutParticipant::create($participant);
                Log::info('Peserta berhasil dibuat', ['checkout_participant' => $checkoutParticipant]);
            }

            DB::commit();

            // Reload checkout with ticket relationship
            $checkout->load('ticket');

            Log::info('Checkout berhasil dibuat', ['checkout' => $checkout]);
            Log::info('Transaksi commit, redirect ke checkout', ['unique_id' => $checkout->unique_id]);

            // --- Kirim Email via Queue ke semua peserta ---
            try {
                $url = route('checkout.public', $checkout->unique_id);
                $ticketName = $checkout->ticket ? $checkout->ticket->name : null;
                $paymentMessage = $checkout->total_amount == 0
                    ? "Pendaftaran Freepass Anda telah terverifikasi. Tidak diperlukan pembayaran."
                    : "Cek detail & upload bukti pembayaran di: {$url}";
                $message = "Terima kasih sudah mendaftar Night Run 2025!\n" .
                    "Order: {$checkout->order_number}\n" .
                    "Tiket: " . ($ticketName ? $ticketName : 'N/A') . "\n" .
                    "Total: Rp " . number_format($checkout->total_amount, 0, ',', '.') . "\n" .
                    "Status: {$checkout->status}\n" .
                    $paymentMessage;
                foreach ($validatedData['registrations'] as $participant) {
                    $email = $participant['email'];
                    dispatch(new SendEmailNotification(
                        $email,
                        $message,
                        $url,
                        $checkout->order_number,
                        $checkout->total_amount,
                        $checkout->status,
                        $ticketName
                    ));
                }

                // If status is already 'paid' (Freepass), send payment success email
                if ($checkout->status === 'paid') {
                    foreach ($validatedData['registrations'] as $participant) {
                        $email = $participant['email'];
                        \App\Jobs\SendPaymentSuccessEmail::dispatch(
                            $email,
                            $url,
                            $checkout->order_number,
                            $checkout->total_amount,
                            $checkout->paid_at ? $checkout->paid_at->format('d F Y H:i') : now()->format('d F Y H:i'),
                            $ticketName
                        );
                    }
                }
            } catch (\Exception $e) {
                Log::error('Gagal dispatch Email job: ' . $e->getMessage());
            }
            // --- END Kirim Email via Queue ke semua peserta ---

            $successMessage = $checkout->total_amount == 0
                ? 'Pendaftaran Freepass berhasil! Pendaftaran Anda telah terverifikasi.'
                : 'Pendaftaran berhasil! Silakan lakukan pembayaran.';

            return redirect()->route('checkout.public', $checkout->unique_id)
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat pendaftaran', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}
