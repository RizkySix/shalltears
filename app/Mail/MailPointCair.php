<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class MailPointCair extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $mailData = [];
    public $tries = 3;//menentukan berapa kali mail akan coba dikirim jika terjadi kegagalan
    public $backoff = 1;//menentukan berapa lama waktu delay yang dibutuhkan untuk mengirin kembali mail saat gagal

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        $this->mailData = $text;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('shalltears666@gmail.com', 'Shalltears Clothing Store'),
              subject: $this->mailData['subject'],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'custom_emails.point_cair',
            with: [
                'text' => $this->mailData
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
