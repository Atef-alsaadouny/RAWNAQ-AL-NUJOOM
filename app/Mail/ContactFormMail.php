<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build(): static
    {
        $logoPath = public_path('images/logo-email.png');
        if (!file_exists($logoPath)) {
            $logoPath = public_path('images/logo.png');
        }

        $logoEmbedded = '';
        if (file_exists($logoPath)) {
            $cid = 'logo@rawnaq';
            $logoEmbedded = 'cid:' . $cid;
            $this->withSymfonyMessage(function ($message) use ($logoPath, $cid) {
                $file = new File($logoPath);
                $part = new DataPart($file, 'logo.png', 'image/png');
                $part->setContentId($cid);
                $message->addPart($part);
            });
        }

        return $this->subject('رسالة جديدة من ' . ($this->data['name'] ?? 'الموقع'))
            ->to(Config::get('app.contact_email', 'info@rawnaqalnujoom.com'))
            ->view('emails.contact-form')
            ->with(['logoEmbedded' => $logoEmbedded]);
    }
}