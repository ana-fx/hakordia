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

            $checkout->load(['participants', 'ticket']);
        } else {
            $checkout = Checkout::with(['participants', 'ticket'])->find(session('checkout_id'));
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

        if (! in_array($checkout->status, ['pending', 'waiting'])) {
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
                'status' => 'waiting',
                'paid_at' => null,
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
        $checkout = \App\Models\Checkout::with(['participants', 'ticket'])->where('unique_id', $unique_id)->firstOrFail();
        $registrants = $checkout->participants;

        // Generate QR Code if status is paid or verified
        $qrCode = null;

        // Debug: Check status value
        \Illuminate\Support\Facades\Log::info('Checking checkout status for QR code', [
            'status' => $checkout->status,
            'status_type' => gettype($checkout->status),
            'status_length' => strlen($checkout->status),
            'is_paid' => $checkout->status === 'paid',
            'is_verified' => $checkout->status === 'verified',
            'in_array_result' => in_array($checkout->status, ['paid', 'verified'], true)
        ]);

        if (in_array($checkout->status, ['paid', 'verified'], true)) {
            try {
                $checkoutUrl = url(route('checkout.public', $checkout->unique_id, false));

                \Illuminate\Support\Facades\Log::info('Generating QR code for checkout', [
                    'unique_id' => $checkout->unique_id,
                    'status' => $checkout->status,
                    'url' => $checkoutUrl
                ]);

                // Try PNG first (requires Imagick), fallback to SVG if fails
                try {
                    $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                        ->size(200)
                        ->margin(1)
                        ->generate($checkoutUrl);

                    if (!empty($qrCodeImage)) {
                        $qrCode = 'data:image/png;base64,' . base64_encode($qrCodeImage);
                        \Illuminate\Support\Facades\Log::info('QR code generated successfully (PNG)', [
                            'qr_code_length' => strlen($qrCode),
                            'image_length' => strlen($qrCodeImage)
                        ]);
                    } else {
                        throw new \Exception('PNG QR code is empty');
                    }
                } catch (\Throwable $pngError) {
                    // Fallback to SVG if PNG fails (e.g., Imagick not available)
                    \Illuminate\Support\Facades\Log::warning('PNG QR code generation failed, trying SVG', [
                        'error' => $pngError->getMessage()
                    ]);

                    try {
                        $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                            ->size(200)
                            ->margin(1)
                            ->generate($checkoutUrl);

                        if (!empty($qrCodeSvg)) {
                            $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
                            \Illuminate\Support\Facades\Log::info('QR code generated successfully (SVG fallback)', [
                                'qr_code_length' => strlen($qrCode),
                                'svg_length' => strlen($qrCodeSvg)
                            ]);
                        } else {
                            throw new \Exception('SVG QR code is empty');
                        }
                    } catch (\Throwable $svgError) {
                        \Illuminate\Support\Facades\Log::error('Both PNG and SVG QR code generation failed', [
                            'png_error' => $pngError->getMessage(),
                            'svg_error' => $svgError->getMessage()
                        ]);
                        $qrCode = null;
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Failed to generate QR code', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                $qrCode = null;
            }
        } else {
            \Illuminate\Support\Facades\Log::info('QR code not generated - status not paid/verified', [
                'status' => $checkout->status
            ]);
        }

        // Ensure qrCode is always set (even if null)
        if (!isset($qrCode)) {
            $qrCode = null;
            \Illuminate\Support\Facades\Log::warning('QR code variable was not set, setting to null');
        }

        \Illuminate\Support\Facades\Log::info('Returning checkout view', [
            'unique_id' => $checkout->unique_id,
            'status' => $checkout->status,
            'qrCode_set' => isset($qrCode),
            'qrCode_value' => $qrCode ? 'has_value' : 'null'
        ]);

        // Explicitly pass all variables to view
        $viewData = [
            'checkout' => $checkout,
            'registrants' => $registrants,
            'qrCode' => $qrCode ?? null
        ];

        \Illuminate\Support\Facades\Log::info('View data prepared', [
            'has_checkout' => isset($viewData['checkout']),
            'has_registrants' => isset($viewData['registrants']),
            'has_qrCode' => isset($viewData['qrCode']),
            'qrCode_value' => $viewData['qrCode'] ? 'has_value' : 'null'
        ]);

        return view('checkout', $viewData);
    }

    public function uploadPaymentProofPublic(Request $request, $unique_id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);
        $checkout = \App\Models\Checkout::where('unique_id', $unique_id)->firstOrFail();
        if (! in_array($checkout->status, ['pending', 'waiting'])) {
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
