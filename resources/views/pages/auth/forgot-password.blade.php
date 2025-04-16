@extends('layouts.app')

@section('content')
<div class="container">
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
            <label>Email :</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Continuer</button>
    </form>
</div>
@endsection