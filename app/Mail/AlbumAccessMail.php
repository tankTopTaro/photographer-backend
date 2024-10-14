<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlbumAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $albumUrl;
    public $token;

    /**
     * Create a new message instance.
     * 
     * @param string $albumUrl
     * @return void
     */
    public function __construct($albumUrl, $token, public User $user)
    {
        $this->albumUrl = $albumUrl;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     * 
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Album Access URL',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
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
