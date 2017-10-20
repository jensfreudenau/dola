<?php

namespace App\Mail;

use App\Competition;
use App\ParticipatorTeam;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnrolReceived extends Mailable
{
    use Queueable, SerializesModels;
    protected $participatorTeam;
    protected $competition;

    /**
     * Create a new message instance.
     *
     * @param $participatorTeam
     * @param $competition
     */
    public function __construct($participatorTeam, $competition)
    {
        $this->participatorTeam = $participatorTeam;
        $this->competition = $competition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $team = $this->participatorTeam;
        $competition = $this->competition;

        return $this->from($this->participatorTeam->email)
            ->to($this->competition->team->address->email)
            ->cc($this->participatorTeam->email)
            ->subject('Meldungen für '.$this->competition->header)
            ->view('emails.registration', compact('team', 'competition'));
    }
}
