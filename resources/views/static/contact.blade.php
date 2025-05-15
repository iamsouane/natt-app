@extends('layouts.app')

@section('title', 'Contactez-nous - NATT-APP')

@section('content')
<div class="container py-5" data-aos="fade-up">
    <!-- Header Section -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold text-primary mb-3">Contactez notre équipe</h1>
        <div class="divider mx-auto bg-primary mb-4"></div>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Vous avez des questions, des suggestions ou besoin d'assistance ? Notre équipe est là pour vous aider.
        </p>
    </div>

    <div class="row align-items-center">
        <!-- Contact Illustration -->
        <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
            <div class="contact-illustration p-4">
                <svg width="100%" height="auto" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                    <style>
                        .cls-1{fill:#f8f9fa;}
                        .cls-2{fill:#4e73df;}
                        .cls-3{fill:#1cc88a;}
                    </style>
                    <!-- Background -->
                    <rect width="600" height="400" fill="#f8f9fa" rx="20" ry="20"/>
                    
                    <!-- Envelope -->
                    <path d="M100,100 L500,100 L300,250 Z" fill="#ffffff" stroke="#4e73df" stroke-width="3"/>
                    <rect x="100" y="100" width="400" height="200" fill="#ffffff" stroke="#4e73df" stroke-width="3" rx="5" ry="5"/>
                    
                    <!-- Message lines -->
                    <rect x="150" y="150" width="300" height="10" fill="#e9ecef" rx="5" ry="5"/>
                    <rect x="150" y="180" width="250" height="10" fill="#e9ecef" rx="5" ry="5"/>
                    <rect x="150" y="210" width="200" height="10" fill="#e9ecef" rx="5" ry="5"/>
                    
                    <!-- Contact icons -->
                    <circle cx="450" cy="300" r="40" fill="#4e73df"/>
                    <path d="M435,285 L465,285 L465,315 L435,315 Z" fill="#ffffff"/>
                    <path d="M440,290 L460,290 L460,310 L440,310 Z" fill="#4e73df"/>
                    
                    <circle cx="150" cy="300" r="40" fill="#1cc88a"/>
                    <path d="M135,285 L165,285 L165,300 L150,315 L135,300 Z" fill="#ffffff"/>
                </svg>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-6" data-aos="fade-left">
            <div class="contact-card p-5 shadow-sm rounded-lg">
                <h3 class="font-weight-bold text-primary mb-4">Informations de contact</h3>
                
                <div class="contact-method mb-4">
                    <div class="icon-circle bg-primary text-white mb-3">
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Email</h5>
                    <p class="text-muted">support@natt-app.com</p>
                    <a href="mailto:support@natt-app.com" class="btn btn-outline-primary btn-sm">Envoyer un email</a>
                </div>
                
                <div class="contact-method mb-4">
                    <div class="icon-circle bg-success text-white mb-3">
                        <i class="fas fa-phone-alt fa-lg"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Téléphone</h5>
                    <p class="text-muted">+221 77 571 0440</p>
                    <a href="tel:+221775710440" class="btn btn-outline-success btn-sm">Appeler maintenant</a>
                </div>
                
                <div class="contact-method">
                    <div class="icon-circle bg-warning text-white mb-3">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Adresse</h5>
                    <p class="text-muted">Université Alioune Diop, Bambey, Sénégal</p>
                    <a href="https://maps.app.goo.gl/R5kgQXHgLjJHmhuM8" target="_blank" class="btn btn-outline-warning btn-sm">Voir sur la carte</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form Section -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto" data-aos="fade-up">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h3 class="font-weight-bold text-primary mb-4">Envoyez-nous un message</h3>
                    
                    @auth
                        <form method="POST" action="{{ route('contact.send') }}" id="contact-form">
                            @csrf
                            <div class="form-group">
                                <label for="subject">Sujet</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Objet du message" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Votre message..." required></textarea>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                Le message sera envoyé depuis votre adresse email : <strong>{{ auth()->user()->email }}</strong>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane mr-2"></i> Envoyer le message
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Vous devez <a href="{{ route('auth.create') }}" class="alert-link">vous connecter</a> pour pouvoir envoyer un message à l'administrateur.
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('auth.create') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
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
    
    /* Contact Illustration */
    .contact-illustration {
        background-color: #f8f9fa;
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    /* Contact Card */
    .contact-card {
        background: white;
        border-radius: 15px;
    }
    
    .contact-method {
        padding: 1.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .contact-method:hover {
        background-color: #f8f9fa;
        transform: translateY(-5px);
    }
    
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Form Styles */
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    textarea.form-control {
        min-height: 150px;
    }
    
    @media (max-width: 768px) {
        .contact-card {
            padding: 2rem;
        }
        
        .contact-method {
            padding: 1rem;
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

        // Empêcher la soumission si non connecté (sécurité supplémentaire)
        const contactForm = document.getElementById('contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                @guest
                    e.preventDefault();
                    alert('Veuillez vous connecter pour envoyer un message');
                    window.location.href = "{{ route('auth.create') }}";
                @endguest
            });
        }
    });
</script>
@endsection