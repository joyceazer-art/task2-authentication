<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public Product $ingredient;
    public int $currentQuantity;

    public function __construct(Product $ingredient, int $currentQuantity)
    {
        $this->ingredient = $ingredient;
        $this->currentQuantity = $currentQuantity;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Low Stock Alert',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.low-stock-alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}