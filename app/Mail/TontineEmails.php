<?php

namespace App\Mail;

use App\Models\Tontine;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TontineEmails extends Mailable
{
    use Queueable, SerializesModels;

    public $tontine;

    public function __construct(Tontine $tontine)
    {
        $this->tontine = $tontine;
    }

    public function build()
    {
        return $this->view('emails.tontine')
                    ->with(['tontine' => $this->tontine]);
    }
}