<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Natt-app - Connexion</title>

    <!-- Favicon -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom style -->
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #224abe;
            --secondary-color: #f6c23e;
            --background-gradient: linear-gradient(135deg, #f8f9fc 0%, #e3e6f0 100%);
            --card-radius: 1rem;
            --shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            overflow-x: hidden;
            color: #5a5c69;
        }

        .login-container {
            min-height: 100vh;
        }

        .login-card {
            background: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(50, 50, 93, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            background: var(--primary-color);
            padding: 1.5rem;
            color: white;
            text-align: center;
        }

        .login-header h2 {
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        .login-body {
            padding: 2rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-loading {
            pointer-events: none;
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

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d3e2;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fc;
            border-radius: 0.5rem 0 0 0.5rem !important;
        }

        .password-toggle {
            cursor: pointer;
            background-color: #f8f9fc;
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0 !important;
        }

        .password-toggle:hover {
            background-color: #e3e6f0;
        }

        .illustration-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .illustration {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
        }

        .auth-links a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .auth-links a:hover {
            color: var(--primary-dark);
            transform: translateX(3px);
        }

        .auth-links a i {
            transition: transform 0.3s ease;
        }

        .auth-links a:hover i {
            transform: translateX(5px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e3e6f0;
        }

        .divider-text {
            padding: 0 1rem;
            color: #b7b9cc;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 991.98px) {
            .illustration-container {
                padding: 3rem 0;
            }
            
            .login-card {
                margin-bottom: 3rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container">
        <div class="row align-items-center justify-content-center min-vh-100">
            <!-- Illustration Column -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="illustration-container" data-aos="fade-right" data-aos-duration="1000">
                    <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Illustration connexion" class="illustration" style="max-width: 80%;">
                </div>
            </div>

            <!-- Login Form Column -->
            <div class="col-lg-5 col-md-8" data-aos="fade-left" data-aos-duration="1000">
                <div class="login-card">
                    <div class="login-header">
                        <h2>Bienvenue sur Natt-app</h2>
                        <p>Connectez-vous pour gérer vos tontines</p>
                    </div>

                    <div class="login-body">
                        @if ($errors->has('login'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ $errors->first('login') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('auth.store') }}" id="loginForm">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>
                                    <input type="email" 
                                           name="email" 
                                           id="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" 
                                           required 
                                           autofocus 
                                           placeholder="email@exemple.com">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block mt-1">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required 
                                           placeholder="••••••••••••">
                                    <span class="input-group-text password-toggle" id="togglePassword">
                                        <i class="bi bi-eye-fill" id="toggleIcon"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-1">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="{{ route('password.forgot') }}" class="small text-end auth-links">
                                    Mot de passe oublié ? <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" id="loginButton">
                                <span class="button-text">Se connecter</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>

                            <div class="divider">
                                <span class="divider-text">Ou</span>
                            </div>

                            <div class="text-center mt-3">
                                <p class="mb-0">Vous n'avez pas de compte ? 
                                    <a href="{{ route('inscription.index') }}" class="auth-links">
                                        S'inscrire <i class="bi bi-arrow-right"></i>
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Initialize AOS animation
        AOS.init({
            once: true
        });

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            
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
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginButton');
            btn.classList.add('btn-loading');
            btn.querySelector('.button-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
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