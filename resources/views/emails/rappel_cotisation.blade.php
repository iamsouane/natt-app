<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if ($type === 'rappel')
            Rappel de cotisation
        @elseif ($type === 'termine')
            Tontine terminée
        @else
            Confirmation de cotisation
        @endif
    </title>
</head>
<body>
    <p>Bonjour {{ $participant->name }},</p>

    @if ($type === 'rappel')
        <p>Ceci est un rappel pour votre cotisation à la tontine <strong>{{ $tontine->libelle }}</strong>.</p>
        <p>Votre cotisation prévue pour aujourd'hui n'a pas encore été effectuée.</p>
        <p>Veuillez effectuer votre paiement dès que possible.</p>

    @elseif ($type === 'terminee')
        <p>La tontine <strong>{{ $tontine->libelle }}</strong> est désormais terminée.</p>
        <p>Merci pour votre participation et votre régularité tout au long des séances.</p>
        <p>Nous espérons vous retrouver pour une prochaine tontine.</p>

    @else
        <p>Nous avons bien reçu votre cotisation pour la tontine <strong>{{ $tontine->libelle }}</strong>.</p>
        @if ($tontine->date_prochaine_cotisation)
            <p>Votre prochaine cotisation est prévue pour le <strong>{{ $tontine->date_prochaine_cotisation->format('d/m/Y') }}</strong>.</p>
        @else
            <p>Vous avez complété toutes vos cotisations. Félicitations !</p>
        @endif
    @endif

    <p>Merci,</p>
    <p>L'équipe de gestion des tontines</p>
</body>
</html>