@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des tontines</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nom de la Tontine</th>
                <th>Nombre de Participants</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tontines as $tontine)
                <tr>
                    <td>{{ $tontine->libelle }}</td>
                    <td>{{ $tontine->nbre_participant }}</td> <!-- Afficher directement le nombre de participants -->
                    <td>
                        <a href="{{ route('gestion.show', $tontine->id) }}" class="btn btn-info">Voir détails</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection