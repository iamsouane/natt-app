@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #74ebd5, #ACB6E5);
        font-family: 'Segoe UI', sans-serif;
    }

    .profile-container {
        max-width: 600px;
        margin: 4rem auto;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .form-control:focus {
        border-color: #0077b6;
        box-shadow: 0 0 0 0.2rem rgba(0, 119, 182, 0.25);
    }

    .btn-primary {
        background-color: #0077b6;
        border-color: #0077b6;
    }

    .btn-primary:hover {
        background-color: #005f8a;
        border-color: #005f8a;
    }

    .illustration {
        width: 100%;
        max-width: 400px;
        height: auto;
        margin: 0 auto 2rem auto;
        display: block;
    }

    .img-thumbnail {
        border-radius: 0.75rem;
        max-height: 150px;
    }
</style>

<div class="container">
    <div class="profile-container text-center">

        {{-- 🖼️ Illustration SVG complète --}}
        <div>
            <svg class="illustration" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 850 600" fill="none">
                <rect width="850" height="600" fill="none"/>
                <path d="M661.5 301.5c0 112.1-90.9 203-203 203s-203-90.9-203-203 90.9-203 203-203 203 90.9 203 203z" fill="#0077b6" opacity="0.1"/>
                <circle cx="425" cy="240" r="70" fill="#0077b6"/>
                <rect x="335" y="340" width="180" height="40" rx="20" fill="#0077b6"/>
                <rect x="310" y="400" width="230" height="20" rx="10" fill="#0077b6" opacity="0.4"/>
                <path d="M570 120h150v20H570zM570 160h120v20H570zM570 200h90v20H570z" fill="#0077b6" opacity="0.3"/>
                <circle cx="585" cy="240" r="25" fill="#0077b6"/>
                <path d="M570 280h100v15H570z" fill="#0077b6" opacity="0.3"/>
            </svg>
        </div>

        <h2 class="mb-4">📝 Modifier mon profil</h2>

        {{-- ✅ Succès --}}
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- 🔴 Erreurs --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('participant.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group text-left">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
            </div>

            <div class="form-group text-left">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
            </div>

            <div class="form-group text-left">
                <label for="password">Nouveau mot de passe <small class="text-muted">(laisser vide si inchangé)</small></label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group text-left">
                <label for="password_confirmation">Confirmation du mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>

            <div class="form-group text-left">
                <label for="image">Image de profil</label>
                <input type="file" name="image" id="image" class="form-control">

                @if($user->participant && $user->participant->image_cni)
                    <div class="mt-3 text-center">
                        <p class="font-weight-bold">Image actuelle :</p>
                        <img src="{{ asset('storage/' . $user->participant->image_cni) }}" alt="Image actuelle" class="img-thumbnail">
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-block">💾 Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection