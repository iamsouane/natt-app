@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Créer un Tirage pour la Tontine : {{ $tontine->libelle }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <p>Le tirage sera effectué parmi les participants qui n'ont pas encore gagné dans cette tontine. Un seul gagnant sera choisi aléatoirement.</p>

        <form action="{{ route('tirages.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_tontine" value="{{ $tontine->id }}">

            <div class="form-group">
                <label for="id_user">Choisir un participant</label>
                <select name="id_user" id="id_user" class="form-control">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-4">Effectuer le Tirage</button>
        </form>
    </div>
@endsection
