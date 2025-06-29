@extends('layouts.app')

@section('title', 'À propos de NATT-APP')

@section('content')
<div class="container py-5" data-aos="fade-up">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold text-primary mb-3">À propos de NATT-APP</h1>
        <div class="divider mx-auto bg-primary mb-4"></div>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            NATT-APP est une solution innovante de gestion de tontines développée dans le cadre d'un projet académique.
            Notre plateforme simplifie les cotisations, les tirages et la gestion des membres pour une expérience transparente.
        </p>
    </div>

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-card text-center p-4 h-100">
                <div class="icon-circle bg-primary text-white mb-3 mx-auto">
                    <i class="fas fa-shield-alt fa-2x"></i>
                </div>
                <h4 class="font-weight-bold mb-3">Sécurisé</h4>
                <p class="text-muted">Transactions cryptées et données protégées pour une gestion en toute confiance.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-card text-center p-4 h-100">
                <div class="icon-circle bg-success text-white mb-3 mx-auto">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <h4 class="font-weight-bold mb-3">Transparent</h4>
                <p class="text-muted">Suivi en temps réel des cotisations et historique complet des opérations.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-card text-center p-4 h-100">
                <div class="icon-circle bg-warning text-white mb-3 mx-auto">
                    <i class="fas fa-bell fa-2x"></i>
                </div>
                <h4 class="font-weight-bold mb-3">Notifications</h4>
                <p class="text-muted">Alertes pour les échéances de cotisation et résultats des tirages.</p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-primary mb-4">Notre Équipe</h2>
        <div class="divider mx-auto bg-primary mb-4"></div>
        <p class="text-muted mx-auto" style="max-width: 700px;">
            Une équipe passionnée d'étudiants en informatique qui a travaillé ensemble pour créer cette solution innovante.
        </p>
    </div>

    <div class="row justify-content-center">
        @php
            $membres = [
                ['nom' => 'S. Ismaila SOUANE', 'role' => 'Fullstack Developer', 'image' => 'img/sis.jpeg', 'social' => ['github' => '#', 'linkedin' => '#']],
                ['nom' => 'Hadia Rougui SOW', 'role' => 'Frontend Developer', 'image' => 'img/hrs.jpeg', 'social' => ['github' => '#', 'linkedin' => '#']],
                ['nom' => 'Fatou GUEYE', 'role' => 'Project Manager', 'image' => 'img/fg.jpeg', 'social' => ['github' => '#', 'linkedin' => '#']],
                ['nom' => 'Adama NDAO', 'role' => 'Project Manager', 'image' => 'img/admin.jpeg', 'social' => ['github' => '#', 'linkedin' => '#']],
                ['nom' => 'Fatou THIAM', 'role' => 'Project Manager', 'image' => 'img/ft.jpeg', 'social' => ['github' => '#', 'linkedin' => '#']],
            ];
        @endphp

        @foreach ($membres as $membre)
        <div class="col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="team-card text-center p-3">
                <div class="team-img-container mb-3 mx-auto">
                    <img src="{{ asset($membre['image']) }}" alt="{{ $membre['nom'] }}" class="img-fluid rounded-circle">
                    <div class="team-social">
                        <a href="{{ $membre['social']['github'] }}" class="text-white"><i class="fab fa-github"></i></a>
                        <a href="{{ $membre['social']['linkedin'] }}" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <h5 class="font-weight-bold mb-1">{{ $membre['nom'] }}</h5>
                <p class="text-muted small mb-2">{{ $membre['role'] }}</p>
                <div class="divider-sm bg-primary mx-auto"></div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Project Info -->
    <div class="row mt-5 align-items-center">
        <div class="col-lg-6 mb-4" data-aos="fade-right">
            <div class="text-center">
                <img src="{{ asset('img/natt_app.png') }}" alt="Projet NATT-APP" class="img-fluid" style="max-width: 300px;">
            </div>
        </div>
        <div class="col-lg-6 mb-4" data-aos="fade-left">
            <h3 class="font-weight-bold text-primary mb-3">Le Projet Académique</h3>
            <p class="text-muted mb-4">
                Développé dans le cadre du module "Développement Web Avancé", NATT-APP représente 6 mois de travail intensif 
                avec des technologies modernes comme Laravel, Livewire et Tailwind CSS.
            </p>
            <ul class="list-unstyled text-muted">
                <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Gestion complète des tontines</li>
                <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Système de tirages aléatoires équitables</li>
                <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Tableau de bord analytique</li>
                <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Notifications en temps réel</li>
                <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Interface responsive et accessible</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* General Styles */
    .divider {
        width: 80px;
        height: 3px;
    }
    
    .divider-sm {
        width: 50px;
        height: 2px;
    }
    
    /* Feature Cards */
    .feature-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Team Cards */
    .team-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .team-img-container {
        width: 150px;
        height: 150px;
        position: relative;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #4e73df;
    }
    
    .team-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .team-social {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(78, 115, 223, 0.8);
        padding: 10px;
        transform: translateY(100%);
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .team-img-container:hover .team-social {
        transform: translateY(0);
    }
    
    .rounded-lg {
        border-radius: 15px;
    }
    
    @media (max-width: 768px) {
        .team-img-container {
            width: 120px;
            height: 120px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Initialize AOS animations
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>
@endsection