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
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #224abe;
            --secondary-color: #f6c23e;
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
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
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
        
        .alert-success {
            background-color: #e8f5e9;
            border-left-color: #4caf50;
            color: #388e3c;
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
            <img src="https://cdn-icons-png.flaticon.com/512/3064/3064204.png" alt="Mot de passe oublié" class="illustration">
        </div>
        
        <!-- Form Column -->
        <div data-aos="fade-left" data-aos-duration="800">
            <div class="password-reset-card">
                <div class="card-header">
                    <h2>Mot de passe oublié ?</h2>
                    <p>Entrez votre email pour réinitialiser votre mot de passe</p>
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
                
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.verifyEmail') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-right-0">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control border-left-0" 
                                   required 
                                   placeholder="exemple@email.com"
                                   value="{{ old('email') }}">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill me-2"></i>Envoyer le lien de réinitialisation
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
        
        // Focus on email field when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField) {
                emailField.focus();
            }
        });
    </script>
</body>
</html>