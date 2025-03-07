@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le Tirage</h1>
        <form action="{{ route('tirages.update', $tirage) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tontine_id">Tontine</label>
                <select name="tontine_id" id="tontine_id" class="form-control" required>
                    @foreach ($tontines as $tontine)
                        <option value="{{ $tontine->id }}" {{ $tontine->id === $tirage->tontine_id ? 'selected' : '' }}>{{ $tontine->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">Gagnant</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id === $tirage->user_id ? 'selected' : '' }}>{{ $user->prenom }} {{ $user->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date_tirage">Date du tirage</label>
                <input type="date" name="date_tirage" id="date_tirage" class="form-control" value="{{ $tirage->date_tirage }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection