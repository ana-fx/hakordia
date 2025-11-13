<?php

namespace App\Http\Controllers;

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
}

