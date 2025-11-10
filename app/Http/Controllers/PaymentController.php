<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function show($uniqueId)
    {
        $payment = Payment::where('unique_id', $uniqueId)->firstOrFail();
        $registrants = session('registrants', []);

        return view('payment', [
            'payment' => $payment,
            'registrants' => $registrants
        ]);
    }

    public function uploadPaymentProof(Request $request, $uniqueId)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048', // max 2MB
        ]);

        $payment = Payment::where('unique_id', $uniqueId)->firstOrFail();

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Status pembayaran tidak valid untuk upload bukti pembayaran.');
        }

        if ($request->hasFile('payment_proof')) {
            // Delete old file if exists
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            // Store new file
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $payment->update([
                'payment_proof' => $path,
                'status' => 'uploaded',
                'uploaded_at' => Carbon::now(),
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diupload. Tim kami akan memverifikasi pembayaran Anda.');
        }

        return back()->with('error', 'Terjadi kesalahan saat mengupload file.');
    }

    public function showStatus($uniqueId)
    {
        $payment = Payment::where('unique_id', $uniqueId)->firstOrFail();

        return view('payment-status', [
            'payment' => $payment
        ]);
    }

    public function verifyPayment(Request $request, $uniqueId)
    {
        $payment = Payment::where('unique_id', $uniqueId)->firstOrFail();

        $payment->update([
            'status' => 'success',
            'verified_at' => Carbon::now(),
            'verified_by' => auth()->id()
        ]);

        // TODO: Send email notification to participant

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}
