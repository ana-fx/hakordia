<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\CheckoutParticipant;

class ParticipantsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Export semua data, exclude soft-deleted checkouts, dan exclude tiket gratis (price = 0)
        $checkoutParticipants = CheckoutParticipant::with([
            'checkout.ticket',
            'checkout.redeemedBy'
        ])
        ->whereHas('checkout', function($query) {
            $query->whereNull('deleted_at')
                  ->whereHas('ticket', function($ticketQuery) {
                      // Exclude tiket dengan harga 0 (Freepass)
                      $ticketQuery->where('price', '>', 0);
                  });
        })
        ->get()
        ->filter(function($item) {
            // Pastikan checkout ada (seharusnya selalu ada karena whereHas, tapi untuk keamanan)
            return $item->checkout !== null;
        })
        ->map(function($item) {
            $checkout = $item->checkout;
            $ticket = $checkout->ticket ?? null;
            $redeemedBy = $checkout->redeemedBy ?? null;

            return [
                // Data Peserta (CheckoutParticipant)
                'NIK' => $item->nik,
                'Nama Lengkap' => $item->full_name,
                'Jenis Kelamin' => $item->gender ?? '',
                'Email' => $item->email,
                'WhatsApp' => $item->whatsapp_number,
                'Alamat Lengkap' => $item->address,
                'Kota' => $item->city,
                'Tanggal Lahir' => $item->date_of_birth ? $item->date_of_birth->format('Y-m-d') : '',
                'Golongan Darah' => $item->blood_type ?? '',
                'Ukuran Jersey' => $item->jersey_size ?? 'All Size',
                'Nomor Kontak Darurat' => $item->emergency_contact_number,
                'Riwayat Penyakit' => $item->medical_conditions ?? '',

                // Data Checkout
                'Order Number' => $checkout->order_number ?? '',
                'Unique ID' => $checkout->unique_id ?? '',
                'Tahap Ticket' => $ticket ? $ticket->name : '',
                'Harga Ticket' => $ticket ? $ticket->price : '',
                'Total Amount' => $checkout->total_amount ?? '',
                'Total Participants' => $checkout->total_participants ?? '',
                'Status' => $checkout->status ?? '',
                'Status Verifikasi' => $checkout->status_verifikasi ?? '',
                'Payment Proof' => $checkout->payment_proof ? url('storage/' . $checkout->payment_proof) : '',
                'Payment Deadline' => $checkout->payment_deadline ? $checkout->payment_deadline->format('Y-m-d H:i:s') : '',
                'Paid At' => $checkout->paid_at ? $checkout->paid_at->format('Y-m-d H:i:s') : '',
                'Redeemed At' => $checkout->redeemed_at ? $checkout->redeemed_at->format('Y-m-d H:i:s') : '',
                'Redeemed By' => $redeemedBy ? $redeemedBy->name : '',
                'Created At' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
                'Updated At' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : '',
            ];
        });

        return $checkoutParticipants;
    }

    public function headings(): array
    {
        return [
            // Data Peserta
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Email',
            'WhatsApp',
            'Alamat Lengkap',
            'Kota',
            'Tanggal Lahir',
            'Golongan Darah',
            'Ukuran Jersey',
            'Nomor Kontak Darurat',
            'Riwayat Penyakit',

            // Data Checkout
            'Order Number',
            'Unique ID',
            'Tahap Ticket',
            'Harga Ticket',
            'Total Amount',
            'Total Participants',
            'Status',
            'Status Verifikasi',
            'Payment Proof',
            'Payment Deadline',
            'Paid At',
            'Redeemed At',
            'Redeemed By',
            'Created At',
            'Updated At',
        ];
    }
}
