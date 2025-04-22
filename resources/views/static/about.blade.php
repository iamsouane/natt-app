@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">À propos</h2>
    <p class="text-center mb-5">
        Ce projet a été réalisé dans le cadre d’un module noté. Il permet de gérer des tontines avec cotisations, tirages et gestion des rôles.
    </p>

    <div class="row justify-content-center">
        @php
            $membres = [
                ['nom' => 'Membre 1', 'role' => 'Backend Dev', 'image' => 'img/sis.jpg'],
                ['nom' => 'Membre 2', 'role' => 'Frontend Dev', 'image' => 'img/sis.jpg'],
                ['nom' => 'Membre 3', 'role' => 'UI/UX Designer', 'image' => 'img/hrs.jpg'],
                ['nom' => 'Membre 4', 'role' => 'Chef de projet', 'image' => 'img/hrs.jpg'],
                ['nom' => 'Membre 5', 'role' => 'QA Testeur', 'image' => 'img/sis.jpg'],
            ];
        @endphp

        @foreach ($membres as $membre)
        <div class="col-md-4 col-lg-2 mb-4">
            <div class="custom-card text-center p-4">
                <img src="{{ asset($membre['image']) }}" alt="{{ $membre['nom'] }}" class="img-fluid mb-3 rounded">
                <h5 class="card-title">{{ $membre['nom'] }}</h5>
                <p class="card-text">{{ $membre['role'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    .custom-card {
        background: linear-gradient(135deg, #48cae4, #90e0ef);
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 180, 216, 0.4); /* Ombre bleu vif */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: #023e8a;
        cursor: pointer;
    }

    .custom-card:hover {
        transform: scale(1.07);
        box-shadow: 0 16px 32px rgba(0, 180, 216, 0.7); /* Ombre bleu vif sur survol */
    }

    .custom-card img {
        border-radius: 10px;
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }

    .custom-card:hover img {
        transform: scale(1.1); /* Effet de zoom sur l'image */
    }

    .card-title {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .card-text {
        font-size: 1rem;
        color: #03045e;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    @media (max-width: 768px) {
        .custom-card {
            margin-bottom: 20px;
        }
    }
</style>
@endsection