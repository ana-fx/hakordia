<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use App\Models\Checkout;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use App\Jobs\SendWhatsappNotification;

class RegistrationController extends Controller
{
    public function index()
    {
        // Check total paid participants
        $totalPaidParticipants = \App\Models\CheckoutParticipant::whereHas('checkout', function($query) {
            $query->where('status', 'paid');
        })->count();

        return view('home', [
            'totalPaidParticipants' => $totalPaidParticipants,
            'quotaReached' => true
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
            'registrants.*.jersey_size' => ['required', 'string', 'in:XS,S,M,L,XL,XXL,XXXL'],
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
                Registration::create($registrantData);
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
        // Registration is closed
        return back()->withErrors(['error' => 'Mohon maaf, pendaftaran Night Run 2025 sudah ditutup.']);

        Log::info('Memulai proses pendaftaran', ['request' => $request->all()]);
        $validatedData = $request->validate([
            'registrations' => ['required', 'array', 'min:1', 'max:5'],
            'registrations.*.nik' => ['required', 'string', 'size:16', 'distinct', 'unique:registrations,nik'],
            'registrations.*.full_name' => ['required', 'string', 'max:255'],
            'registrations.*.whatsapp_number' => ['required', 'string', 'max:20', 'distinct', 'unique:registrations,whatsapp_number'],
            'registrations.*.email' => ['required', 'email', 'distinct', 'unique:registrations,email'],
            'registrations.*.address' => ['required', 'string'],
            'registrations.*.date_of_birth' => ['required', 'date'],
            'registrations.*.city' => ['required', 'string', 'max:255'],
            'registrations.*.jersey_size' => ['nullable', 'string', 'in:XS,S,M,L,XL,XXL,All Size'],
            'registrations.*.blood_type' => ['nullable', 'string', 'in:A,B,AB,O'],
            'registrations.*.emergency_contact_number' => ['required', 'string', 'max:20'],
            'registrations.*.medical_conditions' => ['nullable', 'string'],
            'terms' => 'required|accepted',
            'data_confirmation' => 'required|accepted',
        ], [
            'registrations.*.nik.unique' => 'NIK sudah terdaftar.',
            'registrations.*.nik.distinct' => 'NIK tidak boleh sama dengan pendaftar lain.',
            'registrations.*.whatsapp_number.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'registrations.*.whatsapp_number.distinct' => 'Nomor WhatsApp tidak boleh sama dengan pendaftar lain.',
            'registrations.*.email.unique' => 'Email sudah terdaftar.',
            'registrations.*.email.distinct' => 'Email tidak boleh sama dengan pendaftar lain.',
        ]);
        Log::info('Validasi berhasil', ['validated' => $validatedData]);
        try {
            DB::beginTransaction();
            $totalParticipants = count($validatedData['registrations']);
            $totalAmount = 150000 * $totalParticipants;

            $checkout = \App\Models\Checkout::create([
                'order_number' => \App\Models\Checkout::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'total_participants' => $totalParticipants,
                'status' => 'pending',
                'payment_deadline' => now()->addHours(24),
            ]);

            // Create participants
            foreach ($validatedData['registrations'] as $participant) {
                // Set jersey_size to "All Size" if empty
                if (empty($participant['jersey_size'])) {
                    $participant['jersey_size'] = 'All Size';
                }
                $participant['checkout_id'] = $checkout->id;
                $checkoutParticipant = \App\Models\CheckoutParticipant::create($participant);
                Log::info('Peserta berhasil dibuat', ['checkout_participant' => $checkoutParticipant]);
            }

            DB::commit();
            Log::info('Checkout berhasil dibuat', ['checkout' => $checkout]);
            Log::info('Transaksi commit, redirect ke checkout', ['unique_id' => $checkout->unique_id]);

            // --- Kirim WhatsApp via Queue ke semua peserta ---
            try {
                $url = route('checkout.public', $checkout->unique_id);
                $message = "Terima kasih sudah mendaftar Night Run 2025!\n" .
                    "Order: {$checkout->order_number}\n" .
                    "Total: Rp " . number_format($checkout->total_amount, 0, ',', '.') . "\n" .
                    "Status: {$checkout->status}\n" .
                    "Cek detail & upload bukti pembayaran di: {$url}";
                foreach ($validatedData['registrations'] as $participant) {
                    $wa = $participant['whatsapp_number'];
                    if (strpos($wa, '+') !== 0) {
                        $wa = '+62' . ltrim($wa, '0');
                    }
                    $wa = 'whatsapp:' . $wa;
                    dispatch(new SendWhatsappNotification($wa, $message));
                }
            } catch (\Exception $e) {
                Log::error('Gagal dispatch WhatsApp job: ' . $e->getMessage());
            }
            // --- END Kirim WhatsApp via Queue ke semua peserta ---

            return redirect()->route('checkout.public', $checkout->unique_id)
                ->with('success', 'Pendaftaran berhasil! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat pendaftaran', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}
