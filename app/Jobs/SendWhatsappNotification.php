<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Jumlah maksimal retry
    public $backoff = [60, 180, 360]; // Delay antara retry (dalam detik)

    protected $to;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $message)
    {
        // Format nomor untuk Fonnte (hapus +, whatsapp:, dan spasi)
        $this->to = preg_replace('/[^0-9]/', '', $to);
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(FonnteService $fonnteService): void
    {
        try {
            // Link admin WhatsApp
            $adminWa = 'https://wa.me/6281515788271';

            // Pesan tambahan admin & peringatan
            $adminMsg = "\n\n*Konfirmasi pembayaran?*\nSilakan hubungi admin: {$adminWa}\n\n*Penting:*\nJangan mengirim pembayaran ke nomor rekening selain yang tertera di halaman resmi kami 0032836836\nAtas Nama: Andi Reza Zulkarnaen";

            // Gabungkan pesan utama dengan pesan admin
            $body = $this->message . $adminMsg;

            Log::info('Mencoba mengirim WhatsApp ke: ' . $this->to);

            // Kirim pesan menggunakan FonnteService
            $result = $fonnteService->sendMessage($this->to, $body);

            if ($result['success']) {
                Log::info('WhatsApp notification sent successfully to: ' . $this->to);
            } else {
                throw new \Exception('Failed to send WhatsApp notification: ' . $result['message']);
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim WhatsApp via Queue: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('WhatsApp notification failed after all retries: ' . $exception->getMessage());
    }
}
