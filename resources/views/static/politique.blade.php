@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center">
        <!-- Illustration SVG à gauche -->
        <div class="col-md-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="200" height="200" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2a10 10 0 1 1 0 20A10 10 0 0 1 12 2zm0 2a8 8 0 1 0 0 16A8 8 0 0 0 12 4zm-1 3v4h2V7h-2zm0 6v4h2v-4h-2z"></path>
            </svg>
        </div>

        <!-- Texte à droite -->
        <div class="col-md-6">
            <h2 class="text-primary mb-4">Politique de confidentialité</h2>
            <p class="lead mb-5">Votre sécurité et votre confidentialité sont des priorités pour nous. Nous nous engageons à protéger vos données personnelles et à ne jamais les partager avec des tiers sans votre consentement explicite.</p>
            <p>En utilisant notre service, vous acceptez les termes de cette politique. Nous recueillons uniquement les informations nécessaires pour améliorer votre expérience et garantir la qualité de nos services.</p>
            <p>Vos données sont stockées de manière sécurisée et sont accessibles uniquement par les personnes autorisées.</p>
            <p>Pour toute question ou inquiétude concernant cette politique, n'hésitez pas à nous contacter à <strong>support@tontine.com</strong>.</p>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container {
        padding: 3rem 2rem;
    }

    h2 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #0077b6;
    }

    .lead {
        font-size: 1.2rem;
        font-weight: 300;
        color: #555;
    }

    .row {
        display: flex;
        justify-content: center;
    }

    .col-md-6 {
        flex: 0 0 50%;
    }

    svg {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        fill: #0077b6;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            margin-bottom: 2rem;
        }
    }
</style>
@endsection