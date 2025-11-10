<?php

namespace App\Console\Commands;

use App\Services\FonnteService;
use Illuminate\Console\Command;

class CheckFonnteStatus extends Command
{
    protected $signature = 'whatsapp:status';
    protected $description = 'Check Fonnte device status';

    public function handle(FonnteService $fonnteService)
    {
        $this->info('Checking Fonnte device status...');

        try {
            $status = $fonnteService->checkNumber(null);

            $this->info('Device Status:');
            $this->table(
                ['Status', 'Message'],
                [[
                    $status['status'] ? 'Connected' : 'Disconnected',
                    $status['message'] ?? 'No message'
                ]]
            );
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
