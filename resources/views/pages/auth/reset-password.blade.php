<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - NATT-APP</title>
    
    <!-- Favicon -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" type="image/png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #224abe;
            --success-color: #1cc88a;
            --light-bg: #f8f9fc;
            --dark-text: #5a5c69;
            --card-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: var(--light-bg);
            color: var(--dark-text);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .password-reset-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 2rem;
        }
        
        .illustration-col {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        
        .illustration {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .password-reset-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .password-reset-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(50, 50, 93, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .card-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .card-header p {
            color: #858796;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .input-group-password {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 5;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d3e2;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        
        .btn-success:hover {
            background-color: #17a673;
            transform: translateY(-2px);
        }
        
        .btn-loading {
            position: relative;
            padding-left: 2.5rem;
        }
        
        .btn-loading .spinner-border {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }
        
        .alert {
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }
        
        .alert-danger {
            background-color: #fdecea;
            border-left-color: #f44336;
            color: #d32f2f;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .back-to-login a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .back-to-login a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        @media (max-width: 991.98px) {
            .password-reset-container {
                flex-direction: column;
            }
            
            .illustration-col {
                padding-bottom: 0;
            }
            
            .illustration {
                max-width: 250px;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="password-reset-container">
        <!-- Illustration Column -->
        <div class="illustration-col" data-aos="fade-right" data-aos-duration="800">
            <img src="https://cdn-icons-png.flaticon.com/512/3064/3064204.png" alt="Réinitialisation mot de passe" class="illustration">
        </div>
        
        <!-- Form Column -->
        <div data-aos="fade-left" data-aos-duration="800">
            <div class="password-reset-card">
                <div class="card-header">
                    <h2>Créer un nouveau mot de passe</h2>
                    <p>Veuillez entrer et confirmer votre nouveau mot de passe</p>
                </div>
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe</label>
                        <div class="input-group-password">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   required 
                                   placeholder="••••••••••••">
                            <i class="bi bi-eye-fill password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Minimum 8 caractères avec des chiffres et lettres</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control" 
                               required 
                               placeholder="••••••••••••">
                    </div>
                    
                    <button type="submit" class="btn btn-success" id="resetButton">
                        <span class="button-text">
                            <i class="bi bi-key-fill me-2"></i>Réinitialiser le mot de passe
                        </span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
                
                <div class="back-to-login">
                    <a href="{{ route('auth.create') }}">
                        <i class="bi bi-arrow-left me-1"></i>Retour à la page de connexion
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS animation
        AOS.init({
            once: true
        });
        
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
        
        // Loading button animation
        document.getElementById('resetForm').addEventListener('submit', function() {
            const btn = document.getElementById('resetButton');
            btn.classList.add('btn-loading');
            btn.querySelector('.button-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
        });
        
        // Focus on password field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            if (passwordField) {
                passwordField.focus();
            }
        });
    </script>
</body>
</html>