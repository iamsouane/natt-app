@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier le profil</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('participant.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe (laisser vide si inchangé)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="form-group mt-3">
            <label for="image">Image de profil / CNI</label>
            <input type="file" name="image" class="form-control-file">

            @if($user->participant && $user->participant->image_cni)
                <div class="mt-2">
                    <p>Image actuelle :</p>
                    <img src="{{ asset('storage/' . $user->participant->image_cni) }}" alt="Image actuelle" class="img-thumbnail" style="max-height: 150px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-4">Enregistrer</button>
    </form>
</div>
@endsection