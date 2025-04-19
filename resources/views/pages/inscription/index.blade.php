<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Natt-app - Inscription</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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

        small {
            color: red;
        }
    </style>
</head>

<body>
<div class="container-fluid login-section d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-center align-items-center">

        <!-- Illustration à gauche -->
        <div class="col-md-6 text-center d-flex align-items-center justify-content-center">
            <img src="https://cdn-icons-png.flaticon.com/512/9748/9748110.png" alt="Illustration inscription"
                 class="img-fluid" style="max-width: 300px;">
        </div>

        <!-- Formulaire à droite -->
        <div class="col-md-6 col-lg-5">
            <div class="login-card p-4 animate__animated animate__fadeInUp">
                <div class="text-center mb-4">
                    <h2 class="mb-1">Inscription</h2>
                    <p class="text-muted">Créez un compte pour commencer</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('inscription.register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="prenom" class="form-control" placeholder="Votre prénom" value="{{ old('prenom') }}">
                            @error('prenom') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="col">
                            <input type="text" name="nom" class="form-control" placeholder="Votre nom" value="{{ old('nom') }}">
                            @error('nom') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="Votre adresse mail" value="{{ old('email') }}">
                            @error('email') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="col">
                            <input type="text" name="telephone" class="form-control" placeholder="Votre numéro de téléphone" value="{{ old('telephone') }}">
                            @error('telephone') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="date" name="date_naissance" class="form-control" placeholder="Votre date de naissance" value="{{ old('date_naissance') }}">
                            @error('date_naissance') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="col">
                            <input type="text" name="adresse" class="form-control" placeholder="Votre adresse" value="{{ old('adresse') }}">
                            @error('adresse') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="password" name="password" class="form-control" placeholder="Votre mot de passe">
                            @error('password') <small>{{ $message }}</small> @enderror
                        </div>
                        <div class="col">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer votre mot de passe">
                            @error('password_confirmation') <small>{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="cni" class="form-control" placeholder="Votre numéro de carte d'identité nationale" value="{{ old('cni') }}">
                        @error('cni') <small>{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>

                <hr>

                <div class="text-center">
                    <a class="small" href="{{ route('auth.create') }}">Vous avez déjà un compte ? Connectez-vous !</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>