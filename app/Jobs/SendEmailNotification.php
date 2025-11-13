<?php

namespace App\Jobs;

use App\Mail\RegistrationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Jumlah maksimal retry
    public $backoff = [60, 180, 360]; // Delay antara retry (dalam detik)

    protected $to;
    protected $message;
    protected $checkoutUrl;
    protected $orderNumber;
    protected $totalAmount;
    protected $status;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $message, $checkoutUrl, $orderNumber, $totalAmount, $status)
    {
        $this->to = $to;
        $this->message = $message;
        $this->checkoutUrl = $checkoutUrl;
        $this->orderNumber = $orderNumber;
        $this->totalAmount = $totalAmount;
        $this->status = $status;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Mencoba mengirim email ke: ' . $this->to);

            // Kirim email menggunakan Mail facade
            Mail::to($this->to)->send(
                new RegistrationNotification(
                    $this->message,
                    $this->checkoutUrl,
                    $this->orderNumber,
                    $this->totalAmount,
                    $this->status
                )
            );

            Log::info('Email notification sent successfully to: ' . $this->to);
        } catch (\Exception $e) {
            Log::error('Gagal kirim email via Queue: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Email notification failed after all retries: ' . $exception->getMessage());
    }
}

