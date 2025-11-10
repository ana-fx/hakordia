<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        // Get registrants data from session
        $registrants = session('registrants', []);

        // Redirect back to form if no registrants
        if (empty($registrants)) {
            return redirect()->route('home')->with('error', 'Silakan isi form pendaftaran terlebih dahulu.');
        }

        // Create checkout record if not exists
        if (!session('checkout_id')) {
            $checkout = Checkout::create([
                'order_number' => Checkout::generateOrderNumber(),
                'total_amount' => count($registrants) * 150000,
                'total_participants' => count($registrants),
                'status' => 'pending',
                'payment_deadline' => Carbon::now()->addHours(24),
            ]);

            // Create participants records
            foreach ($registrants as $registrant) {
                $checkout->participants()->create($registrant);
            }

            session(['checkout_id' => $checkout->id]);
        } else {
            $checkout = Checkout::with('participants')->find(session('checkout_id'));
        }

        return view('checkout', [
            'checkout' => $checkout,
            'registrants' => $registrants
        ]);
    }

    public function uploadPaymentProof(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048', // max 2MB
        ]);

        $checkout = Checkout::findOrFail(session('checkout_id'));

        if ($checkout->status !== 'pending') {
            return back()->with('error', 'Status pembayaran tidak valid untuk upload bukti pembayaran.');
        }

        if ($request->hasFile('payment_proof')) {
            // Delete old file if exists
            if ($checkout->payment_proof) {
                Storage::disk('public')->delete($checkout->payment_proof);
            }

            // Store new file
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $checkout->update([
                'payment_proof' => $path,
                'status' => 'paid',
                'paid_at' => Carbon::now(),
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diupload. Tim kami akan memverifikasi pembayaran Anda.');
        }

        return back()->with('error', 'Terjadi kesalahan saat mengupload file.');
    }

    public function showPaymentStatus($orderNumber)
    {
        $checkout = Checkout::where('order_number', $orderNumber)->firstOrFail();

        return view('payment-status', [
            'checkout' => $checkout
        ]);
    }

    public function showPublic($unique_id)
    {
        $checkout = \App\Models\Checkout::with('participants')->where('unique_id', $unique_id)->firstOrFail();
        $registrants = $checkout->participants;
        return view('checkout', [
            'checkout' => $checkout,
            'registrants' => $registrants
        ]);
    }

    public function uploadPaymentProofPublic(Request $request, $unique_id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);
        $checkout = \App\Models\Checkout::where('unique_id', $unique_id)->firstOrFail();
        if ($checkout->status !== 'pending') {
            return back()->with('error', 'Status pembayaran tidak valid untuk upload bukti pembayaran.');
        }
        if ($request->hasFile('payment_proof')) {
            if ($checkout->payment_proof) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($checkout->payment_proof);
            }
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            $checkout->update([
                'payment_proof' => $path,
                'status' => 'waiting',
                'paid_at' => null,
            ]);
            return back()->with('success', 'Bukti pembayaran berhasil diupload. Tim kami akan memverifikasi pembayaran Anda.');
        }
        return back()->with('error', 'Terjadi kesalahan saat mengupload file.');
    }
}
