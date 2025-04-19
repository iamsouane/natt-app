<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Natt-app - Connexion</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom style -->
    <style>
        :root {
            --primary-color: #0077b6;
            --background-color: #f1f5f9;
            --card-radius: 1.5rem;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f1f5f9, #e0f2fe);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-section {
            min-height: 100vh;
        }

        .login-card {
            background: white;
            border-radius: var(--card-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.8s ease-in-out;
        }

        .login-card h2 {
            color: var(--primary-color);
            font-weight: 700;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #005f8e;
        }

        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading .spinner-border {
            width: 1rem;
            height: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 119, 182, 0.25);
        }

        .illustration {
            max-width: 100%;
            height: auto;
            animation: zoomIn 1s ease;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            0% {
                transform: scale(0.95);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        a.small {
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        a.small:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container-fluid login-section d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center align-items-center">
            
            <!-- Illustration à gauche -->
            <div class="col-md-6 text-center d-flex align-items-center justify-content-center">
                <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Illustration connexion" class="img-fluid" style="max-width: 300px;">
            </div>            

            <!-- Formulaire à droite -->
            <div class="col-md-6 col-lg-4">
                <div class="login-card p-4 animate__animated animate__fadeInUp">
                    <div class="text-center mb-4">
                        <h2 class="mb-1">Connexion</h2>
                        <p class="text-muted">Connectez-vous à votre compte</p>
                    </div>

                    @if ($errors->has('login'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $errors->first('login') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.store') }}" id="loginForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required autofocus placeholder="email@exemple.com">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required placeholder="••••••••••••">
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="loginButton">
                            <span class="button-text">Se connecter</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a class="small" href="{{ route('password.forgot') }}">Mot de passe oublié ?</a>
                    </div>

                    <div class="text-center mt-2">
                        <a class="small" href="{{ route('inscription.index') }}">Créer un compte !</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour bouton animé -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('loginButton');
            btn.classList.add('btn-loading');
            btn.querySelector('.button-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
        });
    </script>

</body>
</html>