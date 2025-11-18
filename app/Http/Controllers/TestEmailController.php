<?php

namespace App\Http\Controllers;

use App\Jobs\SendPaymentSuccessEmail;
use App\Mail\RegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    public function test(Request $request)
    {
        $email = $request->input('email', 'test@example.com');
        $message = $request->input('message', 'Ini adalah pesan test dari sistem Hakordia Fun Night Run');
        $checkoutUrl = route('home');
        $orderNumber = 'TEST-' . time();
        $totalAmount = 100000;
        $status = 'waiting';

        try {
            // Kirim langsung tanpa queue untuk testing cepat
            Mail::to($email)->send(
                new RegistrationNotification(
                    $message,
                    $checkoutUrl,
                    $orderNumber,
                    $totalAmount,
                    $status
                )
            );

            Log::info('Test email sent successfully to: ' . $email);

            return response()->json([
                'success' => true,
                'message' => 'Email berhasil dikirim ke: ' . $email,
                'email' => $email,
            ]);
        } catch (\Exception $e) {
            Log::error('Test email failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test payment success email via queue
     */
    public function testPaymentSuccess(Request $request)
    {
        $email = $request->input('email', 'aanjr38@gmail.com');
        $checkoutUrl = url(route('checkout.public', '06ddb725-62c3-4aed-aed5-8b3a28033286', false));
        $orderNumber = 'NR' . date('Ymd') . rand(1000, 9999);
        $totalAmount = $request->input('amount', 150000);
        $paidAt = now()->format('d F Y, H:i');
        $ticketName = $request->input('ticket', 'Presale 1');

        try {
            // Dispatch ke queue
            SendPaymentSuccessEmail::dispatch(
                $email,
                $checkoutUrl,
                $orderNumber,
                $totalAmount,
                $paidAt,
                $ticketName
            );

            Log::info('Payment success email dispatched to queue', [
                'email' => $email,
                'order_number' => $orderNumber,
                'checkout_url' => $checkoutUrl
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email payment success berhasil ditambahkan ke queue',
                'email' => $email,
                'order_number' => $orderNumber,
                'checkout_url' => $checkoutUrl,
                'note' => 'Pastikan queue worker berjalan: php artisan queue:work'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to dispatch payment success email: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan email ke queue: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

