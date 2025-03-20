<?php

namespace App\Notifications;

use App\Models\Tontine;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RappelCotisationNotification extends Notification
{
    use Queueable;

    public $participant;
    public $tontine;
    public $type;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct($participant, Tontine $tontine, $type)
    {
        $this->participant = $participant;
        $this->tontine = $tontine;
        $this->type = $type;
    }

    /**
     * Détermine les canaux de notification.
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Envoie la notification dans la base de données.
     */
    public function toDatabase($notifiable)
    {
        // Vérifier la cotisation
        $cotisation = $this->participant->cotisations()->where('id_tontine', $this->tontine->id)->first();
        
        // Créer le message
        $message = '';
        if ($cotisation && !$cotisation->seanceEnRetard()) {
            $message = 'Votre cotisation pour la tontine ' . $this->tontine->libelle . ' a été confirmée.';
        } else {
            $message = 'Rappel : Vous avez une cotisation en retard pour la tontine ' . $this->tontine->libelle;
        }

        // Retourner le message dans les données de la notification
        return [
            'message' => $message,  // Le message doit être correctement assigné
            'tontine_id' => $this->tontine->id,
        ];
    }

    /**
     * Envoie l'email de notification.
     */
    public function toMail($notifiable)
    {
        $cotisation = $this->participant->cotisations()->where('id_tontine', $this->tontine->id)->first();

        $subject = $cotisation && !$cotisation->seanceEnRetard()
            ? 'Confirmation de votre cotisation pour la tontine ' . $this->tontine->libelle
            : 'Rappel : Cotisation en retard pour la tontine ' . $this->tontine->libelle;

        return (new MailMessage)
                ->subject($subject)
                ->line($cotisation && !$cotisation->seanceEnRetard()
                    ? 'Votre cotisation pour la tontine ' . $this->tontine->libelle . ' a été confirmée.'
                    : 'Vous avez une cotisation en retard pour la tontine ' . $this->tontine->libelle)
                ->action('Voir les détails', url('/tontines/' . $this->tontine->id));
    }
}