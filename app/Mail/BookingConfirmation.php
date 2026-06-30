<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
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

        return $this->subject('تأكيد الحجز — ' . config('app.name'))
            ->view('emails.booking-confirmation')
            ->with(['logoEmbedded' => $logoEmbedded]);
    }
}
