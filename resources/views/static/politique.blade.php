@extends('layouts.app')

@section('title', 'Politique de Confidentialité - NATT-APP')

@section('content')
<div class="container py-5" data-aos="fade-up">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold text-primary mb-3">Politique de Confidentialité</h1>
        <div class="divider mx-auto bg-primary mb-4"></div>
        <p class="lead text-muted mx-auto" style="max-width: 800px;">
            Chez NATT-APP, nous prenons votre vie privée au sérieux. Cette politique explique comment nous collectons, utilisons et protégeons vos informations.
        </p>
    </div>

    <div class="row align-items-center mb-5">
        <!-- Illustration -->
        <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
            <div class="privacy-illustration p-4 text-center">
                <svg width="100%" height="auto" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                    <style>
                        .cls-1{fill:#f8f9fa;}
                        .cls-2{fill:#4e73df;}
                        .cls-3{fill:#1cc88a;}
                        .cls-4{fill:#ffffff;}
                    </style>
                    <!-- Background -->
                    <rect width="600" height="400" fill="#f8f9fa" rx="20" ry="20"/>
                    
                    <!-- Shield -->
                    <path d="M300,50 L500,150 L500,300 L300,400 L100,300 L100,150 Z" fill="#ffffff" stroke="#4e73df" stroke-width="3"/>
                    <path d="M300,70 L480,160 L480,290 L300,380 L120,290 L120,160 Z" fill="#4e73df" opacity="0.1"/>
                    
                    <!-- Lock -->
                    <rect x="250" y="200" width="100" height="120" fill="#ffffff" stroke="#1cc88a" stroke-width="3" rx="10" ry="10"/>
                    <circle cx="300" cy="230" r="30" fill="#1cc88a"/>
                    <rect x="270" y="230" width="60" height="5" fill="#ffffff"/>
                </svg>
            </div>
        </div>

        <!-- Introduction -->
        <div class="col-lg-6" data-aos="fade-left">
            <div class="privacy-card p-5 shadow-sm rounded-lg">
                <h3 class="font-weight-bold text-primary mb-4">Protection de vos données</h3>
                <p class="mb-4">Nous nous engageons à protéger votre vie privée et à traiter vos données personnelles de manière transparente et sécurisée, conformément au Règlement Général sur la Protection des Données (RGPD).</p>
                
                <div class="privacy-point mb-3">
                    <div class="icon-circle-sm bg-primary text-white mr-3">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <span class="font-weight-bold">Sécurité renforcée</span> - Cryptage des données et mesures de sécurité avancées
                </div>
                
                <div class="privacy-point mb-3">
                    <div class="icon-circle-sm bg-success text-white mr-3">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <span class="font-weight-bold">Contrôle total</span> - Vous pouvez modifier ou supprimer vos données à tout moment
                </div>
                
                <div class="privacy-point">
                    <div class="icon-circle-sm bg-warning text-white mr-3">
                        <i class="fas fa-ban"></i>
                    </div>
                    <span class="font-weight-bold">Pas de partage</span> - Vos données ne sont jamais vendues à des tiers
                </div>
            </div>
        </div>
    </div>

    <!-- Policy Sections -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-5">
                    <h3 class="font-weight-bold text-primary mb-4">
                        <i class="fas fa-database text-primary mr-2"></i> Données collectées
                    </h3>
                    <p class="mb-4">Nous collectons uniquement les informations nécessaires au bon fonctionnement de notre service :</p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Informations de compte (nom, email, téléphone)</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Historique des transactions financières</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary mr-2"></i> Données de connexion (adresse IP, appareil)</li>
                        <li><i class="fas fa-check-circle text-primary mr-2"></i> Préférences et paramètres du compte</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-5">
                    <h3 class="font-weight-bold text-primary mb-4">
                        <i class="fas fa-lock text-primary mr-2"></i> Protection des données
                    </h3>
                    <p>Nous mettons en œuvre des mesures techniques et organisationnelles strictes pour protéger vos données :</p>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <div class="security-feature p-3 rounded">
                                <div class="icon-circle-sm bg-primary text-white mb-2">
                                    <i class="fas fa-key"></i>
                                </div>
                                <h5 class="font-weight-bold">Cryptage SSL</h5>
                                <p class="small text-muted">Toutes les communications sont cryptées avec TLS 1.2+</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="security-feature p-3 rounded">
                                <div class="icon-circle-sm bg-success text-white mb-2">
                                    <i class="fas fa-server"></i>
                                </div>
                                <h5 class="font-weight-bold">Stockage sécurisé</h5>
                                <p class="small text-muted">Hébergement certifié ISO 27001 en Europe</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="security-feature p-3 rounded">
                                <div class="icon-circle-sm bg-warning text-white mb-2">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <h5 class="font-weight-bold">Accès restreint</h5>
                                <p class="small text-muted">Seul le personnel autorisé y a accès</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="security-feature p-3 rounded">
                                <div class="icon-circle-sm bg-info text-white mb-2">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                                <h5 class="font-weight-bold">Sauvegardes</h5>
                                <p class="small text-muted">Sauvegardes quotidiennes et cryptées</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h3 class="font-weight-bold text-primary mb-4">
                        <i class="fas fa-gavel text-primary mr-2"></i> Vos droits
                    </h3>
                    <p>Conformément à la réglementation, vous disposez des droits suivants :</p>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4 h-100">
                                <h5 class="font-weight-bold text-primary"><i class="fas fa-eye mr-2"></i> Droit d'accès</h5>
                                <p class="text-muted">Demander une copie de vos données personnelles</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4 h-100">
                                <h5 class="font-weight-bold text-primary"><i class="fas fa-edit mr-2"></i> Droit de rectification</h5>
                                <p class="text-muted">Corriger des informations inexactes</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4 h-100">
                                <h5 class="font-weight-bold text-primary"><i class="fas fa-trash-alt mr-2"></i> Droit à l'effacement</h5>
                                <p class="text-muted">Demander la suppression de vos données</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4 h-100">
                                <h5 class="font-weight-bold text-primary"><i class="fas fa-file-download mr-2"></i> Droit à la portabilité</h5>
                                <p class="text-muted">Obtenir vos données dans un format lisible</p>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3">Pour exercer ces droits, contactez-nous à <a href="mailto:privacy@natt-app.com">privacy@natt-app.com</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Effective Date -->
    <div class="text-center mt-5">
        <div class="effective-date p-3 d-inline-block">
            <p class="mb-0 text-muted"><small>Dernière mise à jour : {{ now()->format('d/m/Y') }}</small></p>
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
    
    /* Privacy Illustration */
    .privacy-illustration {
        background-color: #f8f9fa;
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* Privacy Card */
    .privacy-card {
        background: white;
        border-radius: 15px;
    }
    
    .privacy-point {
        display: flex;
        align-items: center;
        padding: 0.8rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .privacy-point:hover {
        background-color: #f8f9fa;
    }
    
    .icon-circle-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    /* Security Features */
    .security-feature {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .security-feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Rights Cards */
    .rights-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .rights-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Effective Date */
    .effective-date {
        background-color: #f8f9fa;
        border-radius: 20px;
    }
    
    @media (max-width: 768px) {
        .privacy-card {
            padding: 2rem;
        }
        
        .privacy-point {
            padding: 0.5rem;
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