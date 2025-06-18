<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceApproved extends Mailable
{
     use Queueable, SerializesModels;

    public $transaction;
    public $items;

    public function __construct($transaction, $items)
    {
        $this->transaction = $transaction;
        $this->items = $items;
    }

    public function build()
    {
        $pdf = Pdf::loadView('invoices.invoice', [
            'store_name' => 'Toko Medika Sehat',
            'buyer_name' => $this->transaction->username,
            'address' => $this->transaction->address,
            'phone' => $this->transaction->phone_number,
            'date' => \Carbon\Carbon::parse($this->transaction->created_at)->format('d-m-Y'),
            'payment_method' => $this->transaction->payment_method ?? '-',
            'items' => $this->items,
            'total_price' => $this->transaction->total_price,
        ]);

        return $this->markdown('emails.invoice')
            ->subject('Invoice Pesanan Anda')
            ->attachData($pdf->output(), 'invoice_' . $this->transaction->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
