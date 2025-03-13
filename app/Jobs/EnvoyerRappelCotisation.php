<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Tontine;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EnvoyerRappelCotisation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Exécute le job.
     */
    public function handle(): void
    {
        // Récupérer toutes les tontines avec leurs cotisations et les utilisateurs associés
        $tontines = Tontine::with('cotisations.user')->get();
        $now = Carbon::now();

        foreach ($tontines as $tontine) {
            // Grouper les cotisations par utilisateur
            foreach ($tontine->cotisations->groupBy('id_user') as $id_user => $cotisations) {
                $user = $cotisations->first()->user; // Récupérer l'utilisateur
                $nombreCotisationsEffectuees = $cotisations->count(); // Nombre de cotisations effectuées par l'utilisateur
                $resteCotisations = $tontine->nbre_cotisation - $nombreCotisationsEffectuees; // Calculer le nombre de cotisations restantes

                // Vérifier s'il reste des cotisations à effectuer
                if ($resteCotisations > 0) {
                    // Récupérer la date de la dernière cotisation ou la date de création de la tontine
                    $derniereCotisation = $cotisations->sortByDesc('created_at')->first();
                    $dateDerniereCotisation = $derniereCotisation ? $derniereCotisation->created_at : $tontine->created_at;

                    // Déterminer si un rappel doit être envoyé en fonction de la fréquence de la tontine
                    $envoyerRappel = false;
                    if ($tontine->frequence == 'JOURNALIERE' && $dateDerniereCotisation->diffInDays($now) >= 1) {
                        $envoyerRappel = true;
                    } elseif ($tontine->frequence == 'HEBDOMADAIRE' && $dateDerniereCotisation->diffInWeeks($now) >= 1) {
                        $envoyerRappel = true;
                    } elseif ($tontine->frequence == 'MENSUELLE' && $dateDerniereCotisation->diffInMonths($now) >= 1) {
                        $envoyerRappel = true;
                    }

                    // Envoyer le rappel si nécessaire
                    if ($envoyerRappel) {
                        try {
                            // Construire le message du rappel
                            $messageContent = "Bonjour {$user->name}, il vous reste encore {$resteCotisations} cotisation(s) à faire pour la tontine '{$tontine->libelle}'. Merci de cotiser avant la prochaine échéance.";

                            // Envoyer l'e-mail
                            Mail::raw(
                                $messageContent,
                                function ($message) use ($user) {
                                    $message->to($user->email)->subject('📢 Rappel de cotisation');
                                }
                            );

                            // Logguer l'envoi du rappel
                            Log::info("📧 Rappel envoyé à {$user->email} pour la tontine '{$tontine->libelle}'.");

                        } catch (\Exception $e) {
                            // Logguer les erreurs en cas d'échec de l'envoi
                            Log::error("❌ Erreur lors de l'envoi du rappel à {$user->email} : " . $e->getMessage());
                        }
                    }
                }
            }
        }
    }
}