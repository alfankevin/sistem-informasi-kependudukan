<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendStatusSuratMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $subject, $keterangan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $subject, $keterangan)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->keterangan = $keterangan;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
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
            view: 'main.page.pengajuan_surat.partials.email_pengajuan_surat',
            with: [
                'trackingToken' => $this->data['tracking_token'],
                'status' => $this->data['status'],
                'keterangan' => $this->keterangan,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromPath(public_path('/assets/files/form_pengajuan/' . $this->data['pdf_path']))
        ];
    }
}
