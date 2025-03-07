@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer un Tirage</h1>
        <form action="{{ route('tirages.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="tontine_id">Tontine</label>
                <select name="tontine_id" id="tontine_id" class="form-control" required>
                    @foreach ($tontines as $tontine)
                        <option value="{{ $tontine->id }}">{{ $tontine->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">Gagnant</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date_tirage">Date du tirage</label>
                <input type="date" name="date_tirage" id="date_tirage" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
@endsection