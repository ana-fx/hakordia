<?php

namespace App\Console\Commands;

use App\Mail\PaymentSuccessNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendTestPaymentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-payment-success 
                            {email : Email tujuan}
                            {--order= : Nomor order (default: auto-generated)}
                            {--amount=150000 : Total amount}
                            {--ticket=Presale 1 : Nama tiket}
                            {--url= : Checkout URL (default: auto-generated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim test email payment success notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $orderNumber = $this->option('order') ?: 'NR' . date('Ymd') . rand(1000, 9999);
        $totalAmount = (int) $this->option('amount');
        $ticketName = $this->option('ticket');
        $checkoutUrl = $this->option('url') ?: url(route('checkout.public', 'test-' . time(), false));
        $paidAt = now()->format('d F Y, H:i');

        $this->info("Mengirim email payment success ke: {$email}");
        $this->info("Order Number: {$orderNumber}");
        $this->info("Total Amount: Rp " . number_format($totalAmount, 0, ',', '.'));
        $this->info("Ticket: {$ticketName}");
        $this->info("Paid At: {$paidAt}");

        try {
            // Kirim email langsung tanpa queue
            Mail::to($email)->send(
                new PaymentSuccessNotification(
                    $checkoutUrl,
                    $orderNumber,
                    $totalAmount,
                    $paidAt,
                    $ticketName
                )
            );

            $this->info("✅ Email berhasil dikirim ke: {$email}");
            Log::info('Test payment success email sent', [
                'email' => $email,
                'order_number' => $orderNumber,
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Gagal mengirim email: " . $e->getMessage());
            Log::error('Test payment success email failed', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return Command::FAILURE;
        }
    }
}
