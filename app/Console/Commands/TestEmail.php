<?php

namespace App\Console\Commands;

use App\Jobs\SendEmailNotification;
use Illuminate\Console\Command;

class TestEmail extends Command
{
    protected $signature = 'email:test {email} {message?}';
    protected $description = 'Test Email notification';

    public function handle()
    {
        $email = $this->argument('email');
        $message = $this->argument('message') ?? 'Ini adalah pesan test dari sistem Hakordia Fun Night Run';
        $checkoutUrl = route('home');
        $orderNumber = 'TEST-' . time();
        $totalAmount = 100000;
        $status = 'waiting';

        $this->info("Mencoba mengirim email ke: {$email}");

        try {
            SendEmailNotification::dispatch($email, $message, $checkoutUrl, $orderNumber, $totalAmount, $status);
            $this->info('Email berhasil dikirim ke queue');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
