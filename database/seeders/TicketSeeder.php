<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiers = [
            [
                'name' => 'Presale 1',
                'price' => 140000,
                'participant_count' => null,
                'start_date' => '2025-11-09',
                'end_date' => '2025-11-15',
                'quota' => 200,
                'notes' => 'Kuota terbatas 200 peserta',
            ],
            [
                'name' => 'Presale 2',
                'price' => 145000,
                'participant_count' => null,
                'start_date' => '2025-11-16',
                'end_date' => '2025-11-25',
                'quota' => 300,
                'notes' => 'Kuota terbatas 300 peserta',
            ],
            [
                'name' => 'Normal Price',
                'price' => 150000,
                'participant_count' => null,
                'start_date' => '2025-11-26',
                'end_date' => '2025-12-05',
                'quota' => null,
                'notes' => 'Selama persediaan nomor masih tersedia',
            ],
            [
                'name' => 'Couple Bundle',
                'price' => 280000,
                'participant_count' => 2,
                'start_date' => '2025-11-09',
                'end_date' => '2025-12-05',
                'quota' => null,
                'notes' => 'Paket untuk 2 peserta',
            ],
            [
                'name' => 'Squad Bundle',
                'price' => 725000,
                'participant_count' => 5,
                'start_date' => '2025-11-09',
                'end_date' => '2025-12-05',
                'quota' => null,
                'notes' => 'Paket untuk 5 peserta',
            ],
            [
                'name' => 'Community Bundle',
                'price' => 1350000,
                'participant_count' => 10,
                'start_date' => '2025-11-09',
                'end_date' => '2025-12-05',
                'quota' => null,
                'notes' => 'Paket untuk 10 peserta',
            ],
        ];

        foreach ($tiers as $tier) {
            Ticket::updateOrCreate(
                ['name' => $tier['name']],
                $tier
            );
        }
    }
}


