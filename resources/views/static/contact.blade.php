@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center">
        <!-- Illustration SVG à gauche -->
        <div class="col-md-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="200" height="200" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 12l-10 6-10-6V6l10 6 10-6v6z"></path>
            </svg>
        </div>

        <!-- Texte à droite -->
        <div class="col-md-6">
            <h2 class="mb-4">Contactez-nous</h2>
            <p class="mb-5">Pour toute question ou remarque, vous pouvez nous contacter à :</p>
            <p class="mb-2"><strong>Email :</strong> support@tontine.com</p>
            <p><strong>Téléphone :</strong> 775710440</p>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container {
        padding: 3rem 2rem;
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
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            margin-bottom: 2rem;
        }
    }
</style>
@endsection