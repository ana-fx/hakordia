<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentSuccessNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $checkoutUrl;
    public $orderNumber;
    public $totalAmount;
    public $paidAt;
    public $ticketName;
    public $qrCode;

    /**
     * Create a new message instance.
     */
    public function __construct($checkoutUrl, $orderNumber, $totalAmount, $paidAt, $ticketName = null)
    {
        $this->checkoutUrl = $checkoutUrl;
        $this->orderNumber = $orderNumber;
        $this->totalAmount = $totalAmount;
        $this->paidAt = $paidAt;
        $this->ticketName = $ticketName;
        
        // Generate QR Code as PNG using Imagick
        $this->qrCode = null; // Initialize as null
        try {
            $qrCodeImage = QrCode::format('png')
                ->size(200)
                ->margin(1)
                ->generate($checkoutUrl);
            
            $this->qrCode = 'data:image/png;base64,' . base64_encode($qrCodeImage);
            
            \Illuminate\Support\Facades\Log::info('QR code generated as PNG for email', [
                'qr_code_length' => strlen($this->qrCode),
                'image_length' => strlen($qrCodeImage)
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to generate PNG QR code for email (Imagick required): ' . $e->getMessage());
            $this->qrCode = null;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address', 'navadigital931@gmail.com'),
                config('mail.from.name', 'Hakordia Fun Night Run')
            ),
            subject: 'Pembayaran Dikonfirmasi - Hakordia Fun Night Run',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-success',
            with: [
                'checkoutUrl' => $this->checkoutUrl,
                'orderNumber' => $this->orderNumber,
                'totalAmount' => $this->totalAmount,
                'paidAt' => $this->paidAt,
                'ticketName' => $this->ticketName ?? null,
                'qrCode' => $this->qrCode ?? null,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

