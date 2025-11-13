<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $emailMessage;
    public $checkoutUrl;
    public $orderNumber;
    public $totalAmount;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct($message, $checkoutUrl, $orderNumber, $totalAmount, $status)
    {
        $this->emailMessage = $message;
        $this->checkoutUrl = $checkoutUrl;
        $this->orderNumber = $orderNumber;
        $this->totalAmount = $totalAmount;
        $this->status = $status;
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
            subject: 'Terima Kasih - Pendaftaran Hakordia Fun Night Run',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-notification',
            with: [
                'emailMessage' => $this->emailMessage,
                'checkoutUrl' => $this->checkoutUrl,
                'orderNumber' => $this->orderNumber,
                'totalAmount' => $this->totalAmount,
                'status' => $this->status,
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

