<?php

namespace App\Mail;

use App\Models\Receipt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $receipt;

    public function __construct(Receipt $receipt)
    {
        $this->receipt = $receipt;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice for Shipment ' . $this->receipt->shipment->tracking_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.receipt-notification',
        );
    }

    public function attachments(): array
    {
        // Generate PDF in-memory
        $pdf = Pdf::loadView('admin.receipt.show', [
            'receipt' => $this->receipt,
            'isAdmin' => false
        ]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'invoice-' . $this->receipt->receipt_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
