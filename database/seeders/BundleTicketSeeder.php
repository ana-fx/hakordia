<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class BundleTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bundles = [
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

        foreach ($bundles as $bundle) {
            Ticket::updateOrCreate(
                ['name' => $bundle['name']],
                $bundle
            );
        }
    }
}

