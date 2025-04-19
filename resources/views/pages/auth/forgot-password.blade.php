<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        
        .forgot-password-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: row;
        }

        .forgot-password-container {
            max-width: 450px;
            margin: 40px;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .forgot-password-container h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #0077b6;
            font-weight: 700;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
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

        .btn-primary {
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

        .btn-primary:hover {
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

        .forgot-password-image {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
    </style>
</head>
<body>

<div class="forgot-password-section">
    <!-- Illustration à gauche -->
    <div style="flex: 1; display: flex; justify-content: center; align-items: center;">
        <img src="https://cdn-icons-png.flaticon.com/512/3064/3064204.png" alt="Mot de passe oublié" class="forgot-password-image">
    </div>

    <!-- Formulaire à droite -->
    <div style="flex: 1;">
        <div class="forgot-password-container">
            <h3>Mot de passe oublié</h3>

            {{-- Affichage des erreurs de validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Affichage d’un message d’erreur venant du contrôleur --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.verifyEmail') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="ex: nom@exemple.com">
                </div>
                <button type="submit" class="btn btn-primary">Continuer</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>