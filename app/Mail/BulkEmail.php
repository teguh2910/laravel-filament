<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $subject;
    public $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct($details, $subject, $attachment)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->attachment = $attachment;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bulkEmail',
            with: ['details' => $this->details]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        if ($this->attachment) {
            $attachments[] = Attachment::fromPath($this->attachment);
        }
        return $attachments;
    }
}
