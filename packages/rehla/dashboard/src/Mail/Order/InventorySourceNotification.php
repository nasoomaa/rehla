<?php

namespace Rehla\Dashboard\Mail\Order;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Rehla\Dashboard\Mail\Mailable;

class InventorySourceNotification extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(public Shipment $shipment) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $inventory = $this->shipment->inventory_source;

        return new Envelope(
            to: [
                new Address(
                    $inventory->contact_email,
                    $inventory->contact_name
                ),
            ],
            subject: trans('dashboard::app.emails.orders.inventory-source.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.orders.inventory-source',
        );
    }
}
