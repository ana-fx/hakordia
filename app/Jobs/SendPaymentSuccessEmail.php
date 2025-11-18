<?php

namespace App\Jobs;

use App\Mail\PaymentSuccessNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentSuccessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Jumlah maksimal retry
    public $backoff = [60, 180, 360]; // Delay antara retry (dalam detik)

    protected $to;
    protected $checkoutUrl;
    protected $orderNumber;
    protected $totalAmount;
    protected $paidAt;
    protected $ticketName;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $checkoutUrl, $orderNumber, $totalAmount, $paidAt, $ticketName = null)
    {
        $this->to = $to;
        $this->checkoutUrl = $checkoutUrl;
        $this->orderNumber = $orderNumber;
        $this->totalAmount = $totalAmount;
        $this->paidAt = $paidAt;
        $this->ticketName = $ticketName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Mencoba mengirim email payment success ke: ' . $this->to);

            // Kirim email menggunakan Mail facade
            Mail::to($this->to)->send(
                new PaymentSuccessNotification(
                    $this->checkoutUrl,
                    $this->orderNumber,
                    $this->totalAmount,
                    $this->paidAt,
                    $this->ticketName
                )
            );

            Log::info('Payment success email sent successfully to: ' . $this->to);
        } catch (\Exception $e) {
            Log::error('Gagal kirim email payment success via Queue: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Payment success email failed after all retries: ' . $exception->getMessage());
    }
}

