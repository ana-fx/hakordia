<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Registration;
use App\Models\CheckoutParticipant;

class ParticipantsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Registrations manual
        $registrations = Registration::all()->map(function($item) {
            return [
                'Nama Lengkap' => $item->full_name,
                'Email' => $item->email,
                'WhatsApp' => $item->whatsapp_number,
                'NIK' => $item->nik,
                'Alamat' => $item->address,
                'Tanggal Lahir' => $item->date_of_birth,
                'Kota' => $item->city,
                'Ukuran Jersey' => $item->jersey_size,
                'Golongan Darah' => $item->blood_type,
                'Kontak Darurat' => $item->emergency_contact_number,
                'Riwayat Penyakit' => $item->medical_conditions,
                'Bukti Pembayaran' => '',
                'Status' => '',
                'Sumber Data' => 'Registrations',
            ];
        });

        // Checkout participants - exclude soft-deleted checkouts
        $checkoutParticipants = CheckoutParticipant::with(['checkout' => function($query) {
            $query->withTrashed();
        }])->get()->filter(function($item) {
            return !$item->checkout->trashed();
        })->map(function($item) {
            $bukti = $item->checkout && $item->checkout->payment_proof ? $item->checkout->payment_proof : '';
            $status = $item->checkout && $item->checkout->status ? $item->checkout->status : '';
            return [
                'Nama Lengkap' => $item->full_name,
                'Email' => $item->email,
                'WhatsApp' => $item->whatsapp_number,
                'NIK' => $item->nik,
                'Alamat' => $item->address,
                'Tanggal Lahir' => $item->date_of_birth,
                'Kota' => $item->city,
                'Ukuran Jersey' => $item->jersey_size,
                'Golongan Darah' => $item->blood_type,
                'Kontak Darurat' => $item->emergency_contact_number,
                'Riwayat Penyakit' => $item->medical_conditions,
                'Bukti Pembayaran' => $bukti,
                'Status' => $status,
                'Sumber Data' => 'Checkout',
            ];
        });

        // Gabungkan
        return $registrations->concat($checkoutParticipants);
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'WhatsApp',
            'NIK',
            'Alamat',
            'Tanggal Lahir',
            'Kota',
            'Ukuran Jersey',
            'Golongan Darah',
            'Kontak Darurat',
            'Riwayat Penyakit',
            'Bukti Pembayaran',
            'Status',
            'Sumber Data',
        ];
    }
}
