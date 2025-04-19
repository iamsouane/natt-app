<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            max-width: 450px;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .login-card h2 {
            color: #0077b6;
            font-weight: 700;
        }

        .form-group label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #0077b6;
            box-shadow: 0 0 0 2px rgba(0, 119, 182, 0.2);
        }

        .btn-success {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background-color: #0077b6;
            border: none;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .btn-success:hover {
            background-color: #005f87;
        }

        .alert {
            border-radius: 10px;
            padding: 15px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #ffe5e5;
            border-left: 5px solid #dc3545;
            color: #a94442;
        }

        .login-section img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
    </style>
</head>
<body>

<div class="login-section">
    <div class="row w-100">
        <!-- Illustration à gauche -->
        <div class="col-md-6 text-center d-flex align-items-center justify-content-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3064/3064204.png" alt="Illustration réinitialisation mot de passe" class="img-fluid" style="max-width: 250px;">
        </div>

        <!-- Formulaire à droite -->
        <div class="col-md-6 col-lg-4">
            <div class="login-card">
                <div class="text-center mb-4">
                    <h2 class="mb-1">Réinitialiser le mot de passe</h2>
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

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group mb-3">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••••••">
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="••••••••••••">
                    </div>

                    <button type="submit" class="btn btn-success w-100" id="resetButton">
                        <span class="button-text">Réinitialiser</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a class="small" href="{{ route('auth.create') }}">Retour à la connexion</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour bouton animé -->
<script>
    document.getElementById('resetButton').addEventListener('click', function () {
        const btn = document.getElementById('resetButton');
        btn.classList.add('btn-loading');
        btn.querySelector('.button-text').classList.add('d-none');
        btn.querySelector('.spinner-border').classList.remove('d-none');
    });
</script>

</body>
</html>