<?php

namespace App\Mail;

use App\Competition;
use App\Announciator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnrolReceived extends Mailable
{
    use Queueable, SerializesModels;
    protected $announciator;
    protected $competition;

    /**
     * Create a new message instance.
     *
     * @param $announciator
     * @param $competition
     */
    public function __construct($announciator, $competition)
    {
        $this->announciator = $announciator;
        $this->competition = $competition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $announciator = $this->announciator;
        $competition = $this->competition;

        return $this->from($this->announciator->email)
            ->to($this->competition->organizer->address->email)
            ->cc($this->announciator->email)
            ->subject('Meldungen für '.$this->competition->header)
            ->view('emails.registration', compact('announciator', 'competition'));
    }
}
