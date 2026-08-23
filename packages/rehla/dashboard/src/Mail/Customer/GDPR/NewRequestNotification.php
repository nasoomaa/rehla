<?php

namespace Rehla\Dashboard\Mail\Customer\GDPR;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Rehla\Dashboard\Mail\Mailable;

class NewRequestNotification extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(public GDPRDataRequest $gdprRequest) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectKey = $this->gdprRequest->type === 'update'
            ? 'dashboard::app.emails.customers.gdpr.new-update-request'
            : 'dashboard::app.emails.customers.gdpr.new-delete-request';

        return new Envelope(
            to: [
                new Address(
                    core()->getAdminEmailDetails()['email'],
                    core()->getAdminEmailDetails()['name']
                ),
            ],
            subject: trans($subjectKey)
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.customers.gdpr.new-request'
        );
    }
}
