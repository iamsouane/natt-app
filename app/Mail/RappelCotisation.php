<?php

namespace App\Mail;

use App\Models\Tontine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RappelCotisation extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $tontine;
    public $type;

    /**
     * Create a new message instance.
     */
    public function __construct($participant, Tontine $tontine, $type)
    {
        $this->participant = $participant;
        $this->tontine = $tontine;
        $this->type = $type;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $sujet = $this->type === 'rappel'
            ? "Rappel : Cotisation pour la tontine {$this->tontine->libelle}"
            : "Confirmation : Cotisation enregistrée pour la tontine {$this->tontine->libelle}";

        return $this->subject($sujet)
            ->view('emails.rappel_cotisation');
    }
}