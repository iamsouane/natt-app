@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Réinitialiser le mot de passe</h3>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-group">
            <label>Nouveau mot de passe :</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Confirmer le mot de passe :</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Réinitialiser</button>
    </form>
</div>
@endsection