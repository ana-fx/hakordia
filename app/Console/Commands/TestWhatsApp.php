<?php

namespace App\Console\Commands;

use App\Jobs\SendWhatsappNotification;
use Illuminate\Console\Command;

class TestWhatsApp extends Command
{
    protected $signature = 'whatsapp:test {number} {message?}';
    protected $description = 'Test WhatsApp notification using Fonnte';

    public function handle()
    {
        $number = $this->argument('number');
        $message = $this->argument('message') ?? 'Ini adalah pesan test dari sistem Pandalungan Night Run 2025';

        $this->info("Mencoba mengirim pesan ke: {$number}");

        try {
            SendWhatsappNotification::dispatch($number, $message);
            $this->info('Pesan berhasil dikirim ke queue');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
