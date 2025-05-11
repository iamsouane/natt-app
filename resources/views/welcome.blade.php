@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="hero-section" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white py-5" data-aos="fade-right">
                    <h1 class="display-4 font-weight-bold mb-4">Bienvenue sur Natt-app</h1>
                    <p class="lead mb-4">La solution complète pour gérer vos tontines en toute simplicité et transparence.</p>
                    <div class="d-flex flex-wrap">
                        @auth
                            <a href="{{ auth()->user()->profil === 'PARTICIPANT' ? route('participant.index') : route('tontines.index') }}" 
                               class="btn btn-light btn-lg rounded-pill shadow-sm px-4 mr-3 mb-3">
                               <i class="fas fa-rocket mr-2"></i>Commencer
                            </a>
                        @else
                            <a href="{{ route('auth.create') }}" class="btn btn-light btn-lg rounded-pill shadow-sm px-4 mr-3 mb-3">
                                <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                            </a>
                            <a href="{{ route('inscription.index') }}" class="btn btn-outline-light btn-lg rounded-pill shadow-sm px-4 mb-3">
                                <i class="fas fa-user-plus mr-2"></i>Inscription
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <!-- Illustration SVG intégrée -->
                    <svg width="100%" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                        <style>
                            .cls-1{fill:#f8f9fa;}
                            .cls-2{fill:#4e73df;}
                            .cls-3{fill:#1cc88a;}
                            .cls-4{fill:#f6c23e;}
                            .cls-5{fill:#36b9cc;}
                        </style>
                        <!-- Fond circulaire -->
                        <circle cx="300" cy="200" r="180" fill="rgba(255,255,255,0.1)"/>
                        
                        <!-- Personnages et argent -->
                        <g transform="translate(150, 100)">
                            <!-- Personnage 1 -->
                            <circle cx="60" cy="120" r="30" class="cls-1"/>
                            <path d="M60,150v30a30,30,0,0,1-30,30H30a30,30,0,0,1-30-30V150Z" class="cls-2"/>
                            <circle cx="50" cy="110" r="5" fill="#000"/>
                            <circle cx="70" cy="110" r="5" fill="#000"/>
                            <path d="M55,130Q60,140,65,130" stroke="#000" fill="none" stroke-width="2"/>
                            
                            <!-- Personnage 2 -->
                            <circle cx="180" cy="120" r="30" class="cls-1"/>
                            <path d="M180,150v30a30,30,0,0,0,30,30h0a30,30,0,0,0,30-30V150Z" class="cls-3"/>
                            <circle cx="170" cy="110" r="5" fill="#000"/>
                            <circle cx="190" cy="110" r="5" fill="#000"/>
                            <path d="M175,130Q180,140,185,130" stroke="#000" fill="none" stroke-width="2"/>
                            
                            <!-- Personnage 3 -->
                            <circle cx="120" cy="80" r="30" class="cls-1"/>
                            <path d="M120,110v30a30,30,0,0,1-30,30h0a30,30,0,0,1-30-30V110Z" class="cls-4"/>
                            <circle cx="110" cy="70" r="5" fill="#000"/>
                            <circle cx="130" cy="70" r="5" fill="#000"/>
                            <path d="M115,90Q120,100,125,90" stroke="#000" fill="none" stroke-width="2"/>
                            
                            <!-- Argent et connexions -->
                            <circle cx="120" cy="180" r="25" class="cls-5" opacity="0.8"/>
                            <text x="120" y="185" font-family="Arial" font-size="20" font-weight="bold" fill="white" text-anchor="middle">€</text>
                            
                            <path d="M90,140Q105,150,120,155Q135,150,150,140" stroke="#fff" fill="none" stroke-width="3" stroke-linecap="round"/>
                            <path d="M120,155Q120,170,120,180" stroke="#fff" fill="none" stroke-width="3" stroke-linecap="round"/>
                        </g>
                        
                        <!-- Texte dynamique -->
                        <text x="300" y="380" font-family="Arial" font-size="24" font-weight="bold" fill="white" text-anchor="middle" opacity="0.8">Solidarité • Transparence • Équité</text>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="font-weight-bold text-primary">Pourquoi choisir Natt-app ?</h2>
            <p class="lead text-muted">Découvrez les fonctionnalités qui font la différence</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-primary text-white mb-4 mx-auto">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 17C11.45 17 11 16.55 11 16V12C11 11.45 11.45 11 12 11C12.55 11 13 11.45 13 12V16C13 16.55 12.55 17 12 17ZM12 9C11.45 9 11 8.55 11 8C11 7.45 11.45 7 12 7C12.55 7 13 7.45 13 8C13 8.55 12.55 9 12 9Z" fill="white"/>
                            </svg>
                        </div>
                        <h4 class="font-weight-bold">Sécurisé</h4>
                        <p class="text-muted">Transactions cryptées et données protégées pour une gestion en toute confiance.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-success text-white mb-4 mx-auto">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z" fill="white"/>
                                <path d="M7 12H9V17H7V12ZM11 7H13V17H11V7ZM15 10H17V17H15V10Z" fill="white"/>
                            </svg>
                        </div>
                        <h4 class="font-weight-bold">Transparent</h4>
                        <p class="text-muted">Suivi en temps réel des cotisations et historique complet des opérations.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle bg-warning text-white mb-4 mx-auto">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C6.49 22 2 17.51 2 12C2 6.49 6.49 2 12 2C17.51 2 22 6.49 22 12C22 17.51 17.51 22 12 22ZM12 20C16.43 20 20 16.43 20 12C20 7.57 16.43 4 12 4C7.57 4 4 7.57 4 12C4 16.43 7.57 20 12 20Z" fill="white"/>
                                <path d="M12 7C11.45 7 11 7.45 11 8V13C11 13.55 11.45 14 12 14C12.55 14 13 13.55 13 13V8C13 7.45 12.55 7 12 7Z" fill="white"/>
                                <path d="M12 16C11.45 16 11 16.45 11 17C11 17.55 11.45 18 12 18C12.55 18 13 17.55 13 17C13 16.45 12.55 16 12 16Z" fill="white"/>
                            </svg>
                        </div>
                        <h4 class="font-weight-bold">Notifications</h4>
                        <p class="text-muted">Alertes pour les échéances de cotisation et résultats des tirages.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User-specific Content -->
    @auth
    <div class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="font-weight-bold mb-4">Bon retour, {{ auth()->user()->prenom }} !</h2>
                    
                    @if(auth()->user()->profil === 'PARTICIPANT')
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="text-primary mb-4">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#4e73df"/>
                                        <path d="M12 6C9.79 6 8 7.79 8 10C8 12.21 9.79 14 12 14C14.21 14 16 12.21 16 10C16 7.79 14.21 6 12 6ZM12 12C10.9 12 10 11.1 10 10C10 8.9 10.9 8 12 8C13.1 8 14 8.9 14 10C14 11.1 13.1 12 12 12Z" fill="#4e73df"/>
                                        <path d="M12 16C9.33 16 4 17.34 4 20V22H20V20C20 17.34 14.67 16 12 16ZM6 20C6.22 19.28 9.31 18 12 18C14.7 18 17.8 19.29 18 20H6Z" fill="#4e73df"/>
                                    </svg>
                                    Vos tontines actives
                                </h4>
                                <a href="{{ route('participant.index') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                    Accéder à vos tontines
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="100">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body p-4 text-center">
                                        <h4 class="text-primary mb-3">
                                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                                                <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19Z" fill="#4e73df"/>
                                                <path d="M7 12H9V17H7V12ZM11 7H13V17H11V7ZM15 10H17V17H15V10Z" fill="#4e73df"/>
                                            </svg>
                                            Gestion des tontines
                                        </h4>
                                        <p class="mb-4">Créez et gérez l'ensemble des tontines de votre communauté.</p>
                                        <a href="{{ route('tontines.index') }}" class="btn btn-outline-primary rounded-pill">
                                            Gérer les tontines
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="200">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body p-4 text-center">
                                        <h4 class="text-primary mb-3">
                                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#4e73df"/>
                                                <path d="M12 6C9.79 6 8 7.79 8 10C8 12.21 9.79 14 12 14C14.21 14 16 12.21 16 10C16 7.79 14.21 6 12 6ZM12 12C10.9 12 10 11.1 10 10C10 8.9 10.9 8 12 8C13.1 8 14 8.9 14 10C14 11.1 13.1 12 12 12Z" fill="#4e73df"/>
                                                <path d="M12 16C9.33 16 4 17.34 4 20V22H20V20C20 17.34 14.67 16 12 16ZM6 20C6.22 19.28 9.31 18 12 18C14.7 18 17.8 19.29 18 20H6Z" fill="#4e73df"/>
                                            </svg>
                                            Organisation des tirages
                                        </h4>
                                        <p class="mb-4">Effectuez et suivez les tirages au sort de manière équitable.</p>
                                        <a href="{{ route('tirages.index') }}" class="btn btn-outline-primary rounded-pill">
                                            Gérer les tirages
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endauth
</div>

<style>
    .hero-section {
        position: relative;
        overflow: hidden;
    }
    
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.5rem;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .btn-rounded {
        border-radius: 50px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>
@endsection