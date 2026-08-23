<?php

namespace Rehla\Dashboard\Mail\Admin;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Rehla\Dashboard\Mail\Mailable;

class BackupCodesNotification extends Mailable
{
    /**
     * Create a new mailable instance.
     *
     * @param  array  $backupCodes  The plain backup codes (only the hashed copies are stored).
     */
    public function __construct(public Admin $admin, public array $backupCodes = []) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address($this->admin->email),
            ],
            subject: trans('dashboard::app.account.emails.backup-codes.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin::emails.admin.backup-codes',
        );
    }
}
